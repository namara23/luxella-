import { gallery, site } from "@/data/content";
import { Instagram } from "lucide-react";

const Gallery = () => (
  <section id="gallery" className="py-24 md:py-36 bg-background">
    <div className="container-luxe">
      <div className="text-center max-w-2xl mx-auto mb-14">
        <p className="eyebrow mb-4">Inspiration Gallery</p>
        <h2 className="font-display text-4xl md:text-6xl leading-tight text-balance">
          Moments from our <em className="text-accent not-italic">latest projects</em>
        </h2>
        <a href={site.socials.instagram} target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-2 mt-6 text-sm text-muted-foreground hover:text-accent transition-colors">
          <Instagram className="w-4 h-4" /> Follow @luxellaspaces
        </a>
      </div>

      <div className="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-5">
        {gallery.map((src, i) => (
          <div key={i} className={`img-zoom relative bg-muted ${i % 5 === 0 ? "row-span-2 aspect-[3/5] md:aspect-[3/4]" : "aspect-square"}`}>
            <img src={src} alt={`Luxella Spaces interior styling ${i + 1}`} loading="lazy" className="w-full h-full object-cover" />
          </div>
        ))}
      </div>
    </div>
  </section>
);

export default Gallery;
