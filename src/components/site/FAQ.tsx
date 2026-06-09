import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/components/ui/accordion";
import { faqs } from "@/data/content";

const FAQ = () => (
  <section id="faq" className="py-24 md:py-36 bg-background">
    <div className="container-luxe grid md:grid-cols-12 gap-12">
      <div className="md:col-span-5">
        <p className="eyebrow mb-4">Frequently Asked</p>
        <h2 className="font-display text-4xl md:text-5xl leading-tight text-balance">
          Everything you need to know before you order.
        </h2>
        <p className="mt-6 text-muted-foreground">Still wondering? Reach out on WhatsApp at <span className="text-accent">0776706980</span> — we respond within hours.</p>
      </div>
      <div className="md:col-span-6 md:col-start-7">
        <Accordion type="single" collapsible className="w-full">
          {faqs.map((f, i) => (
            <AccordionItem key={i} value={`item-${i}`} className="border-border">
              <AccordionTrigger className="text-left font-display text-lg md:text-xl py-6 hover:no-underline hover:text-accent">
                {f.q}
              </AccordionTrigger>
              <AccordionContent className="text-foreground/75 leading-relaxed text-base">
                {f.a}
              </AccordionContent>
            </AccordionItem>
          ))}
        </Accordion>
      </div>
    </div>
  </section>
);

export default FAQ;
