import { testimonials } from "@/data/content";

const Testimonials = () => (
  <section className="py-24 md:py-36 bg-muted/40">
    <div className="container-luxe">
      <p className="eyebrow text-center mb-4">Client Voices</p>
      <h2 className="font-display text-center text-4xl md:text-6xl leading-tight mb-16 text-balance">
        Loved by <em className="text-accent not-italic">homeowners & hoteliers</em>
      </h2>
      <div className="grid md:grid-cols-3 gap-6">
        {testimonials.map((t) => (
          <figure key={t.author} className="bg-card p-8 md:p-10 shadow-soft hover-lift">
            <div className="text-accent font-display text-5xl leading-none mb-4">“</div>
            <blockquote className="font-display text-xl md:text-2xl leading-snug text-foreground/90">
              {t.quote}
            </blockquote>
            <figcaption className="mt-8 pt-6 border-t border-border">
              <div className="font-medium">{t.author}</div>
              <div className="text-xs uppercase tracking-widest text-muted-foreground mt-1">{t.role}</div>
            </figcaption>
          </figure>
        ))}
      </div>
    </div>
  </section>
);

export default Testimonials;
