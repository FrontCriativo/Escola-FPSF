<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Escola FPSF</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <script>
    (() => {
      let savedTheme;
      try { savedTheme = localStorage.getItem('theme'); } catch (error) { savedTheme = null; }
      const theme = savedTheme || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
      document.documentElement.dataset.theme = theme;
      document.documentElement.style.colorScheme = theme;
    })();
  </script>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<!-- Loader -->
<div id="loader">
  <img class="loader-logo" src="img/fpsf.jpg" alt="Logo Escola FPSF">
  <p class="loader-text">CARREGANDO BIBLIOTECA</p>
  <div class="loader-bar"><div class="loader-fill"></div></div>
</div>

<!-- Cursor glow -->
<div class="cursor-glow" id="cursorGlow"></div>

<!-- Particles -->
<canvas id="particles"></canvas>

<!-- ─── NAV ─── -->
<nav>
  <a href="#" class="nav-logo">
    <img class="brand-logo" src="img/fpsf.jpg" alt="Logo Escola FPSF">
    <span>Escola FPSF</span>
  </a>
  <ul class="nav-links">
    <li><a href="#acervo">Acervo</a></li>
    <li><a href="#categorias">Categorias</a></li>
    <li><a href="#eventos">Eventos</a></li>
    <li><a href="#sobre">Sobre</a></li>
    <li><a href="#contato">Contato</a></li>
  </ul>
  <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ativar tema escuro" aria-pressed="false">
    <span class="theme-toggle-icon" aria-hidden="true">☾</span>
    <span class="theme-toggle-text">Tema escuro</span>
  </button>
  <button type="button" class="btn-login" onclick="openLogin()">Login</button>
</nav>

<!-- ─── HERO ─── -->
<section class="hero">
  <!-- Floating books bg -->
  <div class="floating-books" id="floatingBooks"></div>

  <div class="hero-content">
    <div class="hero-badge">📚 Bem-vindo à biblioteca</div>
    <h1>Descubra o Mundo Através dos <span>Livros</span></h1>
    <p>Explore nosso acervo com mais de 5.000 títulos. De clássicos da literatura a ciências, temos o livro certo para cada leitor.</p>
    <div class="hero-btns">
      <a href="#acervo" class="btn btn-primary">🔍 Explorar Acervo</a>
      <a href="#sobre"  class="btn btn-outline">Saiba Mais →</a>
    </div>
  </div>

  <!-- SVG hero illustration -->
  <div class="hero-img">
    <svg viewBox="0 0 400 380" xmlns="http://www.w3.org/2000/svg">
      <!-- bookshelf -->
      <rect x="30" y="280" width="340" height="16" rx="5" fill="#CAB19D" opacity=".7"/>
      <rect x="30" y="140" width="340" height="16" rx="5" fill="#CAB19D" opacity=".5"/>
      <!-- left shelf legs -->
      <rect x="36" y="140" width="10" height="156" rx="3" fill="#CAB19D" opacity=".4"/>
      <rect x="354" y="140" width="10" height="156" rx="3" fill="#CAB19D" opacity=".4"/>
      <!-- books row 2 -->
      <rect x="55" y="160" width="28" height="120" rx="4" fill="#BCB9D0"/>
      <rect x="86" y="172" width="22" height="108" rx="4" fill="#8FA1D0"/>
      <rect x="111" y="155" width="32" height="125" rx="4" fill="#CAB19D"/>
      <rect x="146" y="167" width="20" height="113" rx="4" fill="#5B6183"/>
      <rect x="169" y="162" width="26" height="118" rx="4" fill="#D9B89C"/>
      <rect x="198" y="178" width="18" height="102" rx="4" fill="#BCB9D0" opacity=".8"/>
      <rect x="219" y="160" width="30" height="120" rx="4" fill="#7B8AB0"/>
      <rect x="252" y="170" width="24" height="110" rx="4" fill="#CAB19D" opacity=".9"/>
      <rect x="279" y="158" width="28" height="122" rx="4" fill="#5B6183" opacity=".7"/>
      <rect x="310" y="165" width="26" height="115" rx="4" fill="#BCB9D0"/>
      <!-- book spines lines -->
      <line x1="65" y1="165" x2="65" y2="275" stroke="rgba(255,255,255,.2)" stroke-width="2"/>
      <line x1="120" y1="160" x2="120" y2="275" stroke="rgba(255,255,255,.2)" stroke-width="2"/>
      <!-- open book floating -->
      <g transform="translate(155,30)" style="animation:heroFloat 3.5s ease-in-out infinite; transform-origin:center;">
        <ellipse cx="65" cy="90" rx="68" ry="12" fill="rgba(0,0,0,.15)"/>
        <rect x="0"  y="10" width="60" height="78" rx="6" fill="#CAB19D"/>
        <rect x="60" y="10" width="60" height="78" rx="6" fill="#E8D5C4"/>
        <rect x="4"  y="18" width="50" height="4"  rx="2" fill="rgba(255,255,255,.4)"/>
        <rect x="4"  y="26" width="40" height="3"  rx="2" fill="rgba(255,255,255,.3)"/>
        <rect x="4"  y="33" width="44" height="3"  rx="2" fill="rgba(255,255,255,.3)"/>
        <rect x="4"  y="40" width="36" height="3"  rx="2" fill="rgba(255,255,255,.3)"/>
        <rect x="66" y="18" width="48" height="4"  rx="2" fill="rgba(91,97,131,.25)"/>
        <rect x="66" y="26" width="38" height="3"  rx="2" fill="rgba(91,97,131,.2)"/>
        <rect x="66" y="33" width="42" height="3"  rx="2" fill="rgba(91,97,131,.2)"/>
        <path d="M60 10 Q62 49 60 88" stroke="rgba(0,0,0,.2)" stroke-width="2" fill="none"/>
        <!-- sparkles -->
        <circle cx="-15" cy="20" r="4" fill="#BCB9D0" opacity=".8">
          <animate attributeName="r" values="4;6;4" dur="1.8s" repeatCount="indefinite"/>
          <animate attributeName="opacity" values=".8;.3;.8" dur="1.8s" repeatCount="indefinite"/>
        </circle>
        <circle cx="140" cy="50" r="3" fill="#CAB19D" opacity=".7">
          <animate attributeName="r" values="3;5;3" dur="2.2s" repeatCount="indefinite"/>
          <animate attributeName="opacity" values=".7;.2;.7" dur="2.2s" repeatCount="indefinite"/>
        </circle>
        <circle cx="20" cy="-10" r="5" fill="rgba(255,255,255,.5)">
          <animate attributeName="r" values="5;7;5" dur="2.6s" repeatCount="indefinite"/>
          <animate attributeName="opacity" values=".5;.1;.5" dur="2.6s" repeatCount="indefinite"/>
        </circle>
      </g>
    </svg>
  </div>
