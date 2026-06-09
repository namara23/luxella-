import { useState } from "react";
import { z } from "zod";
import { Phone, MessageCircle, MapPin, Truck } from "lucide-react";
import { site, whatsappLink } from "@/data/content";
import { toast } from "@/hooks/use-toast";

const schema = z.object({
  name: z.string().trim().min(2, "Please enter your name").max(80),
  phone: z.string().trim().min(7, "Please enter a valid phone").max(20),
  email: z.string().trim().email("Invalid email").max(120).optional().or(z.literal("")),
  interest: z.string().trim().max(80).optional().or(z.literal("")),
  message: z.string().trim().min(5, "Tell us a little more").max(800),
});

const Contact = () => {
  const [sending, setSending] = useState(false);

  const onSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    const form = e.currentTarget;
    const fd = new FormData(form);
    const data = Object.fromEntries(fd) as Record<string, string>;
    const parsed = schema.safeParse(data);
    if (!parsed.success) {
      toast({ title: "Please check the form", description: parsed.error.errors[0].message, variant: "destructive" });
      return;
    }
    setSending(true);
    try {
      const { supabase } = await import("@/integrations/supabase/client");
      const { error } = await supabase.from("leads").insert({
        name: parsed.data.name,
        phone: parsed.data.phone,
        email: parsed.data.email || null,
        interest: parsed.data.interest || null,
        message: parsed.data.message,
      });
      if (error) throw error;
      const msg = `Hello Luxella Spaces!%0A%0AName: ${parsed.data.name}%0APhone: ${parsed.data.phone}%0AEmail: ${parsed.data.email || "-"}%0AInterest: ${parsed.data.interest || "-"}%0A%0A${parsed.data.message}`;
      window.open(`https://wa.me/${site.phoneIntl}?text=${msg}`, "_blank");
      toast({ title: "Inquiry sent", description: "We've saved your details and opened WhatsApp so you can send it instantly." });
      form.reset();
    } catch (err: any) {
      toast({ title: "Could not send", description: err.message ?? "Please try WhatsApp directly.", variant: "destructive" });
    } finally {
      setSending(false);
    }
  };

  return (
    <section id="contact" className="py-24 md:py-36 bg-secondary/60">
      <div className="container-luxe grid lg:grid-cols-2 gap-12 lg:gap-20">
        <div>
          <p className="eyebrow mb-4">Begin Your Project</p>
          <h2 className="font-display text-4xl md:text-6xl leading-tight text-balance">
            Let's design something <em className="text-accent not-italic">unforgettable</em>.
          </h2>
          <p className="mt-6 text-foreground/80 leading-relaxed max-w-md">
            Tell us about your space and we'll respond with curated ideas, samples and a tailored quote.
          </p>

          <div className="mt-10 space-y-5">
            <a href={whatsappLink()} target="_blank" rel="noopener noreferrer" className="flex items-start gap-4 p-5 bg-card hover:bg-card/70 transition-colors group">
              <MessageCircle className="w-5 h-5 text-accent mt-1" />
              <div>
                <div className="text-xs uppercase tracking-widest text-muted-foreground">WhatsApp</div>
                <div className="font-display text-2xl group-hover:text-accent transition-colors">{site.phone}</div>
              </div>
            </a>
            <a href={`tel:${site.phone}`} className="flex items-start gap-4 p-5 bg-card hover:bg-card/70 transition-colors group">
              <Phone className="w-5 h-5 text-accent mt-1" />
              <div>
                <div className="text-xs uppercase tracking-widest text-muted-foreground">Call us</div>
                <div className="font-display text-2xl group-hover:text-accent transition-colors">{site.phone}</div>
              </div>
            </a>
            <div className="flex items-start gap-4 p-5 bg-card">
              <MapPin className="w-5 h-5 text-accent mt-1" />
              <div>
                <div className="text-xs uppercase tracking-widest text-muted-foreground">Studio</div>
                <div className="font-display text-xl">{site.location}</div>
              </div>
            </div>
            <div className="flex items-start gap-4 p-5 bg-card">
              <Truck className="w-5 h-5 text-accent mt-1" />
              <div>
                <div className="text-xs uppercase tracking-widest text-muted-foreground">Delivery</div>
                <div className="font-display text-xl">{site.delivery}</div>
              </div>
            </div>
          </div>
        </div>

        <form onSubmit={onSubmit} className="bg-card p-8 md:p-12 shadow-soft self-start">
          <h3 className="font-display text-2xl mb-8">Send an inquiry</h3>
          <div className="space-y-5">
            {[
              { name: "name", label: "Full name", type: "text", required: true },
              { name: "phone", label: "Phone number", type: "tel", required: true },
              { name: "email", label: "Email (optional)", type: "email" },
              { name: "interest", label: "Interested in (e.g. Living Room)", type: "text" },
            ].map((f) => (
              <div key={f.name}>
                <label className="block text-[10px] uppercase tracking-[0.25em] text-muted-foreground mb-2">{f.label}</label>
                <input
                  name={f.name}
                  type={f.type}
                  required={f.required}
                  maxLength={120}
                  className="w-full bg-transparent border-b border-border focus:border-accent focus:outline-none py-3 transition-colors"
                />
              </div>
            ))}
            <div>
              <label className="block text-[10px] uppercase tracking-[0.25em] text-muted-foreground mb-2">Your message</label>
              <textarea name="message" required rows={4} maxLength={800}
                className="w-full bg-transparent border-b border-border focus:border-accent focus:outline-none py-3 transition-colors resize-none" />
            </div>
          </div>
          <button type="submit" disabled={sending}
            className="mt-8 w-full px-8 py-4 bg-primary text-primary-foreground text-xs uppercase tracking-[0.25em] hover:bg-accent hover:text-accent-foreground transition-colors duration-500 disabled:opacity-60">
            {sending ? "Sending..." : "Send via WhatsApp"}
          </button>
          <p className="text-xs text-muted-foreground mt-4 text-center">We'll never share your details.</p>
        </form>
      </div>
    </section>
  );
};

export default Contact;
