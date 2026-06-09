import { Instagram, Facebook, Phone, Mail } from "lucide-react";
import { site, whatsappLink } from "@/data/content";

const Footer = () => (
  <footer className="bg-ink text-primary-foreground">
    <div className="container-luxe py-20 grid md:grid-cols-12 gap-12">
      <div className="md:col-span-5">
        <div className="font-display text-3xl">{site.brand.split(" ")[0]}<span className="text-gold-soft"> Spaces</span></div>
        <p className="mt-4 text-primary-foreground/70 max-w-sm leading-relaxed">{site.tagline}. Crafting luxurious interiors for homes, hotels and offices across Uganda.</p>
        <div className="mt-6 flex gap-3">
          {[
            { Icon: Instagram, href: site.socials.instagram, label: "Instagram" },
            { Icon: Facebook, href: site.socials.facebook, label: "Facebook" },
          ].map(({ Icon, href, label }) => (
            <a key={label} href={href} target="_blank" rel="noopener noreferrer" aria-label={label}
              className="w-10 h-10 border border-primary-foreground/30 flex items-center justify-center hover:bg-accent hover:border-accent hover:text-accent-foreground transition-colors">
              <Icon className="w-4 h-4" />
            </a>
          ))}
        </div>
      </div>

      <div className="md:col-span-3">
        <div className="eyebrow text-gold-soft mb-5">Explore</div>
        <ul className="space-y-3 text-sm text-primary-foreground/75">
          <li><a href="#about" className="hover:text-gold-soft">About</a></li>
          <li><a href="#categories" className="hover:text-gold-soft">Collection</a></li>
          <li><a href="#gallery" className="hover:text-gold-soft">Gallery</a></li>
          <li><a href="#services" className="hover:text-gold-soft">Services</a></li>
          <li><a href="#faq" className="hover:text-gold-soft">FAQ</a></li>
        </ul>
      </div>

      <div className="md:col-span-4">
        <div className="eyebrow text-gold-soft mb-5">Contact</div>
        <ul className="space-y-4 text-sm">
          <li><a href={whatsappLink()} target="_blank" rel="noopener noreferrer" className="flex items-center gap-3 hover:text-gold-soft"><Phone className="w-4 h-4 text-gold-soft"/>WhatsApp · {site.phone}</a></li>
          <li><a href={`tel:${site.phone}`} className="flex items-center gap-3 hover:text-gold-soft"><Phone className="w-4 h-4 text-gold-soft"/>Call · {site.phone}</a></li>
          <li><a href={`mailto:${site.email}`} className="flex items-center gap-3 hover:text-gold-soft"><Mail className="w-4 h-4 text-gold-soft"/>{site.email}</a></li>
          <li className="text-primary-foreground/70">{site.location} · {site.delivery}</li>
        </ul>
      </div>
    </div>

    <div className="border-t border-primary-foreground/10">
      <div className="container-luxe py-6 flex flex-col md:flex-row justify-between gap-2 text-xs text-primary-foreground/50">
        <div>© {new Date().getFullYear()} {site.brand}. All rights reserved.</div>
        <div className="flex items-center gap-4">
          <a href="/auth" className="hover:text-gold-soft transition-colors">Admin Login</a>
          <span>Designed with timeless elegance in Kampala, Uganda.</span>
        </div>
      </div>
    </div>
  </footer>
);

export default Footer;