</section>

<!-- ─── SEARCH ─── -->
<div class="search-section" id="busca">
  <div class="search-card reveal">
    <h3>🔍 Buscar no Acervo</h3>
    <div class="search-wrap">
      <input type="text" id="searchInput" placeholder="Título, autor, ISBN..." />
      <span class="s-icon">🔍</span>
    </div>
    <select class="filter-select" id="filterSelect">
      <option value="">Todas as categorias</option>
      <option>Literatura</option>
      <option>Ciências</option>
      <option>História</option>
      <option>Matemática</option>
      <option>Artes</option>
      <option>Filosofia</option>
    </select>
    <button class="btn btn-primary" onclick="doSearch()">Buscar</button>
  </div>
</div>

<!-- ─── STATS ─── -->
<div class="stats-band">
  <div class="stat-item reveal">
    <span class="stat-num" data-target="0">0</span>
    <p class="stat-label">Livros no Acervo</p>
  </div>
  <div class="stat-item reveal">
    <span class="stat-num" data-target="0">0</span>
    <p class="stat-label">Alunos Cadastrados</p>
  </div>
  <div class="stat-item reveal">
    <span class="stat-num" data-target="0">0</span>
    <p class="stat-label">Empréstimos / Mês</p>
  </div>
  <div class="stat-item reveal">
    <span class="stat-num" data-target="0">0</span>
    <p class="stat-label">Eventos Realizados</p>
  </div>
</div>

<!-- ─── FEATURED BOOKS ─── -->
<section id="acervo">
  <p class="section-label reveal">Destaques do Acervo</p>
  <h2 class="section-title reveal">Livros em Destaque</h2>
  <p class="section-subtitle reveal">Confira os títulos mais populares entre nossos alunos neste mês.</p>

  <div class="books-grid" id="booksGrid"></div>
</section>

