import { useState, useEffect } from "react";
import { Menu, X, Phone } from "lucide-react";
import { site, whatsappLink } from "@/data/content";

const links = [
  { href: "/#about", label: "About" },
  { href: "/#categories", label: "Collection" },
  { href: "/shop", label: "Shop" },
  { href: "/#gallery", label: "Gallery" },
  { href: "/#services", label: "Services" },
  { href: "/#faq", label: "FAQ" },
  { href: "/#contact", label: "Contact" },
];

const Navbar = () => {
  const [open, setOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 20);
    onScroll();
    window.addEventListener("scroll", onScroll);
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <header className={`fixed top-0 inset-x-0 z-50 transition-all duration-500 ${scrolled ? "bg-background/85 backdrop-blur-md border-b border-border/60" : "bg-transparent"}`}>
      <nav className="container-luxe flex items-center justify-between h-20">
        <a href="#top" className="font-display text-2xl tracking-wide">
          {site.brand.split(" ")[0]}<span className="text-accent"> Spaces</span>
        </a>

        <ul className="hidden lg:flex items-center gap-10 text-sm">
          {links.map((l) => (
            <li key={l.href}>
              <a href={l.href} className="relative text-foreground/80 hover:text-foreground transition-colors after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-px after:w-0 after:bg-accent hover:after:w-full after:transition-all after:duration-500">
                {l.label}
              </a>
            </li>
          ))}
        </ul>

        <div className="hidden lg:flex items-center gap-4">
          <a href={`tel:${site.phone}`} className="flex items-center gap-2 text-sm text-foreground/80 hover:text-accent transition-colors">
            <Phone className="w-4 h-4" /> {site.phone}
          </a>
          <a href={whatsappLink()} target="_blank" rel="noopener noreferrer" className="px-5 py-2.5 bg-primary text-primary-foreground text-xs uppercase tracking-[0.2em] hover:bg-accent hover:text-accent-foreground transition-colors duration-500">
            WhatsApp
          </a>
        </div>

        <button className="lg:hidden text-foreground" onClick={() => setOpen(!open)} aria-label="Menu">
          {open ? <X /> : <Menu />}
        </button>
      </nav>

      {open && (
        <div className="lg:hidden bg-background border-t border-border animate-fade-up">
          <ul className="container-luxe py-6 flex flex-col gap-5">
            {links.map((l) => (
              <li key={l.href}>
                <a href={l.href} onClick={() => setOpen(false)} className="block text-lg font-display">{l.label}</a>
              </li>
            ))}
            <li className="pt-4 border-t border-border flex flex-col gap-3">
              <a href={`tel:${site.phone}`} className="text-sm">📞 {site.phone}</a>
              <a href={whatsappLink()} target="_blank" rel="noopener noreferrer" className="px-5 py-3 bg-primary text-primary-foreground text-xs uppercase tracking-[0.2em] text-center">WhatsApp Us</a>
            </li>
          </ul>
        </div>
      )}
    </header>
  );
};

export default Navbar;
