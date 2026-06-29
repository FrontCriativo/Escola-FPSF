/* ──────────────────────────────────────
   LOGIN / SESSÃO
────────────────────────────────────── */
const INSTITUTIONAL_DOMAIN = '@aluno.educacao.sp.gov.br';

if (sessionStorage.getItem('loggedIn') === '1') {
  document.getElementById('loginOverlay').style.display = 'none';
  document.getElementById('logoutBtn').style.display    = 'block';
} else {
  document.body.style.overflow = 'hidden';
}

function doLogin() {
  const emailEl = document.getElementById('loginEmail');
  const pwEl    = document.getElementById('loginPassword');
  const errEl   = document.getElementById('loginError');
  const email   = emailEl.value.trim().toLowerCase();
  const pw      = pwEl.value;

  errEl.textContent = '';
  emailEl.classList.remove('input-error');
  pwEl.classList.remove('input-error');

  if (!email.endsWith(INSTITUTIONAL_DOMAIN)) {
    errEl.textContent = 'Use seu e-mail institucional (@aluno.educacao.sp.gov.br).';
    emailEl.classList.add('input-error');
    emailEl.focus();
    return;
  }
  if (pw.length < 6) {
    errEl.textContent = 'A senha deve ter pelo menos 6 caracteres.';
    pwEl.classList.add('input-error');
    pwEl.focus();
    return;
  }

  sessionStorage.setItem('loggedIn', '1');
  const overlay = document.getElementById('loginOverlay');
  overlay.style.opacity = '0';
  document.getElementById('logoutBtn').style.display = 'block';
  setTimeout(() => {
    overlay.style.display   = 'none';
    document.body.style.overflow = '';
  }, 500);
}

function doLogout() {
  sessionStorage.removeItem('loggedIn');
  location.reload();
}

function togglePw() {
  const pw  = document.getElementById('loginPassword');
  const btn = document.querySelector('.pw-toggle');
  if (pw.type === 'password') { pw.type = 'text';     btn.textContent = '🙈'; }
  else                        { pw.type = 'password'; btn.textContent = '👁'; }
}

document.addEventListener('keydown', e => {
  const overlay = document.getElementById('loginOverlay');
  if (e.key === 'Enter' && overlay && overlay.style.display !== 'none' && overlay.style.opacity !== '0') {
    doLogin();
  }
});

/* ──────────────────────────────────────
   DATA
────────────────────────────────────── */
const books = [
  { title:"Dom Casmurro", author:"Machado de Assis", genre:"Literatura", emoji:"📗", color:"#a8c7a0", available:true,  rating:"★★★★★", desc:"Clássico do realismo brasileiro. Bentinho narra sua história com Capitu num dos maiores romances da língua portuguesa.", year:1899, pages:256 },
  { title:"O Pequeno Príncipe", author:"Antoine de Saint-Exupéry", genre:"Literatura", emoji:"📘", color:"#a0b8d8", available:true,  rating:"★★★★★", desc:"Uma história atemporal sobre amizade, amor e o que realmente importa na vida. Leitura essencial.", year:1943, pages:96 },
  { title:"Sapiens", author:"Yuval Noah Harari", genre:"Ciências", emoji:"📙", color:"#d8c4a0", available:false, rating:"★★★★☆", desc:"Uma breve história da humanidade, desde os primeiros humanos até a era moderna, com perspectivas instigantes.", year:2011, pages:443 },
  { title:"1984", author:"George Orwell", genre:"Ficção", emoji:"📕", color:"#c4a0a0", available:true,  rating:"★★★★★", desc:"Distopia clássica sobre totalitarismo, vigilância e controle da informação. Mais relevante do que nunca.", year:1949, pages:328 },
  { title:"A Arte da Guerra", author:"Sun Tzu", genre:"Filosofia", emoji:"📒", color:"#d4c4a0", available:true,  rating:"★★★★☆", desc:"Tratado militar milenar com ensinamentos sobre estratégia, liderança e tomada de decisão.", year:-500, pages:112 },
  { title:"O Alquimista", author:"Paulo Coelho", genre:"Literatura", emoji:"📓", color:"#c4b8d8", available:false, rating:"★★★★☆", desc:"A jornada de Santiago em busca de sua Lenda Pessoal. Um dos livros mais vendidos da história.", year:1988, pages:160 },
  { title:"Breve História do Tempo", author:"Stephen Hawking", genre:"Ciências", emoji:"🔭", color:"#a0c4d4", available:true,  rating:"★★★★★", desc:"Hawking explica a origem do universo, buracos negros e o tempo de forma acessível e fascinante.", year:1988, pages:212 },
  { title:"Orgulho e Preconceito", author:"Jane Austen", genre:"Literatura", emoji:"🌸", color:"#d8a0b8", available:true,  rating:"★★★★★", desc:"Romance clássico sobre amor, classe social e as armadilhas dos preconceitos na Inglaterra do século XIX.", year:1813, pages:432 },
];

