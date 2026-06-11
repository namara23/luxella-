import { useEffect, useMemo, useState } from "react";
import { Link } from "react-router-dom";
import { supabase } from "@/integrations/supabase/client";
import { whatsappLink, site } from "@/data/content";
import Navbar from "@/components/site/Navbar";
import Footer from "@/components/site/Footer";
import WhatsAppFab from "@/components/site/WhatsAppFab";
import { MessageCircle } from "lucide-react";

type Product = {
  id: string;
  name: string;
  category: string;
  description: string | null;
  price_ugx: number | null;
  image_url: string | null;
  featured: boolean;
};

const Shop = () => {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);
  const [active, setActive] = useState<string>("All");

  useEffect(() => {
    document.title = "Shop Collection | Luxella Spaces";
    supabase.from("products").select("*").eq("published", true).order("sort_order").order("created_at", { ascending: false })
      .then(({ data }) => { setProducts((data ?? []) as Product[]); setLoading(false); });
  }, []);

  const categories = useMemo(() => ["All", ...Array.from(new Set(products.map(p => p.category)))], [products]);
  const filtered = active === "All" ? products : products.filter(p => p.category === active);

  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main className="pt-32 pb-24">
        <section className="container-luxe">
          <p className="eyebrow mb-4">Shop the Collection</p>
          <h1 className="font-display text-5xl md:text-7xl leading-tight max-w-4xl text-balance">
            Refined pieces for <em className="text-accent not-italic">considered living</em>.
          </h1>
          <p className="mt-6 text-foreground/70 max-w-xl">Browse our curated décor. Tap any piece to inquire on WhatsApp — we'll confirm availability, delivery and pricing in minutes.</p>

          <div className="mt-12 flex flex-wrap gap-2">
            {categories.map(c => (
              <button key={c} onClick={() => setActive(c)}
                className={`px-5 py-2.5 text-xs uppercase tracking-[0.2em] border transition-colors ${active === c ? "bg-primary text-primary-foreground border-primary" : "border-border hover:border-accent hover:text-accent"}`}>
                {c}
              </button>
            ))}
          </div>

          <div className="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {loading && Array.from({ length: 6 }).map((_, i) => (
              <div key={i} className="aspect-[4/5] bg-muted animate-pulse" />
            ))}
            {!loading && filtered.length === 0 && (
              <div className="col-span-full text-center py-20 border border-dashed border-border">
                <p className="font-display text-2xl mb-3">Our collection is being curated.</p>
                <p className="text-muted-foreground mb-6">New arrivals coming soon. Chat with us for bespoke sourcing.</p>
                <a href={whatsappLink()} target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-2 px-6 py-3 bg-primary text-primary-foreground text-xs uppercase tracking-[0.2em] hover:bg-accent">
                  <MessageCircle className="w-4 h-4" /> Chat on WhatsApp
                </a>
              </div>
            )}
            {filtered.map(p => (
              <article key={p.id} className="group bg-card hover-lift">
                <div className="aspect-[4/5] overflow-hidden bg-muted">
                  {p.image_url ? (
                    <img src={p.image_url} alt={p.name} loading="lazy" className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                  ) : (
                    <div className="w-full h-full flex items-center justify-center text-muted-foreground text-xs uppercase tracking-widest">No image</div>
                  )}
                </div>
                <div className="p-6">
                  <p className="text-[10px] uppercase tracking-[0.25em] text-muted-foreground">{p.category}</p>
                  <h3 className="font-display text-2xl mt-2">{p.name}</h3>
                  {p.description && <p className="text-sm text-foreground/70 mt-2 line-clamp-2">{p.description}</p>}
                  <div className="mt-5 flex items-center justify-between">
                    <span className="font-display text-lg">
                      {p.price_ugx ? `UGX ${Number(p.price_ugx).toLocaleString()}` : "Inquire"}
                    </span>
                    <a href={`https://wa.me/${site.phoneIntl}?text=${encodeURIComponent(`Hello Luxella, I'd like to inquire about: ${p.name}`)}`}
                      target="_blank" rel="noopener noreferrer"
                      className="text-xs uppercase tracking-[0.2em] text-accent hover:text-primary">
                      Inquire →
                    </a>
                  </div>
                </div>
              </article>
            ))}
          </div>

          <div className="mt-16 text-center">
            <Link to="/#contact" className="text-xs uppercase tracking-[0.25em] text-accent hover:text-primary">Looking for something specific? Get in touch →</Link>
          </div>
        </section>
      </main>
      <Footer />
      <WhatsAppFab />
    </div>
  );
};

export default Shop;
