// Probaha — minor UI behaviors
document.addEventListener('DOMContentLoaded', function () {
  // Bangla date in topbar
  const bnDays = ['রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার','শনিবার'];
  const bnMonths = ['জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
  const bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
  const toBn = (n) => String(n).split('').map(d => /\d/.test(d) ? bnDigits[+d] : d).join('');
  const d = new Date();
  const dateEl = document.querySelector('[data-bn-date]');
  if (dateEl) dateEl.textContent = `${bnDays[d.getDay()]}, ${toBn(d.getDate())} ${bnMonths[d.getMonth()]} ${toBn(d.getFullYear())}`;

  // Duplicate ticker contents for seamless loop
  document.querySelectorAll('.pb-ticker-track ul').forEach(ul => {
    ul.innerHTML += ul.innerHTML;
  });
});

document.querySelectorAll('#pbMobileMenu a').forEach(el => 
    el.onclick = () => setTimeout(() => bootstrap.Offcanvas.getInstance('#pbMobileMenu')?.hide(), 150)
);