import { useEffect, useState } from "react";
import { Link, Navigate } from "react-router-dom";
import { supabase } from "@/integrations/supabase/client";
import { useAuth } from "@/hooks/useAuth";
import { toast } from "@/hooks/use-toast";
import { Loader2, Plus, Trash2, LogOut, Upload, Image as ImgIcon, Package, MessageSquare } from "lucide-react";

type Tab = "products" | "gallery" | "leads";

type Product = {
  id: string; name: string; category: string; description: string | null;
  price_ugx: number | null; image_url: string | null; featured: boolean; published: boolean; sort_order: number;
};

type GalleryImage = { id: string; image_url: string; caption: string | null; sort_order: number; published: boolean; };

type Lead = { id: string; name: string; phone: string; email: string | null; interest: string | null; message: string; created_at: string; };

const uploadImage = async (file: File): Promise<string | null> => {
  const ext = file.name.split(".").pop();
  const path = `${crypto.randomUUID()}.${ext}`;
  const { error } = await supabase.storage.from("luxella-media").upload(path, file);
  if (error) { toast({ title: "Upload failed", description: error.message, variant: "destructive" }); return null; }
  // private bucket — use a very long-lived signed URL (10 years)
  const { data: signed } = await supabase.storage.from("luxella-media").createSignedUrl(path, 60 * 60 * 24 * 365 * 10);
  return signed?.signedUrl ?? null;
};

const Admin = () => {
  const { user, isAdmin, loading, signOut } = useAuth();
  const [tab, setTab] = useState<Tab>("products");

  if (loading) return <div className="min-h-screen flex items-center justify-center"><Loader2 className="animate-spin" /></div>;
  if (!user) return <Navigate to="/auth" replace />;
  if (!isAdmin) return (
    <div className="min-h-screen flex items-center justify-center p-6">
      <div className="max-w-md text-center">
        <h1 className="font-display text-3xl mb-3">No admin access</h1>
        <p className="text-muted-foreground mb-6">Your account ({user.email}) doesn't have admin rights. Ask the site owner to grant access in the backend.</p>
        <button onClick={signOut} className="px-6 py-3 bg-primary text-primary-foreground text-xs uppercase tracking-[0.2em]">Sign out</button>
      </div>
    </div>
  );

  return (
    <div className="min-h-screen bg-secondary/30">
      <header className="bg-card border-b border-border">
        <div className="container-luxe flex items-center justify-between h-16">
          <Link to="/" className="font-display text-xl">Luxella <span className="text-accent">Admin</span></Link>
          <div className="flex items-center gap-4">
            <span className="hidden md:inline text-xs text-muted-foreground">{user.email}</span>
            <button onClick={signOut} className="flex items-center gap-2 text-xs uppercase tracking-[0.2em] hover:text-accent">
              <LogOut className="w-4 h-4" /> Sign out
            </button>
          </div>
        </div>
      </header>

      <div className="container-luxe py-10">
        <nav className="flex gap-2 mb-8 border-b border-border">
          {[
            { id: "products", label: "Products", icon: Package },
            { id: "gallery", label: "Gallery", icon: ImgIcon },
            { id: "leads", label: "Leads", icon: MessageSquare },
          ].map(t => (
            <button key={t.id} onClick={() => setTab(t.id as Tab)}
              className={`flex items-center gap-2 px-5 py-3 text-xs uppercase tracking-[0.2em] border-b-2 -mb-px transition-colors ${tab === t.id ? "border-accent text-accent" : "border-transparent text-muted-foreground hover:text-foreground"}`}>
              <t.icon className="w-4 h-4" /> {t.label}
            </button>
          ))}
        </nav>

        {tab === "products" && <ProductsPanel />}
        {tab === "gallery" && <GalleryPanel />}
        {tab === "leads" && <LeadsPanel />}
      </div>
    </div>
  );
};

