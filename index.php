<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veltera - Сметни своето бъдеще</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #59a758; --accent: #a658a7; --bg-body: #F8FAFC;
            --bg-card: #FFFFFF; --text-main: #0F172A; --text-muted: #64748B; --border: #E2E8F0;
        }
        body { font-family: 'Inter', sans-serif; margin: 0; background: var(--bg-body); color: var(--text-main); }
        
        header { display: flex; justify-content: space-between; padding: 20px 5%; align-items: center; }
        .logo { font-size: 24px; font-weight: 800; color: var(--primary); text-decoration: none; }

        .hero { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; padding: 60px 5%; align-items: center; }
        
        /* --- Calculator UI --- */
        .calc-box {
            background: var(--bg-card);
            padding: 40px;
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 30px 60px rgba(0,0,0,0.1);
        }
        .calc-box h3 { margin-top: 0; font-size: 20px; margin-bottom: 25px; color: var(--accent); }
        
        .input-wrap { margin-bottom: 25px; }
        .input-wrap label { display: flex; justify-content: space-between; font-weight: 600; font-size: 14px; margin-bottom: 10px; }
        .input-wrap label span { color: var(--primary); font-weight: 800; }
        
        input[type=range] {
            width: 100%;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .result-box {
            background: rgba(89, 167, 88, 0.05);
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            margin-top: 20px;
            border: 1px dashed var(--primary);
        }
        .result-label { font-size: 13px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }
        .result-value { font-size: 36px; font-weight: 800; color: var(--text-main); display: block; margin-top: 5px; }

        .btn-primary { 
            background: var(--primary); color: white; padding: 16px 32px; border-radius: 12px; 
            text-decoration: none; font-weight: 700; display: inline-block; transition: 0.3s; 
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(89,167,88,0.3); }

        @media (max-width: 900px) { .hero { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<header>
    <a href="#" class="logo">Veltera</a>
    <a href="login.php" class="btn-primary" style="padding: 10px 20px;">Вход</a>
</header>

<section class="hero">
    <div>
        <h1 style="font-size: 48px; line-height: 1.1;">Направи първата крачка към <span>финансова свобода</span></h1>
        <p style="font-size: 18px; color: var(--text-muted);">Използвай нашия калкулатор, за да видиш колко можеш да спестиш само за няколко години с правилната стратегия.</p>
        <br>
        <a href="register.php" class="btn-primary">Започни безплатно сега</a>
    </div>

    <div class="calc-box">
        <h3>Калкулатор на богатството</h3>
        
        <div class="input-wrap">
            <label>Месечна вноска: <span id="val-monthly">500 €</span></label>
            <input type="range" id="monthly" min="50" max="5000" step="50" value="500" oninput="calculate()">
        </div>

        <div class="input-wrap">
            <label>Годишна доходност: <span id="val-yield">8 %</span></label>
            <input type="range" id="yield" min="1" max="15" step="0.5" value="8" oninput="calculate()">
        </div>

        <div class="input-wrap">
            <label>Период (години): <span id="val-years">10 г.</span></label>
            <input type="range" id="years" min="1" max="40" step="1" value="10" oninput="calculate()">
        </div>

        <div class="result-box">
            <span class="result-label">След този период ще имате:</span>
            <span class="result-value" id="total-result">92,408 €</span>
        </div>
        
        <p style="font-size: 11px; color: var(--text-muted); margin-top: 15px; text-align: center;">* Изчисленията са базирани на сложна лихва с месечно начисляване.</p>
    </div>
</section>

<script>
    function calculate() {
        const monthly = parseFloat(document.getElementById('monthly').value);
        const annualRate = parseFloat(document.getElementById('yield').value) / 100;
        const years = parseInt(document.getElementById('years').value);
        
        // Обновяване на етикетите
        document.getElementById('val-monthly').innerText = monthly + " €";
        document.getElementById('val-yield').innerText = annualRate * 100 + " %";
        document.getElementById('val-years').innerText = years + " г.";

        // Формула за сложна лихва при месечни вноски
        const r = annualRate / 12;
        const n = years * 12;
        const total = monthly * ((Math.pow(1 + r, n) - 1) / r) * (1 + r);

        document.getElementById('total-result').innerText = new Intl.NumberFormat('de-DE').format(Math.round(total)) + " €";
    }
</script>

</body>
</html>