<!-- ─── CATEGORIES ─── -->
<section class="categories-section" id="categorias">
  <p class="section-label reveal">Explore por Área</p>
  <h2 class="section-title reveal">Categorias</h2>
  <p class="section-subtitle reveal">Encontre livros organizados por área do conhecimento.</p>

  <div class="cats-grid">
    <div class="cat-card reveal" style="--d:.1s">
      <div class="cat-icon">📖</div>
      <div class="cat-name">Literatura</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:.2s">
      <div class="cat-icon">🔬</div>
      <div class="cat-name">Ciências</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:.3s">
      <div class="cat-icon">📐</div>
      <div class="cat-name">Matemática</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:.4s">
      <div class="cat-icon">🌍</div>
      <div class="cat-name">História</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:.5s">
      <div class="cat-icon">🎨</div>
      <div class="cat-name">Artes</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:.6s">
      <div class="cat-icon">🌐</div>
      <div class="cat-name">Geografia</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:.7s">
      <div class="cat-icon">🧠</div>
      <div class="cat-name">Filosofia</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:.8s">
      <div class="cat-icon">💻</div>
      <div class="cat-name">Tecnologia</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:.9s">
      <div class="cat-icon">🌱</div>
      <div class="cat-name">Meio Ambiente</div>
      <div class="cat-count">??? títulos</div>
    </div>
    <div class="cat-card reveal" style="--d:1s">
      <div class="cat-icon">🎵</div>
      <div class="cat-name">Música</div>
      <div class="cat-count">??? títulos</div>
    </div>
  </div>
</section>

<!-- ─── EVENTS ─── -->
<section id="eventos">
  <p class="section-label reveal">Agenda da Biblioteca</p>
  <h2 class="section-title reveal">Em Breve</h2>
  <p class="section-subtitle reveal">Participe das nossas atividades culturais e educativas.</p>

  <div class="events-list">
    <div class="event-item reveal-left">
      <div class="event-date"><div class="event-day">05</div><div class="event-month">Mai</div></div>
      <div>
        <div class="event-title">Ex: Clube do Livro — Maio 📚</div>
        <div class="event-desc">Discussão mensal sobre "Dom Casmurro" de Machado de Assis. Aberto a todos os alunos.</div>
      </div>
      <div class="event-tag">Literatura</div>
    </div>
    <div class="event-item reveal-left" style="transition-delay:.1s">
      <div class="event-date"><div class="event-day">12</div><div class="event-month">Mai</div></div>
      <div>
        <div class="event-title">Ex: Oficina de Poesia ✍️</div>
        <div class="event-desc">Aprenda técnicas de escrita criativa com a Prof.ª Carla. Vagas limitadas.</div>
      </div>
      <div class="event-tag">Workshop</div>
    </div>
    <div class="event-item reveal-left" style="transition-delay:.2s">
      <div class="event-date"><div class="event-day">20</div><div class="event-month">Mai</div></div>
      <div>
        <div class="event-title">Ex: Sarau de Leitura 🎤</div>
        <div class="event-desc">Apresentações de textos autorais e declamação de poesias no auditório da escola.</div>
      </div>
      <div class="event-tag">Cultural</div>
    </div>
    <div class="event-item reveal-left" style="transition-delay:.3s">
      <div class="event-date"><div class="event-day">28</div><div class="event-month">Mai</div></div>
      <div>
        <div class="event-title">Ex: Maratona de Leitura 🏆</div>
        <div class="event-desc">Competição entre turmas com prêmios para os maiores leitores do mês.</div>
      </div>
      <div class="event-tag">Competição</div>
    </div>
  </div>
</section>

<!-- ─── ABOUT ─── -->
<section class="about-section" id="sobre">
  <div class="about-grid">
    <div>
      <p class="section-label reveal">Conheça Nossa Biblioteca</p>
      <h2 class="section-title reveal">Um Espaço Para Crescer e Aprender</h2>
      <p class="section-subtitle reveal">Nossa biblioteca escolar é um ambiente acolhedor dedicado ao desenvolvimento intelectual dos alunos, com recursos modernos e atendimento especializado.</p>
      <div class="about-features">
        <div class="feat-item reveal" style="transition-delay:.1s">
          <div class="feat-icon">📡</div>
          <div>
            <div class="feat-title">Catálogo Digital</div>
            <div class="feat-desc">Consulte a disponibilidade de livros online a qualquer momento.</div>
          </div>
        </div>
        <div class="feat-item reveal" style="transition-delay:.2s">
          <div class="feat-icon">🤝</div>
          <div>
            <div class="feat-title">Empréstimo Facilitado</div>
            <div class="feat-desc">Retire até 3 livros por vez com prazo de 15 dias, renovável.</div>
          </div>
        </div>
        <div class="feat-item reveal" style="transition-delay:.3s">
          <div class="feat-icon">🎓</div>
          <div>
            <div class="feat-title">Apoio Pedagógico</div>
            <div class="feat-desc">Nossa equipe ajuda na pesquisa escolar e indicações de leitura.</div>
          </div>
        </div>
      </div>
    </div>
    <div class="about-visual reveal-right">
      <div class="big-book-icon">📚</div>
      <div class="hours-card">
        <h4>⏰ Horário de Funcionamento</h4>
        <div class="hour-row"><span>Segunda — Sexta</span><span>7h às 21h</span></div>
        <div class="hour-row"><span>Sábado</span><span>Fechado</span></div>
        <div class="hour-row"><span>Domingo</span><span>Fechado</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ─── NEWSLETTER ─── -->
