<?php
session_start();
// Проверка дали потребителят е влязъл
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veltra - Табло</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #59a758;
            --primary-hover: #4a8c49;
            --accent: #a658a7;
            --bg-body: #F8FAFC;
            --bg-card: #FFFFFF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border: #E2E8F0;
        }

        body.dark-mode {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: 0.3s;
        }

        /* --- Navigation --- */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo { font-size: 24px; font-weight: 800; color: var(--primary); text-decoration: none; }
        
        .nav-actions { display: flex; gap: 20px; align-items: center; }

        .calc-btn {
            background: rgba(166, 88, 167, 0.1);
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .calc-btn:hover { background: var(--accent); color: white; }

        /* --- Main Content --- */
        .container { padding: 40px 5%; max-width: 1200px; margin: 0 auto; }
        
        .welcome-section { margin-bottom: 40px; }
        .welcome-section h1 { font-size: 32px; font-weight: 800; }
        .welcome-section span { color: var(--primary); }

        /* --- Grid --- */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }

        .card i {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .card.budget i { color: var(--primary); }
        .card.goals i { color: var(--accent); }
        .card.assets i { color: #3498db; }

        .card h3 { font-size: 22px; margin-bottom: 15px; }
        .card p { color: var(--text-muted); font-size: 15px; line-height: 1.6; }

        /* --- Modal (Converter) --- */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: var(--bg-card);
            padding: 30px;
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 20px;
            color: var(--text-muted);
        }

        .converter-grid {
            display: grid;
            gap: 15px;
            margin-top: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-muted);
        }

        .input-group input {
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--bg-body);
            color: var(--text-main);
            font-size: 16px;
            font-weight: 600;
        }

        .live-indicator {
            font-size: 11px;
            color: var(--primary);
            text-align: center;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
    </style>
</head>
<body>

    <nav>
        <a href="#" class="logo">Veltra.</a>
        <div class="nav-actions">
            <button class="calc-btn" onclick="openModal()">
                <i class="fas fa-calculator"></i> Калкулатор
            </button>
            <div style="font-weight: 600; font-size: 14px;">
                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($username); ?>
            </div>
            <a href="logout.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">Изход</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <h1>Здравей, <span><?php echo htmlspecialchars($username); ?>!</span></h1>
            <p>Днес е страхотен ден да организираш финансите си.</p>
        </div>

        <div class="feature-grid">
            <!-- Бюджетиране -->
            <a href="budgeting.php" class="card budget">
                <i class="fas fa-wallet"></i>
                <h3>Умно бюджетиране</h3>
                <p>Проследявай приходите и разходите си автоматично и виж къде отиват парите ти.</p>
            </a>

            <!-- Цели -->
            <a href="goals.php" class="card goals">
                <i class="fas fa-bullseye"></i>
                <h3>Цели и спестявания</h3>
                <p>Задай своите финансови цели и следи прогреса си с интелигентни известия за крайни срокове.</p>
            </a>

            <!-- Активи -->
            <a href="assets.php" class="card assets">
                <i class="fas fa-chart-pie"></i>
                <h3>Анализ на активи</h3>
                <p>Пълен преглед на твоето нетно състояние (Net Worth) – имоти, акции и кеш на едно място.</p>
            </a>
        </div>
    </div>

    <!-- Modal за Валутен Калкулатор -->
    <div id="calcModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2 style="margin-top:0; color: var(--accent);">Валутен конвертор</h2>
            <p style="font-size: 13px; color: var(--text-muted);">Въведи стойност в някое от полетата:</p>

            <div class="converter-grid">
                <div class="input-group">
                    <label>EUR (Евро)</label>
                    <input type="number" id="eur" placeholder="0.00" oninput="convert('eur')">
                </div>
                <div class="input-group">
                    <label>USD (Щатски долар)</label>
                    <input type="number" id="usd" placeholder="0.00" oninput="convert('usd')">
                </div>
                <div class="input-group">
                    <label>BTC (Bitcoin)</label>
                    <input type="number" id="btc" placeholder="0.00" oninput="convert('btc')">
                </div>
                <div class="input-group">
                    <label>GOLD (Злато - грам)</label>
                    <input type="number" id="gold" placeholder="0.00" oninput="convert('gold')">
                </div>
            </div>

            <div class="live-indicator">
                <i class="fas fa-sync-alt fa-spin"></i> Live пазарни данни са заредени
            </div>
        </div>
    </div>

    <script>
        // ДАННИ ЗА КОНВЕРТИРАНЕ (Live)
        let rates = {
            usd: 0,
            eur: 0,
            btc: 0,
            gold: 75.50 // Приблизителна цена за грам 24к в лева
        };

        async function fetchRates() {
            try {
                // Използваме безплатно API за фиатни валути
                const fiatRes = await fetch('https://open.er-api.com/v6/latest/EUR');
                const fiatData = await fiatRes.json();
                rates.usd = fiatData.rates.USD;


                const cryptoRes = await fetch('https://api.binance.com/api/v3/ticker/price?symbol=BTCEUR');
                const cryptoData = await cryptoRes.json();

                // Тук получаваме директно цената на 1 BTC в EUR
                const btcPriceInEur = parseFloat(cryptoData.price);
                rates.btc = 1 / btcPriceInEur;
                
                console.log("Курсовете са обновени");
            } catch (error) {
                console.error("Грешка при зареждане на данни:", error);
            }
        }

        function convert(source) {
            const val = parseFloat(document.getElementById(source).value);
            if (isNaN(val)) return;

            let eurValue = 0;
            if (source === 'eur') eurValue = val;
            else if (source === 'usd') eurValue = val / rates.usd;
            else if (source === 'btc') eurValue = val / rates.btc;
            else if (source === 'gold') eurValue = val * rates.gold;

            if (source !== 'eur') document.getElementById('eur').value = (eurValue * rates.eur).toFixed(2);
            if (source !== 'usd') document.getElementById('usd').value =  (eurValue * rates.usd).toFixed(2);
            if (source !== 'btc') document.getElementById('btc').value = (eurValue * rates.btc).toFixed(8);
            if (source !== 'gold') document.getElementById('gold').value = (eurValue / rates.gold).toFixed(2);
        }

        // Modal Logic
        function openModal() {
            document.getElementById('calcModal').style.display = 'flex';
            fetchRates(); // Обновяваме курсовете при отваряне
        }

        function closeModal() {
            document.getElementById('calcModal').style.display = 'none';
        }

        // Затваряне при клик извън съдържанието
        window.onclick = function(event) {
            if (event.target == document.getElementById('calcModal')) closeModal();
        }

        // Dark Mode поддръжка
        if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');
    </script>
</body>
</html>