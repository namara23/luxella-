import hero from "@/assets/hero-living.jpg";
import { whatsappLink } from "@/data/content";

const Hero = () => (
  <section id="top" className="relative min-h-[100svh] flex items-end overflow-hidden">
    <img src={hero} alt="Luxurious cream and gold living room by Luxella Spaces" width={1920} height={1080} className="absolute inset-0 w-full h-full object-cover" />
    <div className="absolute inset-0 bg-gradient-overlay" />
    <div className="absolute inset-0 bg-ink/20" />

    <div className="container-luxe relative z-10 pb-20 md:pb-32 pt-32 text-primary-foreground">
      <div className="max-w-3xl animate-reveal">
        <p className="eyebrow text-gold-soft mb-6">Interior Design Studio · Uganda</p>
        <h1 className="font-display text-5xl md:text-7xl lg:text-8xl leading-[0.95] text-balance">
          Timeless elegance for <em className="text-gold-soft not-italic font-light">modern living</em>
        </h1>
        <p className="mt-8 max-w-xl text-base md:text-lg text-primary-foreground/85 font-light leading-relaxed">
          Curated interior décor, wall art and home accessories — designed to transform houses into sanctuaries across Uganda.
        </p>
        <div className="mt-10 flex flex-wrap gap-4">
          <a href="#categories" className="group inline-flex items-center px-8 py-4 bg-accent text-accent-foreground text-xs uppercase tracking-[0.25em] hover:bg-primary-foreground transition-colors duration-500">
            Shop the Collection
            <span className="ml-3 transition-transform group-hover:translate-x-1">→</span>
          </a>
          <a href={whatsappLink()} target="_blank" rel="noopener noreferrer" className="inline-flex items-center px-8 py-4 border border-primary-foreground/60 text-primary-foreground text-xs uppercase tracking-[0.25em] hover:bg-primary-foreground hover:text-primary transition-colors duration-500">
            Contact Us
          </a>
        </div>
      </div>
    </div>

    <div className="absolute bottom-8 right-8 z-10 hidden md:flex flex-col items-center gap-2 text-primary-foreground/70 text-[10px] uppercase tracking-[0.3em]">
      <span>Scroll</span>
      <span className="w-px h-12 bg-gradient-to-b from-primary-foreground/70 to-transparent" />
    </div>
  </section>
);

export default Hero;
