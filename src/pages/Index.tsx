import Navbar from "@/components/site/Navbar";
import Hero from "@/components/site/Hero";
import About from "@/components/site/About";
import Categories from "@/components/site/Categories";
import Gallery from "@/components/site/Gallery";
import Services from "@/components/site/Services";
import Testimonials from "@/components/site/Testimonials";
import FAQ from "@/components/site/FAQ";
import Contact from "@/components/site/Contact";
import Footer from "@/components/site/Footer";
import WhatsAppFab from "@/components/site/WhatsAppFab";

const Index = () => {
  const jsonLd = {
    "@context": "https://schema.org",
    "@type": "HomeAndConstructionBusiness",
    name: "Luxella Spaces",
    description: "Interior design studio and home décor store in Uganda offering luxury wall art, bathroom accessories, kitchen accessories, living room and bedroom styling.",
    telephone: "+256776706980",
    areaServed: "Uganda",
    address: { "@type": "PostalAddress", addressLocality: "Kampala", addressCountry: "UG" },
  };

  return (
    <div className="min-h-screen bg-background">
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }} />
      <Navbar />
      <main>
        <Hero />
        <About />
        <Categories />
        <Gallery />
        <Services />
        <Testimonials />
        <FAQ />
        <Contact />
      </main>
      <Footer />
      <WhatsAppFab />
    </div>
  );
};

export default Index;
