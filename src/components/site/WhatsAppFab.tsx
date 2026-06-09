import { MessageCircle } from "lucide-react";
import { whatsappLink } from "@/data/content";

const WhatsAppFab = () => (
  <a
    href={whatsappLink()}
    target="_blank" rel="noopener noreferrer"
    aria-label="Chat on WhatsApp"
    className="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-accent text-accent-foreground shadow-gold flex items-center justify-center hover:scale-110 transition-transform duration-300"
  >
    <MessageCircle className="w-6 h-6" />
    <span className="absolute inset-0 rounded-full bg-accent animate-ping opacity-30" />
  </a>
);

export default WhatsAppFab;