const ProductsPanel = () => {
  const [items, setItems] = useState<Product[]>([]);
  const [saving, setSaving] = useState(false);

  const load = async () => {
    const { data } = await supabase.from("products").select("*").order("sort_order").order("created_at", { ascending: false });
    setItems((data ?? []) as Product[]);
  };
  useEffect(() => { load(); }, []);

  const onSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setSaving(true);
    const form = e.currentTarget;
    const fd = new FormData(form);
    const file = (fd.get("image") as File);
    let image_url: string | null = null;
    if (file && file.size > 0) image_url = await uploadImage(file);
    const payload = {
      name: String(fd.get("name") || "").trim(),
      category: String(fd.get("category") || "").trim(),
      description: String(fd.get("description") || "").trim() || null,
      price_ugx: fd.get("price_ugx") ? Number(fd.get("price_ugx")) : null,
      featured: fd.get("featured") === "on",
      published: true,
      image_url,
    };
    if (!payload.name || !payload.category) { toast({ title: "Name and category required", variant: "destructive" }); setSaving(false); return; }
    const { error } = await supabase.from("products").insert(payload);
    if (error) toast({ title: "Save failed", description: error.message, variant: "destructive" });
    else { toast({ title: "Product added" }); form.reset(); load(); }
    setSaving(false);
  };

  const remove = async (id: string) => {
    if (!confirm("Delete this product?")) return;
    const { error } = await supabase.from("products").delete().eq("id", id);
    if (error) toast({ title: "Delete failed", description: error.message, variant: "destructive" });
    else { toast({ title: "Deleted" }); load(); }
  };

  const togglePublished = async (p: Product) => {
    await supabase.from("products").update({ published: !p.published }).eq("id", p.id);
    load();
  };

  return (
    <div className="grid lg:grid-cols-3 gap-8">
      <form onSubmit={onSubmit} className="lg:col-span-1 bg-card p-6 space-y-4 h-fit">
        <h2 className="font-display text-2xl mb-2">Add product</h2>
        <input name="name" placeholder="Name" required maxLength={120} className="w-full bg-transparent border-b border-border focus:border-accent outline-none py-2" />
        <input name="category" placeholder="Category (e.g. Living Room)" required maxLength={60} className="w-full bg-transparent border-b border-border focus:border-accent outline-none py-2" />
        <textarea name="description" placeholder="Description" rows={3} maxLength={800} className="w-full bg-transparent border-b border-border focus:border-accent outline-none py-2 resize-none" />
        <input name="price_ugx" type="number" min="0" placeholder="Price in UGX (optional)" className="w-full bg-transparent border-b border-border focus:border-accent outline-none py-2" />
        <label className="flex items-center gap-2 text-sm cursor-pointer">
          <input name="image" type="file" accept="image/*" className="text-xs" />
        </label>
        <label className="flex items-center gap-2 text-sm">
          <input name="featured" type="checkbox" /> Featured
        </label>
        <button disabled={saving} className="w-full px-6 py-3 bg-primary text-primary-foreground text-xs uppercase tracking-[0.2em] hover:bg-accent disabled:opacity-60 flex items-center justify-center gap-2">
          {saving ? <Loader2 className="w-4 h-4 animate-spin" /> : <Plus className="w-4 h-4" />} Add product
        </button>
      </form>

      <div className="lg:col-span-2 space-y-3">
        {items.length === 0 && <p className="text-muted-foreground">No products yet.</p>}
        {items.map(p => (
          <div key={p.id} className="bg-card p-4 flex gap-4 items-center">
            <div className="w-20 h-20 bg-muted shrink-0 overflow-hidden">
              {p.image_url && <img src={p.image_url} alt={p.name} className="w-full h-full object-cover" />}
            </div>
            <div className="flex-1 min-w-0">
              <div className="flex items-center gap-2">
                <h3 className="font-display text-lg truncate">{p.name}</h3>
                {p.featured && <span className="text-[10px] uppercase tracking-widest text-accent">Featured</span>}
              </div>
              <p className="text-xs text-muted-foreground">{p.category} · {p.price_ugx ? `UGX ${Number(p.price_ugx).toLocaleString()}` : "Inquire"}</p>
            </div>
            <button onClick={() => togglePublished(p)} className="text-xs uppercase tracking-widest hover:text-accent px-3">
              {p.published ? "Hide" : "Publish"}
            </button>
            <button onClick={() => remove(p.id)} className="text-destructive hover:opacity-70 p-2"><Trash2 className="w-4 h-4" /></button>
          </div>
        ))}
      </div>
    </div>
  );
};

