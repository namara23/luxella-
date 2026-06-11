import { useState, useEffect } from "react";
import { useNavigate, Link } from "react-router-dom";
import { supabase } from "@/integrations/supabase/client";
import { useAuth } from "@/hooks/useAuth";
import { toast } from "@/hooks/use-toast";
import { z } from "zod";

const schema = z.object({
  email: z.string().trim().email("Enter a valid email").max(255),
  password: z.string().min(6, "At least 6 characters").max(72),
});

const Auth = () => {
  const navigate = useNavigate();
  const { user, isAdmin, loading } = useAuth();
  const [mode, setMode] = useState<"signin" | "signup">("signin");
  const [busy, setBusy] = useState(false);

  useEffect(() => {
    if (!loading && user) navigate(isAdmin ? "/admin" : "/", { replace: true });
  }, [user, isAdmin, loading, navigate]);

  const submit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    const fd = new FormData(e.currentTarget);
    const parsed = schema.safeParse(Object.fromEntries(fd));
    if (!parsed.success) {
      toast({ title: "Check your details", description: parsed.error.errors[0].message, variant: "destructive" });
      return;
    }
    setBusy(true);
    try {
      if (mode === "signup") {
        const { error } = await supabase.auth.signUp({
          email: parsed.data.email,
          password: parsed.data.password,
          options: { emailRedirectTo: `${window.location.origin}/admin` },
        });
        if (error) throw error;
        toast({ title: "Account created", description: "You can now sign in. Ask the owner to grant admin access." });
        setMode("signin");
      } else {
        const { error } = await supabase.auth.signInWithPassword({ email: parsed.data.email, password: parsed.data.password });
        if (error) throw error;
      }
    } catch (err: any) {
      toast({ title: "Authentication failed", description: err.message, variant: "destructive" });
    } finally {
      setBusy(false);
    }
  };

  return (
    <main className="min-h-screen flex items-center justify-center bg-secondary/40 px-4">
      <div className="w-full max-w-md bg-card p-10 shadow-soft">
        <Link to="/" className="text-xs uppercase tracking-[0.25em] text-muted-foreground hover:text-accent">← Back to site</Link>
        <h1 className="font-display text-4xl mt-6 mb-2">Admin {mode === "signin" ? "Sign in" : "Sign up"}</h1>
        <p className="text-sm text-muted-foreground mb-8">Manage products, gallery and leads.</p>
        <form onSubmit={submit} className="space-y-5">
          <div>
            <label className="block text-[10px] uppercase tracking-[0.25em] text-muted-foreground mb-2">Email</label>
            <input name="email" type="email" required className="w-full bg-transparent border-b border-border focus:border-accent focus:outline-none py-3" />
          </div>
          <div>
            <label className="block text-[10px] uppercase tracking-[0.25em] text-muted-foreground mb-2">Password</label>
            <input name="password" type="password" required minLength={6} className="w-full bg-transparent border-b border-border focus:border-accent focus:outline-none py-3" />
          </div>
          <button type="submit" disabled={busy} className="w-full px-8 py-4 bg-primary text-primary-foreground text-xs uppercase tracking-[0.25em] hover:bg-accent hover:text-accent-foreground transition-colors disabled:opacity-60">
            {busy ? "Please wait..." : mode === "signin" ? "Sign in" : "Create account"}
          </button>
        </form>
        <button onClick={() => setMode(mode === "signin" ? "signup" : "signin")} className="mt-6 text-xs uppercase tracking-[0.2em] text-accent hover:text-primary w-full text-center">
          {mode === "signin" ? "Need an account? Sign up" : "Have an account? Sign in"}
        </button>
      </div>
    </main>
  );
};

export default Auth;