/* ──────────────────────────────────────
   LOADER
────────────────────────────────────── */
window.addEventListener('load', () => {
  setTimeout(() => {
    document.getElementById('loader').classList.add('hidden');
  }, 1600);
});

/* ──────────────────────────────────────
   CURSOR GLOW
────────────────────────────────────── */
const glow = document.getElementById('cursorGlow');
document.addEventListener('mousemove', e => {
  glow.style.left   = e.clientX + 'px';
  glow.style.top    = e.clientY + 'px';
  glow.style.width  = '60px';
  glow.style.height = '60px';
});
document.addEventListener('mouseleave', () => {
  glow.style.width  = '0';
  glow.style.height = '0';
});

/* ──────────────────────────────────────
   PARTICLES
────────────────────────────────────── */
(function () {
  const canvas = document.getElementById('particles');
  const ctx    = canvas.getContext('2d');
  let W, H;
  const dots   = [];

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);

  const COLORS = ['#BCB9D0', '#5B6183', '#CAB19D'];
  for (let i = 0; i < 55; i++) {
    dots.push({
      x:     Math.random() * window.innerWidth,
      y:     Math.random() * window.innerHeight,
      r:     Math.random() * 2.5 + 0.5,
      dx:    (Math.random() - 0.5) * 0.35,
      dy:    (Math.random() - 0.5) * 0.35,
      color: COLORS[Math.floor(Math.random() * COLORS.length)],
      alpha: Math.random() * 0.4 + 0.1,
    });
  }

  function draw() {
    ctx.clearRect(0, 0, W, H);
    dots.forEach(d => {
      d.x += d.dx; d.y += d.dy;
      if (d.x < 0) d.x = W; if (d.x > W) d.x = 0;
      if (d.y < 0) d.y = H; if (d.y > H) d.y = 0;
      ctx.beginPath();
      ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
      ctx.fillStyle   = d.color;
      ctx.globalAlpha = d.alpha;
      ctx.fill();
    });

    ctx.globalAlpha = 0.07;
    for (let i = 0; i < dots.length; i++) {
      for (let j = i + 1; j < dots.length; j++) {
        const dist = Math.hypot(dots[i].x - dots[j].x, dots[i].y - dots[j].y);
        if (dist < 130) {
          ctx.beginPath();
          ctx.moveTo(dots[i].x, dots[i].y);
          ctx.lineTo(dots[j].x, dots[j].y);
          ctx.strokeStyle = '#5B6183';
          ctx.lineWidth   = 0.8;
          ctx.stroke();
        }
      }
    }
    ctx.globalAlpha = 1;
    requestAnimationFrame(draw);
  }
  draw();
})();

/* ──────────────────────────────────────
   FLOATING BOOKS (hero background)
────────────────────────────────────── */
(function () {
  const container = document.getElementById('floatingBooks');
  const emojis    = ['📚','📖','📝','🔖','📕','📗','📘','📙','✏️','🎓'];
  for (let i = 0; i < 18; i++) {
    const el          = document.createElement('span');
    el.className      = 'fb';
    el.textContent    = emojis[Math.floor(Math.random() * emojis.length)];
    el.style.left              = Math.random() * 100 + '%';
    el.style.fontSize          = (Math.random() * 1.5 + 1.2) + 'rem';
    el.style.animationDuration = (Math.random() * 14 + 10) + 's';
    el.style.animationDelay    = (Math.random() * 10) + 's';
    container.appendChild(el);
  }
})();

/* ──────────────────────────────────────
   RENDER BOOKS
────────────────────────────────────── */
function renderBooks(list) {
  const grid = document.getElementById('booksGrid');
  grid.innerHTML = '';
  list.forEach((b, i) => {
    const card = document.createElement('div');
    card.className = 'book-card reveal';
    card.style.transitionDelay = (i * 0.08) + 's';
    card.innerHTML = `
      <div class="book-cover" style="background:${b.color}20;">
        <div class="book-spine"></div>
        <span style="font-size:4rem">${b.emoji}</span>
      </div>
      <div class="book-info">
        <div class="book-genre">${b.genre}</div>
        <div class="book-title">${b.title}</div>
        <div class="book-author">${b.author}</div>
        <div class="book-footer">
          <span class="book-badge ${b.available ? 'badge-available' : 'badge-out'}">${b.available ? 'Disponível' : 'Emprestado'}</span>
          <span class="book-rating">${b.rating}</span>
        </div>
      </div>`;
    card.addEventListener('click', () => openModal(b));
    grid.appendChild(card);
  });
  observeReveal();
}
renderBooks(books);

