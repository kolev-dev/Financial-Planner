<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];

// Примерно извличане на общи суми за Net Worth (за логиката)
// В реалния код тук ще имаме SQL заявки SELECT SUM...
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Veltra - Бюджет и Баланс</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --primary: #59a758; --accent: #a658a7; --bg: #F8FAFC; --card: #FFFFFF; --text: #0F172A; --border: #E2E8F0; }
        body.dark-mode { --bg: #0f172a; --card: #1e293b; --text: #f1f5f9; --border: #334155; }
        
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); margin: 0; transition: 0.3s; }
        
        /* --- Sub-Nav Navbar --- */
        .sub-nav {
            display: flex;
            justify-content: center;
            background: var(--card);
            padding: 10px;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .segmented-control {
            display: flex;
            background: var(--bg);
            padding: 5px;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        .segment-btn {
            padding: 10px 25px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            background: transparent;
            color: var(--text);
            transition: 0.3s;
        }
        .segment-btn.active { background: var(--primary); color: white; box-shadow: 0 4px 10px rgba(89, 167, 88, 0.3); }

        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        
        .card { background: var(--card); border-radius: 20px; padding: 25px; border: 1px solid var(--border); margin-bottom: 25px; }
        
        /* Форми */
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-size: 13px; font-weight: 600; }
        input, select { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid var(--border); background: var(--bg); color: var(--text); box-sizing: border-box; }
        
        .btn-add { background: var(--primary); color: white; border: none; padding: 12px; border-radius: 10px; width: 100%; font-weight: 700; cursor: pointer; margin-top: 10px; }
        
        /* Net Worth Display */
        .net-worth-val { font-size: 36px; font-weight: 800; color: var(--primary); margin: 10px 0; }
        .stats-row { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-box { flex: 1; padding: 15px; border-radius: 15px; background: rgba(89, 167, 88, 0.1); border: 1px solid var(--primary); }
        .stat-box.liability { background: rgba(166, 88, 167, 0.1); border: 1px solid var(--accent); }

        .hidden { display: none; }
    </style>
</head>
<body>

<div class="sub-nav">
    <div class="segmented-control">
        <button class="segment-btn active" onclick="switchTab('budget')">Приходи и Разходи</button>
        <button class="segment-btn" onclick="switchTab('balance')">Баланс и Net Worth</button>
    </div>
</div>

<div class="container">
    
    <!-- СЕКЦИЯ 1: БЮДЖЕТ -->
    <div id="budget-tab">
        <div class="grid">
            <div>
                <div class="card">
                    <h3>Нова трансакция</h3>
                    <form method="POST" action="actions/add_transaction.php">
                        <div class="stats-row">
                            <div class="form-group" style="flex: 1;">
                                <label>Тип</label>
                                <select name="type" id="trans-type" onchange="updateCategories()">
                                    <option value="expense">Разход</option>
                                    <option value="income">Приход</option>
                                </select>
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label>Категория</label>
                                <select name="category" id="trans-cat">
                                    <!-- Ще се пълни от JS -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Сума (BGN)</label>
                            <input type="number" name="amount" step="0.01" required placeholder="0.00">
                        </div>
                        <button type="submit" class="btn-add">Впиши в бюджета</button>
                    </form>
                </div>
                
                <div class="card">
                    <h3>Последни трансакции</h3>
                    <p style="color: var(--text-muted); font-size: 14px;">Тук ще се визуализира списъкът с историята.</p>
                </div>
            </div>
            
            <div>
                <div class="card">
                    <h3>Правило 50/30/20</h3>
                    <canvas id="budgetChart"></canvas>
                    <p style="font-size: 12px; margin-top: 15px; color: var(--text-muted);">
                        Препоръчително: 50% Нужди, 30% Желания, 20% Спестявания/Дългове.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- СЕКЦИЯ 2: БАЛАНС -->
    <div id="balance-tab" class="hidden">
        <div class="card" style="text-align: center;">
            <p style="margin: 0; text-transform: uppercase; font-size: 12px; font-weight: 700; letter-spacing: 1px;">Твоето нетно състояние</p>
            <div class="net-worth-val">42,560.00 лв.</div>
            <div class="stats-row">
                <div class="stat-box">
                    <small>Общо Активи</small>
                    <div style="font-weight: 700;">+ 55,000.00 лв.</div>
                </div>
                <div class="stat-box liability">
                    <small>Общо Пасиви</small>
                    <div style="font-weight: 700;">- 12,440.00 лв.</div>
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <h3>Разпределение на активите</h3>
                <div style="max-width: 300px; margin: 0 auto;">
                    <canvas id="assetsChart"></canvas>
                </div>
            </div>
            
            <div class="card">
                <h3>Добави Актив / Кредит</h3>
                <form>
                    <div class="form-group">
                        <label>Клас актив</label>
                        <select>
                            <option>Кеш</option>
                            <option>Недвижимо имущество</option>
                            <option>Крипто</option>
                            <option>Акции</option>
                            <option>Облигации</option>
                            <option>Кредит (Пасив)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Наименование (напр. Апартамент, BTC, Ипотека)</label>
                        <input type="text" placeholder="Име...">
                    </div>
                    <div class="form-group">
                        <label>Стойност / Оставаща главница</label>
                        <input type="number" placeholder="0.00">
                    </div>
                    <button type="button" class="btn-add" style="background: var(--accent);">Обнови баланса</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Таб Мениджър
    function switchTab(tab) {
        document.querySelectorAll('.segment-btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        if(tab === 'budget') {
            document.getElementById('budget-tab').classList.remove('hidden');
            document.getElementById('balance-tab').classList.add('hidden');
        } else {
            document.getElementById('budget-tab').classList.add('hidden');
            document.getElementById('balance-tab').classList.remove('hidden');
            initAssetsChart(); // Инициализираме графиката при показване
        }
    }

    // Динамични категории
    function updateCategories() {
        const type = document.getElementById('trans-type').value;
        const catSelect = document.getElementById('trans-cat');
        catSelect.innerHTML = "";
        
        if(type === 'expense') {
            const options = ["Нужда", "Желание", "Погасяване на дълг"];
            options.forEach(opt => catSelect.innerHTML += `<option value="${opt}">${opt}</option>`);
        } else {
            const options = ["Месечен приход (Заплата)", "Еднократен приход"];
            options.forEach(opt => catSelect.innerHTML += `<option value="${opt}">${opt}</option>`);
        }
    }
    updateCategories();

    // ГРАФИКИ
    const ctxBudget = document.getElementById('budgetChart').getContext('2d');
    new Chart(ctxBudget, {
        type: 'doughnut',
        data: {
            labels: ['Нужди', 'Желания', 'Спестявания'],
            datasets: [{
                data: [50, 30, 20],
                backgroundColor: ['#59a758', '#a658a7', '#3498db']
            }]
        }
    });

    function initAssetsChart() {
        const ctxAssets = document.getElementById('assetsChart').getContext('2d');
        new Chart(ctxAssets, {
            type: 'pie',
            data: {
                labels: ['Кеш', 'Имоти', 'Крипто', 'Акции'],
                datasets: [{
                    data: [10, 60, 15, 15],
                    backgroundColor: ['#59a758', '#a658a7', '#f1c40f', '#e74c3c']
                }]
            }
        });
    }

    if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');
</script>

</body>
</html>