<section class="news-section" id="contato">
  <p class="section-label reveal">Fique por Dentro</p>
  <h2 class="section-title reveal">Receba Nossas Novidades</h2>
  <p class="reveal">Cadastre-se e receba indicações de leitura, avisos de eventos e novos títulos diretamente no seu e-mail.</p>
  <div class="news-form reveal">
    <input type="email" id="emailInput" placeholder="Seu e-mail escolar..." />
    <button class="btn btn-primary" onclick="subscribeNewsletter()">Cadastrar 🚀</button>
  </div>
</section>

<!-- ─── FOOTER ─── -->
<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <img class="footer-logo" src="img/fpsf.jpg" alt="Logo Escola FPSF">
      <h3>Escola FPSF</h3>
      <p>Um lugar de conhecimento, imaginação e descobertas. Nossa missão é formar leitores para a vida.</p>
    </div>
    <div class="footer-col">
      <h4>Acesso Rápido</h4>
      <ul>
        <li><a href="#acervo">Acervo</a></li>
        <li><a href="#categorias">Categorias</a></li>
        <li><a href="#eventos">Eventos</a></li>
        <li><a href="#sobre">Sobre Nós</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Informações</h4>
      <ul>
        <li><a href="#">Regulamento</a></li>
        <li><a href="#">Como Emprestar</a></li>
        <li><a href="#">Multas e Devoluções</a></li>
        <li><a href="#">Contato</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2026 Escola FPSF. Todos os direitos reservados.</p>
    <div class="social-links">
      <a href="#" class="social-link">📘</a>
      <a href="#" class="social-link">📷</a>
      <a href="#" class="social-link">🐦</a>
    </div>
  </div>
</footer>

<!-- Scroll to top -->
<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">↑</button>

<!-- Book modal -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
  <div class="modal" id="bookModal">
    <div class="modal-header">
      <h3 id="modalTitle">Título</h3>
      <button class="modal-close" onclick="closeModal()">✕</button>
    </div>
    <div class="modal-cover" id="modalCover"></div>
    <div class="modal-genre" id="modalGenre"></div>
    <div class="modal-desc" id="modalDesc"></div>
    <div class="modal-meta" id="modalMeta"></div>
    <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="requestLoan()">Solicitar Empréstimo 📚</button>
  </div>
</div>

<!-- Temporary login modal -->
<div class="modal-overlay" id="loginModalOverlay" onclick="closeLogin(event)">
  <div class="login-modal" role="dialog" aria-modal="true" aria-labelledby="loginModalTitle">
    <div class="modal-header">
      <div>
        <p class="login-eyebrow">Acesso temporário</p>
        <h3 id="loginModalTitle">Entrar na biblioteca</h3>
      </div>
      <button type="button" class="modal-close" onclick="closeLogin()" aria-label="Fechar">✕</button>
    </div>
    <form id="loginForm" onsubmit="fakeLogin(event)">
      <label class="login-label" for="loginEmail">E-mail</label>
      <input class="login-input" type="email" id="loginEmail" placeholder="seuemail@escola.com" required />

      <label class="login-label" for="loginPassword">Senha</label>
      <input class="login-input" type="password" id="loginPassword" placeholder="Mínimo 4 caracteres" minlength="4" required />

      <p class="login-helper">Login fictício para demonstração. Nenhum dado será enviado.</p>
      <p class="login-message" id="loginMessage" aria-live="polite"></p>
      <button type="submit" class="btn btn-primary login-submit">Entrar</button>
    </form>
  </div>
</div>

<script src="js/script.js"></script>
</body>
</html>


