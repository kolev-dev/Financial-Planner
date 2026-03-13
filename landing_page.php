<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Финансов Планер - Начало</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Твоите нови цветове */
            --primary: #A633CC; /* Лилаво */
            --primary-hover: #8F2BB0; /* Малко по-тъмно лилаво за hover ефект */
            --accent: #59CC33; /* Зелено */
            
            /* Базови цветове за фон и текст */
            --bg-light: #F8FAFC;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-dark);
            background-color: var(--white);
            -webkit-font-smoothing: antialiased;
        }

        /* --- Хедър --- */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo { font-size: 24px; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 10px; }
        .logo-icon { width: 30px; height: 30px; background: var(--primary); color: white; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        nav { display: flex; gap: 30px; }
        nav a { text-decoration: none; color: var(--text-muted); font-weight: 500; font-size: 15px; transition: color 0.3s; }
        nav a:hover { color: var(--primary); }
        .auth-buttons { display: flex; gap: 15px; align-items: center; }
        .btn-login { text-decoration: none; color: var(--primary); font-weight: 600; font-size: 15px; }
        .btn-primary { background: var(--primary); color: var(--white); padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s; }
        .btn-primary:hover { background: var(--primary-hover); }

        /* --- Hero Секция --- */
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            padding: 80px 5%;
            align-items: center;
            background: linear-gradient(to bottom, #ffffff, var(--bg-light));
        }
        .hero h1 { font-size: 48px; font-weight: 800; line-height: 1.2; margin-bottom: 20px; color: var(--primary); }
        .hero p { font-size: 18px; color: var(--text-muted); line-height: 1.6; margin-bottom: 30px; }
        .hero-bullets { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 40px; }
        .bullet { display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--text-muted); font-weight: 500;}
        .bullet::before { content: '✔'; color: var(--accent); font-weight: bold; }
        .hero-image-placeholder { background: white; border-radius: 12px; box-shadow: 0 20px 40px rgba(166, 51, 204, 0.08); border: 1px solid var(--border); height: 400px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); }

        /* --- Функционалности --- */
        .features { padding: 80px 5%; text-align: center; }
        .features-header h2 { font-size: 32px; color: var(--primary); margin-bottom: 15px; }
        .features-header p { color: var(--text-muted); max-width: 600px; margin: 0 auto 50px auto; }
        .grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
        .feature-card { background: white; border: 1px solid var(--border); padding: 30px; border-radius: 12px; text-align: left; transition: transform 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(166, 51, 204, 0.08); }
        .icon { width: 40px; height: 40px; background: rgba(166, 51, 204, 0.1); color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 20px; }
        .feature-card h3 { font-size: 18px; margin-bottom: 10px; color: var(--primary); }
        .feature-card p { font-size: 14px; color: var(--text-muted); line-height: 1.5; }

        /* --- Статистики --- */
        .stats { padding: 60px 5%; background: rgba(166, 51, 204, 0.03); text-align: center; }
        .stats h2 { font-size: 32px; color: var(--primary); margin-bottom: 40px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .stat-card { background: white; padding: 30px; border-radius: 12px; border: 1px solid var(--border); }
        .stat-card h4 { font-size: 24px; margin: 10px 0; color: var(--primary); font-weight: 700; }
        .stat-card p { font-size: 14px; color: var(--text-muted); margin: 0; }

        /* --- Абонаменти (Pricing) --- */
        .pricing { padding: 80px 5%; text-align: center; }
        .pricing h2 { font-size: 32px; color: var(--primary); margin-bottom: 10px; }
        .toggle-container { display: flex; justify-content: center; align-items: center; gap: 15px; margin: 30px 0 50px 0; font-size: 14px; font-weight: 500; }
        .toggle-switch { width: 50px; height: 26px; background: var(--primary); border-radius: 13px; position: relative; cursor: pointer; }
        .toggle-circle { width: 20px; height: 20px; background: white; border-radius: 50%; position: absolute; top: 3px; left: 3px; transition: transform 0.3s; }
        .discount-badge { background: rgba(89, 204, 51, 0.15); color: #3e9921; padding: 4px 8px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        
        .pricing-grid { display: flex; justify-content: center; gap: 30px; max-width: 900px; margin: 0 auto; }
        .price-card { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 40px; width: 100%; max-width: 400px; text-align: left; box-shadow: 0 10px 30px rgba(0,0,0,0.03); position: relative; }
        .price-card.pro { border-color: var(--primary); box-shadow: 0 15px 40px rgba(166, 51, 204, 0.15); }
        .recommended-badge { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--primary); color: white; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .price-card h3 { font-size: 24px; color: var(--primary); margin-bottom: 10px; }
        .price-desc { font-size: 14px; color: var(--text-muted); margin-bottom: 20px; display: block; }
        .price { font-size: 48px; font-weight: 800; color: var(--text-dark); display: flex; align-items: baseline; gap: 5px; }
        .price span { font-size: 16px; font-weight: 500; color: var(--text-muted); }
        .price-card ul { list-style: none; padding: 0; margin: 30px 0; }
        .price-card li { margin-bottom: 15px; font-size: 14px; color: var(--text-dark); display: flex; gap: 10px; align-items: flex-start; }
        .price-card li::before { content: '✔'; color: var(--accent); font-weight: bold; }
        .btn-full { display: block; width: 100%; text-align: center; background: var(--primary); color: white; padding: 14px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 20px; box-sizing: border-box; transition: background 0.3s;}
        .btn-full:hover { background: var(--primary-hover); }
        .btn-outline { background: white; color: var(--primary); border: 1px solid var(--primary); }
        .btn-outline:hover { background: rgba(166, 51, 204, 0.05); }

    </style>
</head>
<body>

    <header>
        <div class="logo">
            <div class="logo-icon">F</div> FinPlanner.
        </div>
        <nav>
            <a href="#features">Функционалности</a>
            <a href="#pricing">Цени</a>
            <a href="#about">За нас</a>
            <a href="#contact">Контакти</a>
        </nav>
        <div class="auth-buttons">
            <a href="login.php" class="btn-login">Вход</a>
            <a href="register.php" class="btn-primary">Стартирай безплатно</a>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Поеми контрол над бъдещето си</h1>
            <p>Планирай, проследявай и увеличавай своето богатство с FinPlanner – цялостна платформа за управление на лични финанси и инвестиции.</p>
            
            <div class="hero-bullets">
                <div class="bullet">Умно бюджетиране</div>
                <div class="bullet">Анализ на инвестиции</div>
                <div class="bullet">Постигане на цели</div>
                <div class="bullet">Инструменти за имоти</div>
            </div>

            <a href="register.php" class="btn-primary" style="display: inline-block;">Стартирай безплатно →</a>
        </div>
        <div class="hero-image-placeholder">
            [ Тук ще стои снимка на Таблото (Dashboard-а) ]
        </div>
    </section>

    <section id="features" class="features">
        <div class="features-header">
            <h2>Всичко, от което се нуждаеш</h2>
            <p>От първите стъпки в бюджетирането до задълбочен анализ на инвестиции.</p>
        </div>

        <div class="grid-4">
            <div class="feature-card">
                <div class="icon">📊</div>
                <h3>Финансов планер</h3>
                <p>Умни инструменти за бюджетиране, които помагат да планираш уверено бъдещето си.</p>
            </div>
            <div class="feature-card">
                <div class="icon">🎯</div>
                <h3>Цели и напредък</h3>
                <p>Постави финансови цели и следи прогреса си с помощта на интелигентни анализи.</p>
            </div>
            <div class="feature-card">
                <div class="icon">📈</div>
                <h3>Нетна стойност</h3>
                <p>Проследявай в реално време стойността на всичките си активи и пасиви.</p>
            </div>
            <div class="feature-card">
                <div class="icon">💰</div>
                <h3>Приходи и разходи</h3>
                <p>Следи месечния си бюджет с автоматично категоризиране и детайлни анализи.</p>
            </div>
        </div>
    </section>

    <section id="about" class="stats">
        <h2>За FinPlanner Academy</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon" style="margin: 0 auto; background: none; font-size: 32px;">🏆</div>
                <h4>#1 в България</h4>
                <p>Най-голямата платформа</p>
            </div>
            <div class="stat-card">
                <div class="icon" style="margin: 0 auto; background: none; font-size: 32px;">👥</div>
                <h4>60,000+</h4>
                <p>Доволни потребители</p>
            </div>
            <div class="stat-card">
                <div class="icon" style="margin: 0 auto; background: none; font-size: 32px;">⭐</div>
                <h4>5+ награди</h4>
                <p>За качество и иновации</p>
            </div>
            <div class="stat-card">
                <div class="icon" style="margin: 0 auto; background: none; font-size: 32px;">💡</div>
                <h4>Реални решения</h4>
                <p>Базирани на нуждите ви</p>
            </div>
        </div>
    </section>

    <section id="pricing" class="pricing">
        <h2>Избери своя план</h2>
        <p style="color: var(--text-muted);">Започни с 30-дневен безплатен trial. Откажи се по всяко време.</p>
        
        <div class="toggle-container">
            <span>Месечно</span>
            <div class="toggle-switch">
                <div class="toggle-circle" style="transform: translateX(24px);"></div>
            </div>
            <span>Годишно</span>
            <span class="discount-badge">Спести до 33%</span>
        </div>

        <div class="pricing-grid">
            <div class="price-card">
                <h3>Basic</h3>
                <span class="price-desc">За лични финанси и първи стъпки</span>
                <div class="price">36€ <span>/ година</span></div>
                
                <ul>
                    <li>Месечен бюджет</li>
                    <li>Финансови цели</li>
                    <li>Анализ на приходи и разходи</li>
                    <li>Нетно състояние</li>
                </ul>
                <a href="#" class="btn-full btn-outline">Избери Basic</a>
            </div>

            <div class="price-card pro">
                <div class="recommended-badge">Препоръчан</div>
                <h3>Pro</h3>
                <span class="price-desc">За активни инвеститори и дългосрочни решения</span>
                <div class="price">97€ <span>/ година</span></div>
                
                <ul>
                    <li><strong>Всичко от Basic</strong></li>
                    <li>Неограничени анализи на имоти</li>
                    <li>Бюджет за ремонт</li>
                    <li>Проследяване на инвестиционни имоти</li>
                    <li>Неограничен анализ на акции</li>
                </ul>
                <a href="#" class="btn-full">Избери Pro</a>
            </div>
        </div>
    </section>

</body>
</html>