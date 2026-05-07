<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Финансов Планер - Начало</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #59a758; 
            --primary-hover: #4a8c49; 
            --accent: #a658a7; 
            --accent-hover: #8e4a8f;
            

            --bg-body: #F8FAFC;
            --bg-card: #FFFFFF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --header-bg: rgba(255, 255, 255, 0.9);
        }

        /* Тъмен режим (Dark Mode) променливи */
        body.dark-mode {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
            --header-bg: rgba(15, 23, 42, 0.9);
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-main);
            background-color: var(--bg-body);
            transition: backg round 0.3s, color 0.3s;
            -webkit-font-smoothing: antialiased;
        }

        /* --- Хедър --- */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background: var(--header-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo { font-size: 24px; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 10px; }
        .logo-icon { width: 35px; height: 35px; background: var(--primary); color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        
        nav { display: flex; gap: 30px; }
        nav a { text-decoration: none; color: var(--text-muted); font-weight: 500; font-size: 15px; transition: color 0.3s; }
        nav a:hover { color: var(--primary); }

        .auth-buttons { display: flex; gap: 15px; align-items: center; }
        .btn-login { text-decoration: none; color: var(--accent); font-weight: 600; font-size: 15px; }
        
        /* Бутони */
        .btn-primary { background: var(--primary); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.3s; border: none; cursor: pointer; }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-2px); }
        
        .dark-mode-toggle {
            background: none;
            border: 1px solid var(--border);
            color: var(--text-main);
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
        }

        /* --- Hero Секция --- */
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            padding: 100px 5%;
            align-items: center;
        }
        .hero h1 { font-size: 52px; font-weight: 800; line-height: 1.1; margin-bottom: 20px; }
        .hero h1 span { color: var(--primary); }
        .hero p { font-size: 18px; color: var(--text-muted); line-height: 1.6; margin-bottom: 35px; }
        
        .hero-bullets { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 40px; }
        .bullet { display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--text-muted); font-weight: 500;}
        .bullet i { color: var(--primary); }

        .hero-image-placeholder { 
            background: var(--bg-card); 
            border-radius: 20px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); 
            border: 1px solid var(--border); 
            height: 400px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: var(--text-muted);
            position: relative;
            overflow: hidden;
        }
        /* Декорация за картинката */
        .hero-image-placeholder::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: var(--accent);
            filter: blur(80px);
            top: 20%;
            right: 10%;
            opacity: 0.3;
        }

        /* --- Функционалности --- */
        .features { padding: 80px 5%; text-align: center; }
        .grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-top: 50px; }
        .feature-card { background: var(--bg-card); border: 1px solid var(--border); padding: 35px; border-radius: 16px; text-align: left; transition: 0.3s; }
        .feature-card:hover { transform: translateY(-10px); border-color: var(--accent); box-shadow: 0 10px 30px rgba(89, 167, 88, 0.15); }
        .icon { width: 50px; height: 50px; background: rgba(89, 167, 88, 0.1); color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; font-size: 24px; }
        .feature-card h3 { font-size: 20px; margin-bottom: 12px; }

        /* --- Pricing --- */
        .price-card.pro { border: 2px solid var(--accent); transform: scale(1.05); }
        .price-card.pro .btn-full { background: var(--accent); }
        .price-card.pro .btn-full:hover { background: var(--accent-hover); }
        .recommended-badge { background: var(--accent); }
        .price-card { background: var(--bg-card); border: 1px solid var(--border); padding: 40px; border-radius: 20px; }
        .btn-full { display: block; width: 100%; text-align: center; padding: 15px; border-radius: 10px; text-decoration: none; font-weight: 700; margin-top: 20px; box-sizing: border-box; transition: 0.3s; }
        .btn-outline { border: 1px solid var(--primary); color: var(--primary); }
        .btn-outline:hover { background: var(--primary); color: white; }

        /* Responsive */
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; text-align: center; }
            .hero-bullets { justify-content: center; }
            nav { display: none; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <div class="logo-icon">F</div> FinPlanner
        </div>
        <nav>
            <a href="#features">Функционалности</a>
            <a href="#pricing">Цени</a>
            <a href="#about">За нас</a>
        </nav>
        <div class="auth-buttons">
            <button class="dark-mode-toggle" id="theme-toggle">
                <i class="fas fa-moon"></i>
            </button>
            <a href="login.php" class="btn-login">Вход</a>
            <a href="register.php" class="btn-primary">Започни сега</a>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Поеми контрол над <span>бъдещето си</span></h1>
            <p>Модерният начин за следене на лични финанси. Планирай, проследявай и увеличавай своето богатство с FinPlanner.</p>
            
            <div class="hero-bullets">
                <div class="bullet"><i class="fas fa-check-circle"></i> Умно бюджетиране</div>
                <div class="bullet"><i class="fas fa-check-circle"></i> Анализ на активи</div>
                <div class="bullet"><i class="fas fa-check-circle"></i> Цели и спестявания</div>
                <div class="bullet"><i class="fas fa-check-circle"></i> Dark Mode интерфейс</div>
            </div>

            <a href="register.php" class="btn-primary" style="padding: 16px 40px; font-size: 18px;">Стартирай безплатно →</a>
        </div>
        <div class="hero-image-placeholder">
            <i class="fas fa-chart-line fa-4x" style="opacity: 0.2;"></i>
            <p style="position: absolute; bottom: 20px;">Интерактивно табло</p>




        </div>
    </section>

    <section id="features" class="features">
        <h2>Всичко, от което се нуждаеш</h2>
        <div class="grid-4">
            <div class="feature-card">
                <div class="icon"><i class="fas fa-wallet"></i></div>
                <h3>Нетна стойност</h3>
                <p>Следи съотношението между твоите активи и пасиви.</p>
            </div>
            <div class="feature-card">
                <div class="icon"><i class="fas fa-bullseye"></i></div>
                <h3>Финансови цели</h3>
                <p>Постави си цели и проследявай прогреса си лесно.</p>
            </div>
            <div class="feature-card">
                <div class="icon"><i class="fas fa-coins"></i></div>
                <h3>Инвестиции</h3>
                <p>Използвай нашия калкулатор за сложна лихва и анализирай портфолиото си.</p>
            </div>
            <!-- <div class="feature-card">
                <div class="icon"><i class="fas fa-file-export"></i></div>
                <h3>Експорт на данни</h3>
                <p>Изтегли своите отчети в PDF или Excel формат само с един клик.</p>
            </div> -->
        </div>
    </section>

    <section id="pricing" class="pricing" style="text-align: center; padding: 80px 5%;">
        <h2>Избери своя план</h2>
        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 50px; flex-wrap: wrap;">
            
            <div class="price-card">
                <h3>Basic</h3>
                <div style="font-size: 40px; font-weight: 800; margin: 20px 0;">0€ <span style="font-size: 16px; color: var(--text-muted);">/ месец</span></div>
                <ul style="text-align: left; list-style: none; padding: 0; line-height: 2;">
                    <li><i class="fas fa-check" style="color: var(--primary);"></i> Следене на разходи</li>
                    <li><i class="fas fa-check" style="color: var(--primary);"></i> Лични цели (до 3)</li>
                    <li><i class="fas fa-check" style="color: var(--primary);"></i> Валутен калкулатор</li>
                </ul>
                <a href="register.php" class="btn-full btn-outline">Започни</a>
            </div>

            <div class="price-card pro">
                <div class="recommended-badge" style="color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; display: inline-block; margin-bottom: 10px;">ПРЕПОРЪЧАНО</div>
                <h3>Pro</h3>
                <div style="font-size: 40px; font-weight: 800; margin: 20px 0;">9.99€ <span style="font-size: 16px; opacity: 0.8;">/ месец</span></div>
                <ul style="text-align: left; list-style: none; padding: 0; line-height: 2;">
                    <li><i class="fas fa-check"></i> Всичко от Basic</li>
                    <li><i class="fas fa-check"></i> Неограничени инвестиции</li>
                    <li><i class="fas fa-check"></i> Експорт към Excel/PDF</li>
                    <li><i class="fas fa-check"></i> Поддръжка 24/7</li>
                </ul>
                <a href="register.php" class="btn-full" style="color: white;">Вземи Pro план</a>
            </div>

        </div>
    </section>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const icon = themeToggle.querySelector('i');

        // Проверка за запазена тема
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            icon.classList.replace('fa-moon', 'fa-sun');
        }

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                icon.classList.replace('fa-moon', 'fa-sun');
            } else {
                localStorage.setItem('theme', 'light');
                icon.classList.replace('fa-sun', 'fa-moon');
            }
        });
    </script>
</body>
</html>