const GalleryPanel = () => {
  const [items, setItems] = useState<GalleryImage[]>([]);
  const [uploading, setUploading] = useState(false);

  const load = async () => {
    const { data } = await supabase.from("gallery_images").select("*").order("sort_order").order("created_at", { ascending: false });
    setItems((data ?? []) as GalleryImage[]);
  };
  useEffect(() => { load(); }, []);

  const onUpload = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const files = Array.from(e.target.files ?? []);
    if (!files.length) return;
    setUploading(true);
    for (const f of files) {
      const url = await uploadImage(f);
      if (url) await supabase.from("gallery_images").insert({ image_url: url, caption: f.name.split(".")[0] });
    }
    setUploading(false);
    e.target.value = "";
    load();
  };

  const remove = async (id: string) => {
    if (!confirm("Remove this image?")) return;
    await supabase.from("gallery_images").delete().eq("id", id);
    load();
  };

  return (
    <div>
      <div className="bg-card p-6 mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
          <h2 className="font-display text-2xl">Gallery images</h2>
          <p className="text-sm text-muted-foreground">Upload one or many at once.</p>
        </div>
        <label className="cursor-pointer px-6 py-3 bg-primary text-primary-foreground text-xs uppercase tracking-[0.2em] hover:bg-accent flex items-center gap-2">
          {uploading ? <Loader2 className="w-4 h-4 animate-spin" /> : <Upload className="w-4 h-4" />} Upload images
          <input type="file" accept="image/*" multiple onChange={onUpload} className="hidden" />
        </label>
      </div>
      <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
        {items.map(g => (
          <div key={g.id} className="relative group bg-card overflow-hidden aspect-square">
            <img src={g.image_url} alt={g.caption ?? ""} className="w-full h-full object-cover" />
            <button onClick={() => remove(g.id)} className="absolute top-2 right-2 p-2 bg-background/80 opacity-0 group-hover:opacity-100 transition-opacity text-destructive">
              <Trash2 className="w-4 h-4" />
            </button>
          </div>
        ))}
        {items.length === 0 && <p className="col-span-full text-muted-foreground">No gallery images yet.</p>}
      </div>
    </div>
  );
};

const LeadsPanel = () => {
  const [items, setItems] = useState<Lead[]>([]);
  useEffect(() => {
    supabase.from("leads").select("*").order("created_at", { ascending: false }).then(({ data }) => setItems((data ?? []) as Lead[]));
  }, []);

  return (
    <div className="bg-card">
      <div className="p-6 border-b border-border">
        <h2 className="font-display text-2xl">Recent leads</h2>
        <p className="text-sm text-muted-foreground">{items.length} total inquiries</p>
      </div>
      <div className="divide-y divide-border">
        {items.length === 0 && <p className="p-6 text-muted-foreground">No leads yet.</p>}
        {items.map(l => (
          <div key={l.id} className="p-6 grid md:grid-cols-4 gap-4">
            <div>
              <p className="font-display text-lg">{l.name}</p>
              <p className="text-xs text-muted-foreground">{new Date(l.created_at).toLocaleString()}</p>
            </div>
            <div className="text-sm">
              <p>{l.phone}</p>
              {l.email && <p className="text-muted-foreground">{l.email}</p>}
              {l.interest && <p className="text-xs uppercase tracking-widest text-accent mt-1">{l.interest}</p>}
            </div>
            <p className="md:col-span-2 text-sm text-foreground/80 whitespace-pre-wrap">{l.message}</p>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Admin;
