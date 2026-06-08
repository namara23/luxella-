<footer class="site">
  <div class="container foot-grid">
    <div>
      <div class="foot-brand">Luxella<span> Spaces</span></div>
      <p class="foot-tag"><?= e(SITE_TAGLINE) ?>. Crafting luxurious interiors for homes, hotels and offices across Uganda.</p>
      <div class="socials">
        <a href="<?= e(SITE_INSTAGRAM) ?>" target="_blank" rel="noopener" aria-label="Instagram">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </a>
        <a href="<?= e(SITE_FACEBOOK) ?>" target="_blank" rel="noopener" aria-label="Facebook">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>
      </div>
    </div>
    <div class="foot-col">
      <h4>Explore</h4>
      <ul>
        <li><a href="<?= BASE_URL ?>#about">About</a></li>
        <li><a href="<?= BASE_URL ?>#categories">Collection</a></li>
        <li><a href="<?= BASE_URL ?>shop.php">Shop</a></li>
        <li><a href="<?= BASE_URL ?>#gallery">Gallery</a></li>
        <li><a href="<?= BASE_URL ?>#services">Services</a></li>
        <li><a href="<?= BASE_URL ?>#faq">FAQ</a></li>
      </ul>
    </div>
    <div class="foot-col">
      <h4>Contact</h4>
      <ul>
        <li class="with-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> <a href="<?= e(wa_link()) ?>" target="_blank" rel="noopener">WhatsApp · <?= e(SITE_PHONE) ?></a></li>
        <li class="with-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> <a href="tel:<?= e(SITE_PHONE) ?>">Call · <?= e(SITE_PHONE) ?></a></li>
        <li class="with-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg> <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a></li>
        <li style="opacity:.7"><?= e(SITE_LOCATION) ?> · <?= e(SITE_DELIVERY) ?></li>
      </ul>
    </div>
  </div>
  <div style="border-top:1px solid rgba(247,243,236,.1)">
    <div class="container foot-bot">
      <div>© <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</div>
      <div>Designed with timeless elegance in Kampala, Uganda.</div>
    </div>
  </div>
</footer>

<a href="<?= e(wa_link()) ?>" target="_blank" rel="noopener" class="fab" aria-label="Chat on WhatsApp">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:relative;z-index:1"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
</a>

<script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>
