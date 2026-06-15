// Navbar shrink on scroll
(function(){
  const nav = document.querySelector('.navbar');
  if(!nav) return;
  const update = () => nav.classList.toggle('scrolled', window.scrollY > 30);
  update();
  window.addEventListener('scroll', update, {passive:true});
})();

// Active nav link
(function(){
  const path = (location.pathname.split('/').pop() || 'index.html').toLowerCase();
  document.querySelectorAll('.navbar .nav-link').forEach(a=>{
    const href = (a.getAttribute('href')||'').toLowerCase();
    if(href === path || (path==='' && href==='index.html')) a.classList.add('active');
  });
})();

// Close mobile menu when a link is clicked
(function(){
  const collapse = document.getElementById('mainNav');
  if(!collapse) return;
  collapse.querySelectorAll('a').forEach(a=>{
    a.addEventListener('click', ()=>{
      if(collapse.classList.contains('show') && window.bootstrap){
        const c = window.bootstrap.Collapse.getOrCreateInstance(collapse);
        c.hide();
      }
    });
  });
})();

// Current year
document.querySelectorAll('[data-year]').forEach(el => el.textContent = new Date().getFullYear());

// Static form thanks
document.querySelectorAll('form[data-static]').forEach(form=>{
  form.addEventListener('submit', e=>{
    e.preventDefault();
    if(!form.checkValidity()){ form.classList.add('was-validated'); return; }
    const msg = form.querySelector('[data-success]');
    form.querySelectorAll('input,textarea,select,button').forEach(i=>i.setAttribute('disabled','disabled'));
    if(msg){ msg.classList.remove('d-none'); msg.scrollIntoView({behavior:'smooth',block:'center'}); }
  });
});

// Donate tier select
document.querySelectorAll('.donate-tier').forEach(tier=>{
  tier.addEventListener('click', ()=>{
    document.querySelectorAll('.donate-tier').forEach(t=>t.classList.remove('active'));
    tier.classList.add('active');
    const amt = tier.dataset.amount;
    const input = document.getElementById('donation-amount');
    if(input && amt) input.value = amt;
  });
});

// Hero slider
(function(){
  const hero = document.getElementById('hero');
  if(!hero) return;
  const slides = hero.querySelectorAll('.hero-slide');
  const texts  = hero.querySelectorAll('.hero-slide-text');
  const dots   = hero.querySelectorAll('.hero-dots button');
  const prev   = hero.querySelector('.hero-arrows .prev');
  const next   = hero.querySelector('.hero-arrows .next');
  let i = 0, timer;
  const show = n => {
    i = (n + slides.length) % slides.length;
    slides.forEach((s,k)=>s.classList.toggle('active',k===i));
    texts.forEach((t,k)=>{ if(k===i){t.hidden=false;t.style.animation='fadeUp .6s ease both';} else t.hidden=true; });
    dots.forEach((d,k)=>d.classList.toggle('active',k===i));
  };
  const start = () => { stop(); timer = setInterval(()=>show(i+1), 6500); };
  const stop  = () => { if(timer) clearInterval(timer); };
  dots.forEach((d,k)=>d.addEventListener('click',()=>{show(k);start();}));
  prev && prev.addEventListener('click',()=>{show(i-1);start();});
  next && next.addEventListener('click',()=>{show(i+1);start();});
  hero.addEventListener('mouseenter',stop);
  hero.addEventListener('mouseleave',start);
  start();
  if(!slides.length) return;
slides[0].classList.add('active');
})();

const scrollTopBtn = document.getElementById('scrollTopBtn');

if (scrollTopBtn) {
    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add('show');
        } else {
            scrollTopBtn.classList.remove('show');
        }
    });

    scrollTopBtn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

window.loadScript = function(src, callback) {
    if (document.querySelector('script[src="' + src + '"]')) {
        callback();
        return;
    }
    var s = document.createElement('script');
    s.src = src;
    s.onload = callback;
    document.head.appendChild(s);
};