/* ──────────────────────────────────────
   MODAL
────────────────────────────────────── */
function openModal(b) {
  document.getElementById('modalTitle').textContent = b.title;
  document.getElementById('modalCover').textContent = b.emoji;
  document.getElementById('modalGenre').textContent = b.genre.toUpperCase();
  document.getElementById('modalDesc').textContent  = b.desc;
  document.getElementById('modalMeta').innerHTML =
    `<span>👤 ${b.author}</span>` +
    `<span>📅 ${b.year > 0 ? b.year : Math.abs(b.year) + ' a.C.'}</span>` +
    `<span>📄 ${b.pages} páginas</span>`;
  document.getElementById('modalOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal(e) {
  if (e && e.target !== document.getElementById('modalOverlay')) return;
  document.getElementById('modalOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

/* ──────────────────────────────────────
   SEARCH
────────────────────────────────────── */
function doSearch() {
  const q   = document.getElementById('searchInput').value.toLowerCase();
  const cat = document.getElementById('filterSelect').value;
  const res = books.filter(b =>
    (!q   || b.title.toLowerCase().includes(q) || b.author.toLowerCase().includes(q)) &&
    (!cat || b.genre === cat)
  );
  renderBooks(res.length ? res : books);
  document.getElementById('acervo').scrollIntoView({ behavior: 'smooth' });
}

document.getElementById('searchInput').addEventListener('keydown', e => {
  if (e.key === 'Enter') doSearch();
});

/* ──────────────────────────────────────
   NEWSLETTER
────────────────────────────────────── */
function subscribeNewsletter() {
  const el = document.getElementById('emailInput');
  if (!el.value.includes('@')) {
    el.style.borderColor = '#e74c3c';
    el.placeholder = 'E-mail inválido!';
    return;
  }
  el.style.borderColor = '#2ecc71';
  el.value = '';
  el.placeholder = '✅ Cadastrado com sucesso!';
  setTimeout(() => {
    el.style.borderColor = '';
    el.placeholder = 'Seu e-mail escolar...';
  }, 3000);
}

/* ──────────────────────────────────────
   SCROLL REVEAL
────────────────────────────────────── */
function observeReveal() {
  const io = new IntersectionObserver((entries) => {
    entries.forEach(en => {
      if (en.isIntersecting) {
        en.target.classList.add('visible');
        io.unobserve(en.target);
      }
    });
  }, { threshold: 0.12 });
  document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => io.observe(el));
}
observeReveal();

/* ──────────────────────────────────────
   COUNTER ANIMATION
────────────────────────────────────── */
const counterIO = new IntersectionObserver(entries => {
  entries.forEach(en => {
    if (!en.isIntersecting) return;
    const el     = en.target;
    const target = +el.dataset.target;
    let start    = 0;
    const step   = target / 60;
    const timer  = setInterval(() => {
      start += step;
      if (start >= target) {
        el.textContent = target.toLocaleString('pt-BR');
        clearInterval(timer);
        return;
      }
      el.textContent = Math.floor(start).toLocaleString('pt-BR');
    }, 24);
    counterIO.unobserve(el);
  });
}, { threshold: 0.5 });
document.querySelectorAll('.stat-num').forEach(el => counterIO.observe(el));

/* ──────────────────────────────────────
   SCROLL TO TOP
────────────────────────────────────── */
const scrollBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
  scrollBtn.classList.toggle('show', window.scrollY > 400);
});

/* ──────────────────────────────────────
   NAV ACTIVE LINK
────────────────────────────────────── */
const sections = document.querySelectorAll('section[id], div[id]');
const navLinks  = document.querySelectorAll('.nav-links a');
window.addEventListener('scroll', () => {
  let cur = '';
  sections.forEach(s => { if (window.scrollY >= s.offsetTop - 120) cur = s.id; });
  navLinks.forEach(a => {
    a.style.color = a.getAttribute('href') === '#' + cur ? 'var(--white)' : '';
  });
}, { passive: true });
