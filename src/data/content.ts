// Centralized site content — edit here to update copy, products, gallery, etc.
// Designed as a CMS-friendly content source.

import bedroom from "@/assets/cat-bedroom.jpg";
import bathroom from "@/assets/cat-bathroom.jpg";
import kitchen from "@/assets/cat-kitchen.jpg";
import living from "@/assets/cat-living.jpg";
import wallart from "@/assets/cat-wallart.jpg";
import g1 from "@/assets/g1.jpg";
import g2 from "@/assets/g2.jpg";
import g3 from "@/assets/g3.jpg";
import g4 from "@/assets/g4.jpg";
import g5 from "@/assets/g5.jpg";
import g6 from "@/assets/g6.jpg";

export const site = {
  brand: "Luxella Spaces",
  tagline: "Timeless elegance for modern living",
  phone: "0776706980",
  phoneIntl: "256776706980",
  email: "hello@luxellaspaces.com",
  location: "Kampala, Uganda",
  delivery: "Nationwide delivery across Uganda",
  socials: {
    instagram: "https://instagram.com/",
    facebook: "https://facebook.com/",
    tiktok: "https://tiktok.com/",
    pinterest: "https://pinterest.com/",
  },
};

export const whatsappLink = (msg = "Hello Luxella Spaces, I'd like to learn more about your collection.") =>
  `https://wa.me/${site.phoneIntl}?text=${encodeURIComponent(msg)}`;

export const categories = [
  { name: "Living Room", image: living, desc: "Statement sofas, sculptural accents, layered textures." },
  { name: "Bedroom", image: bedroom, desc: "Linen bedding, soft palettes, restful sanctuaries." },
  { name: "Bathroom", image: bathroom, desc: "Brass fixtures, marble, considered accessories." },
  { name: "Kitchen", image: kitchen, desc: "Refined hardware, timeless cabinetry, warm finishes." },
  { name: "Wall Hangings", image: wallart, desc: "Curated art that completes every room." },
];

export const gallery = [g1, g2, g3, g4, g5, g6, living, bedroom, bathroom];

export const services = [
  { title: "Interior Design Consultation", desc: "Bespoke design plans tailored to your space, lifestyle and budget." },
  { title: "Full Home Styling", desc: "End-to-end styling from concept to final installation." },
  { title: "Hospitality & Office Interiors", desc: "Curated interiors for hotels, lodges and corporate offices." },
  { title: "Home Improvement Sourcing", desc: "Sourcing of premium décor, fixtures and finishing materials." },
];

export const testimonials = [
  { quote: "Luxella transformed our home into something we never imagined possible. Every detail is exquisite.", author: "Patricia N.", role: "Homeowner, Kampala" },
  { quote: "Professional, refined and on-budget. Our boutique hotel feels world-class thanks to their team.", author: "James O.", role: "Hotel Owner, Entebbe" },
  { quote: "From wall art to bedroom styling, the quality is unmatched in Uganda. A true luxury experience.", author: "Sandra K.", role: "Property Developer" },
];

export const faqs = [
  { q: "Do you deliver across Uganda?", a: "Yes. We offer nationwide delivery across Uganda. Delivery within Kampala is often same-day; upcountry orders typically arrive in 2–4 days." },
  { q: "Can I request a custom interior design?", a: "Absolutely. Our team offers bespoke consultations for homes, hotels and offices, tailored to your style and budget." },
  { q: "How do I place an order?", a: "Reach out via WhatsApp or call 0776706980, or fill in the inquiry form on this page and we'll respond within hours." },
  { q: "Do you work with hotels and property developers?", a: "Yes. We have dedicated packages for hospitality, office and developer projects, including bulk sourcing." },
  { q: "What payment methods do you accept?", a: "Mobile money, bank transfer and cash on delivery within Kampala. International clients can request invoicing." },
];
