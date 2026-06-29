/* ──────────────────────────────────────
   DATA
────────────────────────────────────── */
const books = [
  { title:"Diário de um Banana", author:"Jeff Kinney", genre:"Literatura", emoji:"📖", image:"img/diarioDeUmBanana.jpg", color:"#a8c7a0", available:true, rating:"★★★★★", desc:"As aventuras e confusões de Greg Heffley narradas em seu diário.", modalDescription:"Ao longo da história, Greg narra suas aventuras com o melhor amigo Rowley Jefferson — ele prefere, aliás, que chamem o diário de \"Livro de Memórias\". É início de ano letivo e tudo o que Greg quer é se tornar popular, mas suas tentativas — como ser monitor de crianças, escrever tirinhas para o jornal da escola ou entrar para o clube de luta — sempre terminam em fracasso, tornando a leitura leve e muito divertida.", year:2007, pages:224 },
  { title:"O Pequeno Príncipe", author:"Antoine de Saint-Exupéry", genre:"Literatura", emoji:"📘", image:"img/oPequenoPrincipe.jpg", color:"#a0b8d8", available:true, rating:"★★★★★", desc:"Uma história atemporal sobre amizade, amor e o que realmente importa na vida. Leitura essencial.", year:1943, pages:96 },
  { title:"A Origem das Espécies", author:"Charles Darwin", genre:"Ciências", emoji:"📙", image:"img/aOrigemDasEspecies.jpg", color:"#d8c4a0", available:false, rating:"★★★★☆", desc:"A obra que apresentou a teoria da evolução por seleção natural e transformou a compreensão da vida.", year:1859, pages:502 },
  { title:"A República", author:"Platão", genre:"Filosofia", emoji:"📕", image:"img/aRepublica.png", color:"#c4a0a0", available:true, rating:"★★★★★", desc:"Diálogo filosófico sobre justiça, política, educação e a construção de uma sociedade ideal.", year:-380, pages:416 },
  { title:"A Revolução dos Bichos", author:"George Orwell", genre:"Ficção", emoji:"📒", image:"img/aRevolucaoDosBichos.jpg", color:"#d4c4a0", available:true, rating:"★★★★★", desc:"Uma fábula política sobre animais que se rebelam contra seus donos e enfrentam uma nova tirania.", year:1945, pages:152 },
  { title:"Dom Quixote", author:"Miguel de Cervantes", genre:"Literatura", emoji:"📓", image:"img/domQuixote.jpg", color:"#c4b8d8", available:false, rating:"★★★★★", desc:"As aventuras de um fidalgo que decide viver como cavaleiro andante ao lado de Sancho Pança.", year:1605, pages:863 },
  { title:"Romeu e Julieta", author:"William Shakespeare", genre:"Teatro", emoji:"🎭", image:"img/RomeuAndJulieta.jpg", color:"#a0c4d4", available:true, rating:"★★★★★", desc:"A célebre tragédia de dois jovens apaixonados pertencentes a famílias rivais.", year:1597, pages:160 },
  { title:"Vidas Secas", author:"Graciliano Ramos", genre:"Literatura", emoji:"📖", image:"img/vidasSecas.jpg", color:"#d8a0b8", available:true, rating:"★★★★★", desc:"Uma família de retirantes enfrenta a seca, a pobreza e a opressão no sertão nordestino.", year:1938, pages:176 },
];

/* THEME */
const themeToggle = document.getElementById('themeToggle');

function updateThemeToggle(theme) {
  const isDark = theme === 'dark';
  themeToggle.setAttribute('aria-pressed', String(isDark));
  themeToggle.setAttribute('aria-label', isDark ? 'Ativar tema claro' : 'Ativar tema escuro');
  themeToggle.querySelector('.theme-toggle-icon').textContent = isDark ? '☀' : '☾';
  themeToggle.querySelector('.theme-toggle-text').textContent = isDark ? 'Tema claro' : 'Tema escuro';
}

function setTheme(theme) {
  document.documentElement.dataset.theme = theme;
  document.documentElement.style.colorScheme = theme;
  try { localStorage.setItem('theme', theme); } catch (error) { /* Theme still works for this session. */ }
  updateThemeToggle(theme);
}

updateThemeToggle(document.documentElement.dataset.theme || 'light');
themeToggle.addEventListener('click', () => {
  setTheme(document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark');
});

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
        ${b.image ? `<img class="book-cover-image" src="${b.image}" alt="Capa do livro ${b.title}">` : `<span style="font-size:4rem">${b.emoji}</span>`}
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
  const modalCover = document.getElementById('modalCover');
  modalCover.innerHTML = b.image
    ? `<img class="modal-cover-image" src="${b.image}" alt="Capa do livro ${b.title}">`
    : b.emoji;
  const modalGenre = document.getElementById('modalGenre');
  const modalDesc = document.getElementById('modalDesc');
  modalGenre.textContent = b.modalDescription || b.genre.toUpperCase();
  modalGenre.classList.toggle('modal-genre-description', Boolean(b.modalDescription));
  modalDesc.textContent = b.modalDescription ? '' : b.desc;
  modalDesc.hidden = Boolean(b.modalDescription);
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

function openLogin() {
  document.getElementById('loginModalOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
  setTimeout(() => document.getElementById('loginEmail').focus(), 100);
}

function requestLoan() {
  document.getElementById('modalOverlay').classList.remove('open');
  openLogin();
}

function closeLogin(e) {
  if (e && e.target !== document.getElementById('loginModalOverlay')) return;
  document.getElementById('loginModalOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

function fakeLogin(e) {
  e.preventDefault();
  const message = document.getElementById('loginMessage');

  message.textContent = 'Login realizado com sucesso!';
  document.querySelector('.btn-login').textContent = 'Aluno';

  setTimeout(() => {
    closeLogin();
    document.getElementById('loginForm').reset();
    message.textContent = '';
  }, 900);
}

document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    closeLogin();
    closeModal();
  }
});

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
    el.style.borderColor = 'var(--danger-text)';
    el.placeholder = 'E-mail inválido!';
    return;
  }
  el.style.borderColor = 'var(--success-text)';
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
    a.style.color = a.getAttribute('href') === '#' + cur ? 'var(--on-dark)' : '';
  });
}, { passive: true });
