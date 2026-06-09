import { services } from "@/data/content";

const Services = () => (
  <section id="services" className="py-24 md:py-36 bg-primary text-primary-foreground">
    <div className="container-luxe">
      <div className="grid md:grid-cols-12 gap-12 mb-16">
        <div className="md:col-span-5">
          <p className="eyebrow text-gold-soft mb-4">Our Services</p>
          <h2 className="font-display text-4xl md:text-6xl leading-tight text-balance">
            Design, source, <em className="text-gold-soft not-italic">style.</em>
          </h2>
        </div>
        <p className="md:col-span-6 md:col-start-7 text-primary-foreground/75 leading-relaxed text-lg">
          From a single statement piece to a complete home transformation, our team handles every detail with the precision and discretion expected of a luxury studio.
        </p>
      </div>

      <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-px bg-primary-foreground/10">
        {services.map((s, i) => (
          <div key={s.title} className="bg-primary p-8 md:p-10 group hover:bg-primary-foreground/5 transition-colors duration-500">
            <div className="font-display text-gold-soft text-xl mb-6">0{i + 1}</div>
            <h3 className="font-display text-2xl mb-4">{s.title}</h3>
            <p className="text-sm text-primary-foreground/70 leading-relaxed">{s.desc}</p>
            <div className="mt-8 h-px w-12 bg-gold-soft/60 group-hover:w-full transition-all duration-700" />
          </div>
        ))}
      </div>
    </div>
  </section>
);

export default Services;
