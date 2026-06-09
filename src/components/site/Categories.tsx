import { categories, whatsappLink } from "@/data/content";

const Categories = () => (
  <section id="categories" className="py-24 md:py-36 bg-muted/40">
    <div className="container-luxe">
      <div className="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
        <div>
          <p className="eyebrow mb-4">Featured Collection</p>
          <h2 className="font-display text-4xl md:text-6xl leading-tight max-w-2xl text-balance">
            Curated for every <em className="text-accent not-italic">corner of the home</em>
          </h2>
        </div>
        <a href={whatsappLink("I'd like to browse your full collection.")} target="_blank" rel="noopener noreferrer" className="text-xs uppercase tracking-[0.25em] text-accent hover:text-primary transition-colors self-start md:self-end">
          Browse All →
        </a>
      </div>

      <div className="grid md:grid-cols-6 gap-5">
        {categories.map((cat, i) => (
          <a
            key={cat.name}
            href={whatsappLink(`I'm interested in your ${cat.name} collection.`)}
            target="_blank" rel="noopener noreferrer"
            className={`group relative img-zoom bg-card hover-lift block ${i === 0 ? "md:col-span-4 md:row-span-2" : "md:col-span-2"}`}
          >
            <div className={`relative overflow-hidden ${i === 0 ? "aspect-[4/5] md:aspect-auto md:h-full" : "aspect-[4/3]"}`}>
              <img src={cat.image} alt={`${cat.name} décor by Luxella Spaces`} loading="lazy" className="w-full h-full object-cover" />
              <div className="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/10 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-6 md:p-8 text-primary-foreground">
                <p className="eyebrow text-gold-soft mb-2">Category</p>
                <h3 className="font-display text-2xl md:text-3xl">{cat.name}</h3>
                <p className="mt-2 text-sm text-primary-foreground/80 max-w-xs opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-500">{cat.desc}</p>
              </div>
            </div>
          </a>
        ))}
      </div>
    </div>
  </section>
);

export default Categories;
