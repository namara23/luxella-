// Nav scroll
const nav = document.getElementById('nav');
const onScroll = () => {
  if (window.scrollY > 20) nav.classList.add('scrolled');
  else nav.classList.remove('scrolled');
};
window.addEventListener('scroll', onScroll, {passive:true}); onScroll();

// Mobile menu
const btn = document.getElementById('menuBtn');
const menu = document.getElementById('mobileMenu');
if (btn) btn.addEventListener('click', () => menu.classList.toggle('open'));
menu?.querySelectorAll('a').forEach(a => a.addEventListener('click', () => menu.classList.remove('open')));

// Reveal on scroll
const io = new IntersectionObserver((entries) => {
  entries.forEach(en => { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => io.observe(el));

// Shop filters
document.querySelectorAll('.filter').forEach(b => b.addEventListener('click', e => {
  const cat = b.dataset.cat;
  document.querySelectorAll('.filter').forEach(x => x.classList.remove('active'));
  b.classList.add('active');
  document.querySelectorAll('.product').forEach(p => {
    p.style.display = (!cat || p.dataset.cat === cat) ? '' : 'none';
  });
}));
