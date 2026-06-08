<?php
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Luxella Spaces - Luxury Interior Design & Decor in Uganda';
$pageDesc  = 'Luxury interior design studio in Kampala. Curated wall art, bathroom & kitchen accessories, living room and bedroom styling. Nationwide delivery.';

// Lead capture
$leadMsg = null; $leadErr = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['form'] ?? '') === 'lead') {
    csrf_check();
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $interest = trim($_POST['interest'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (strlen($name) < 2 || strlen($phone) < 7 || strlen($message) < 5) {
        $leadErr = 'Please fill in your name, phone and a short message.';
    } else {
        $db = db();
        $stmt = $db->prepare('INSERT INTO leads (name, phone, email, interest, message, created_at) VALUES (?,?,?,?,?,NOW())');
        $stmt->bind_param('sssss', $name, $phone, $email, $interest, $message);
        if ($stmt->execute()) {
            $waMsg = "Hello Luxella Spaces!\n\nName: $name\nPhone: $phone\nEmail: " . ($email ?: '-') . "\nInterest: " . ($interest ?: '-') . "\n\n$message";
            $waUrl = wa_link($waMsg);
            // Redirect-and-open: show success + JS open WhatsApp
            $leadMsg = 'Thank you - your inquiry has been saved. Opening WhatsApp...';
            $leadOpen = $waUrl;
        } else {
            $leadErr = 'Sorry, we could not save your inquiry. Please try WhatsApp directly.';
        }
    }
}

// Categories & content
$categories = [
  ['name'=>'Living Room','image'=>'cat-living.jpg','desc'=>'Statement sofas, sculptural accents, layered textures.'],
  ['name'=>'Bedroom','image'=>'cat-bedroom.jpg','desc'=>'Linen bedding, soft palettes, restful sanctuaries.'],
  ['name'=>'Bathroom','image'=>'cat-bathroom.jpg','desc'=>'Brass fixtures, marble, considered accessories.'],
  ['name'=>'Kitchen','image'=>'cat-kitchen.jpg','desc'=>'Refined hardware, timeless cabinetry, warm finishes.'],
  ['name'=>'Wall Hangings','image'=>'cat-wallart.jpg','desc'=>'Curated art that completes every room.'],
];

// Gallery - try DB first, fall back to default images
$gallery = [];
$res = @db()->query('SELECT image_url FROM gallery_images WHERE published = 1 ORDER BY sort_order ASC, id DESC');
if ($res) { while ($r = $res->fetch_assoc()) { $gallery[] = $r['image_url']; } }
if (!$gallery) {
    $gallery = ['assets/images/g1.jpg','assets/images/g2.jpg','assets/images/g3.jpg','assets/images/g4.jpg','assets/images/g5.jpg','assets/images/g6.jpg','assets/images/cat-living.jpg','assets/images/cat-bedroom.jpg','assets/images/cat-bathroom.jpg'];
}

$services = [
  ['title'=>'Interior Design Consultation','desc'=>'Bespoke design plans tailored to your space, lifestyle and budget.'],
  ['title'=>'Full Home Styling','desc'=>'End-to-end styling from concept to final installation.'],
  ['title'=>'Hospitality & Office Interiors','desc'=>'Curated interiors for hotels, lodges and corporate offices.'],
  ['title'=>'Home Improvement Sourcing','desc'=>'Sourcing of premium decor, fixtures and finishing materials.'],
];

$testimonials = [
  ['quote'=>'Luxella transformed our home into something we never imagined possible. Every detail is exquisite.','author'=>'Patricia N.','role'=>'Homeowner, Kampala'],
  ['quote'=>'Professional, refined and on-budget. Our boutique hotel feels world-class thanks to their team.','author'=>'James O.','role'=>'Hotel Owner, Entebbe'],
  ['quote'=>'From wall art to bedroom styling, the quality is unmatched in Uganda. A true luxury experience.','author'=>'Sandra K.','role'=>'Property Developer'],
];

$faqs = [
  ['q'=>'Do you deliver across Uganda?','a'=>'Yes. We offer nationwide delivery. Within Kampala is often same-day; upcountry orders arrive in 2-4 days.'],
  ['q'=>'Can I request a custom interior design?','a'=>'Absolutely. Our team offers bespoke consultations for homes, hotels and offices, tailored to your style and budget.'],
  ['q'=>'How do I place an order?','a'=>'Reach out via WhatsApp or call ' . SITE_PHONE . ', or fill in the inquiry form on this page and we will respond within hours.'],
  ['q'=>'Do you work with hotels and property developers?','a'=>'Yes - dedicated packages for hospitality, office and developer projects, including bulk sourcing.'],
  ['q'=>'What payment methods do you accept?','a'=>'Mobile money, bank transfer and cash on delivery within Kampala. International clients can request invoicing.'],
];

include __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="hero" id="top">
  <img class="hero-bg" src="<?= asset_url('assets/images/hero-living.jpg') ?>" alt="Luxurious cream and gold living room by Luxella Spaces" width="1920" height="1080">
  <div class="container hero-inner reveal">
    <span class="eyebrow">Interior Design Studio - Uganda</span>
    <h1>Timeless elegance for <em>modern living</em></h1>
    <p>Curated interior decor, wall art and home accessories - designed to transform houses into sanctuaries across Uganda.</p>
    <div class="hero-ctas">
      <a href="#categories" class="btn btn-gold">Shop the Collection -></a>
      <a href="<?= e(wa_link()) ?>" target="_blank" rel="noopener" class="btn btn-ghost">Contact Us</a>
    </div>
  </div>
  <div class="scroll-cue"><span>Scroll</span></div>
</section>

<!-- ABOUT -->
<section id="about" class="section">
  <div class="container about-grid reveal">
    <div>
      <span class="eyebrow">About Luxella</span>
      <h2 style="margin-top:20px">Where craftsmanship meets <em>quiet luxury</em>.</h2>
    </div>
    <div>
      <p class="lead">Luxella Spaces is Uganda's destination for refined interior decor and home styling. We believe a beautifully designed home is more than aesthetics - it's a daily ritual of comfort, calm and confidence.</p>
      <p>From hand-picked wall art and bathroom accessories to complete living room and bedroom transformations, every piece is chosen for its enduring quality and timeless silhouette. We work with homeowners, property developers, hotels and office clients who refuse to compromise on detail.</p>
      <div class="stats">
        <div><div class="num">500+</div><div class="lbl">Homes Styled</div></div>
        <div><div class="num">10+</div><div class="lbl">Years Crafting</div></div>
        <div><div class="num">UG</div><div class="lbl">Nationwide Delivery</div></div>
      </div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section id="categories" class="section bg-muted">
  <div class="container">
    <div class="section-head reveal">
      <div>
        <span class="eyebrow">Featured Collection</span>
        <h2 style="margin-top:16px">Curated for every <em>corner of the home</em></h2>
      </div>
      <a href="<?= url('shop.php') ?>" style="font-size:11px;text-transform:uppercase;letter-spacing:.25em;color:var(--accent)">Browse All -></a>
    </div>
    <div class="cat-grid reveal">
      <?php foreach ($categories as $cat): ?>
        <a href="<?= e(wa_link("I'm interested in your " . $cat['name'] . " collection.")) ?>" target="_blank" rel="noopener" class="cat-card cat-card-aspect">
          <img src="<?= asset_url('assets/images/' . $cat['image']) ?>" alt="<?= e($cat['name']) ?> decor" loading="lazy">
          <div class="body">
            <span class="eyebrow">Category</span>
            <h3><?= e($cat['name']) ?></h3>
            <p><?= e($cat['desc']) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section id="gallery" class="section">
  <div class="container">
    <div class="section-head-center reveal">
      <span class="eyebrow">Inspiration Gallery</span>
      <h2 style="margin-top:16px">Moments from our <em>latest projects</em></h2>
      <a href="<?= e(SITE_INSTAGRAM) ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;margin-top:20px;color:var(--muted-fg);font-size:14px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/></svg>
        Follow @luxellaspaces
      </a>
    </div>
    <div class="gallery-grid reveal">
      <?php foreach ($gallery as $g): ?>
        <div class="g-item"><img src="<?= asset_url($g) ?>" alt="Luxella interior" loading="lazy"></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section id="services" class="section bg-primary">
  <div class="container">
    <div class="services-head reveal">
      <div>
        <span class="eyebrow">Our Services</span>
        <h2 style="margin-top:16px">Design, source, <em style="color:var(--gold-soft)">style.</em></h2>
      </div>
      <p>From a single statement piece to a complete home transformation, our team handles every detail with the precision and discretion expected of a luxury studio.</p>
    </div>
    <div class="svc-grid reveal">
      <?php foreach ($services as $i => $s): ?>
        <div class="svc">
          <div class="num">0<?= $i+1 ?></div>
          <h3><?= e($s['title']) ?></h3>
          <p><?= e($s['desc']) ?></p>
          <div class="line"></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section bg-muted">
  <div class="container">
    <div class="section-head-center reveal">
      <span class="eyebrow">Client Voices</span>
      <h2 style="margin-top:16px">Loved by <em>homeowners & hoteliers</em></h2>
    </div>
    <div class="tg reveal">
      <?php foreach ($testimonials as $t): ?>
        <figure class="t-card">
          <div class="q">&quot;</div>
          <blockquote><?= e($t['quote']) ?></blockquote>
          <figcaption>
            <div class="author"><?= e($t['author']) ?></div>
            <div class="role"><?= e($t['role']) ?></div>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FAQ -->
<section id="faq" class="section">
  <div class="container faq-grid reveal">
    <div>
      <span class="eyebrow">Frequently Asked</span>
      <h2 style="margin-top:16px">Everything you need to know before you order.</h2>
      <p class="intro">Still wondering? Reach out on WhatsApp at <span><?= e(SITE_PHONE) ?></span> - we respond within hours.</p>
    </div>
    <div>
      <?php foreach ($faqs as $f): ?>
        <details>
          <summary><?= e($f['q']) ?></summary>
          <div class="a"><?= e($f['a']) ?></div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section bg-contact">
  <div class="container contact-grid reveal">
    <div>
      <span class="eyebrow">Begin Your Project</span>
      <h2 style="margin-top:16px">Let's design something <em>unforgettable</em>.</h2>
      <p class="intro">Tell us about your space and we'll respond with curated ideas, samples and a tailored quote.</p>
      <div class="contact-items">
        <a href="<?= e(wa_link()) ?>" target="_blank" rel="noopener" class="c-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
          <div><div class="lbl">WhatsApp</div><div class="val"><?= e(SITE_PHONE) ?></div></div>
        </a>
        <a href="tel:<?= e(SITE_PHONE) ?>" class="c-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          <div><div class="lbl">Call us</div><div class="val"><?= e(SITE_PHONE) ?></div></div>
        </a>
        <div class="c-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <div><div class="lbl">Studio</div><div class="val"><?= e(SITE_LOCATION) ?></div></div>
        </div>
        <div class="c-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16,8 20,8 23,11 23,16 16,16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
          <div><div class="lbl">Delivery</div><div class="val"><?= e(SITE_DELIVERY) ?></div></div>
        </div>
      </div>
    </div>

    <form class="form" method="post" action="#contact">
      <h3>Send an inquiry</h3>
      <?php if ($leadMsg): ?><div class="form-success"><?= e($leadMsg) ?></div><?php endif; ?>
      <?php if ($leadErr): ?><div class="form-error"><?= e($leadErr) ?></div><?php endif; ?>
      <?= csrf_field() ?>
      <input type="hidden" name="form" value="lead">
      <div class="form-row"><label>Full name</label><input type="text" name="name" required maxlength="80" value="<?= e($_POST['name'] ?? '') ?>"></div>
      <div class="form-row"><label>Phone number</label><input type="tel" name="phone" required maxlength="20" value="<?= e($_POST['phone'] ?? '') ?>"></div>
      <div class="form-row"><label>Email (optional)</label><input type="email" name="email" maxlength="120" value="<?= e($_POST['email'] ?? '') ?>"></div>
      <div class="form-row"><label>Interested in (e.g. Living Room)</label><input type="text" name="interest" maxlength="80" value="<?= e($_POST['interest'] ?? '') ?>"></div>
      <div class="form-row"><label>Your message</label><textarea name="message" required rows="4" maxlength="800"><?= e($_POST['message'] ?? '') ?></textarea></div>
      <button type="submit" class="btn btn-primary btn-block">Send via WhatsApp</button>
      <p class="form-note">We'll never share your details.</p>
    </form>
  </div>
</section>

<?php if (!empty($leadOpen)): ?>
<script>window.open(<?= json_encode($leadOpen) ?>, '_blank');</script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
