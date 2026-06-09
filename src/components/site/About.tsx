const About = () => (
  <section id="about" className="py-24 md:py-36 bg-background">
    <div className="container-luxe grid md:grid-cols-12 gap-12 items-start">
      <div className="md:col-span-5">
        <p className="eyebrow mb-5">About Luxella</p>
        <h2 className="font-display text-4xl md:text-6xl leading-tight text-balance">
          Where craftsmanship meets <em className="text-accent not-italic">quiet luxury</em>.
        </h2>
      </div>
      <div className="md:col-span-6 md:col-start-7 space-y-6 text-foreground/80 leading-relaxed">
        <p className="text-lg">
          Luxella Spaces is Uganda's destination for refined interior décor and home styling. We believe a beautifully designed home is more than aesthetics — it's a daily ritual of comfort, calm and confidence.
        </p>
        <p>
          From hand-picked wall art and bathroom accessories to complete living room and bedroom transformations, every piece in our collection is chosen for its enduring quality and timeless silhouette. We work with homeowners, property developers, hotels and office clients who refuse to compromise on detail.
        </p>
        <div className="grid grid-cols-3 gap-6 pt-8 border-t border-border">
          <div><div className="font-display text-4xl text-accent">500+</div><div className="text-xs uppercase tracking-widest mt-2 text-muted-foreground">Homes Styled</div></div>
          <div><div className="font-display text-4xl text-accent">10+</div><div className="text-xs uppercase tracking-widest mt-2 text-muted-foreground">Years Crafting</div></div>
          <div><div className="font-display text-4xl text-accent">UG</div><div className="text-xs uppercase tracking-widest mt-2 text-muted-foreground">Nationwide Delivery</div></div>
        </div>
      </div>
    </div>
  </section>
);

export default About;
