<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];

// Вземане на целите от базата
$stmt = $pdo->prepare("SELECT * FROM financial_goals WHERE user_id = ? ORDER BY deadline ASC");
$stmt->execute([$user_id]);
$goals = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Veltra - Цели</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --primary: #59a758; --accent: #a658a7; --bg: #F8FAFC; --card: #FFFFFF; --text: #0F172A; --border: #E2E8F0; }
        body.dark-mode { --bg: #0f172a; --card: #1e293b; --text: #f1f5f9; --border: #334155; }
        
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); margin: 0; transition: 0.3s; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        /* Empty State */
        .empty-state { text-align: center; padding: 80px 20px; background: var(--card); border-radius: 30px; border: 2px dashed var(--border); }
        .empty-state i { font-size: 60px; color: var(--primary); opacity: 0.5; margin-bottom: 20px; }
        
        /* Goal Cards */
        .goal-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; }
        .goal-card { background: var(--card); border-radius: 20px; padding: 25px; border: 1px solid var(--border); transition: 0.3s; cursor: pointer; }
        .goal-card:hover { transform: translateY(-5px); border-color: var(--accent); box-shadow: 0 15px 30px rgba(166, 88, 167, 0.1); }
        
        .progress-container { background: var(--bg); height: 10px; border-radius: 5px; margin: 20px 0; }
        .progress-bar { height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 5px; transition: 1s ease-in-out; }
        
        .deadline-badge { font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 20px; display: inline-block; margin-top: 10px; }
        .near-deadline { background: rgba(231, 76, 60, 0.1); color: #e74c3c; animation: pulse 2s infinite; }
        .safe-deadline { background: rgba(89, 167, 88, 0.1); color: var(--primary); }

        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }

        /* Modal */
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); justify-content: center; align-items: center; }
        .modal-content { background: var(--card); padding: 40px; border-radius: 24px; width: 90%; max-width: 550px; position: relative; }
        .btn-primary { width: 100%; padding: 15px; background: var(--primary); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; margin-top: 20px; }
        
        input, select { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid var(--border); background: var(--bg); color: var(--text); box-sizing: border-box; margin-bottom: 15px; }
        label { font-size: 13px; font-weight: 700; margin-bottom: 5px; display: block; color: var(--text-muted); }

        .fab { position: fixed; bottom: 30px; right: 30px; background: var(--primary); color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; cursor: pointer; border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="margin: 0; font-weight: 800;">Финансови Цели</h1>
            <p style="color: var(--text-muted);">Твоят път към успеха в €</p>
        </div>
        <a href="dashboard.php" style="text-decoration: none; color: var(--accent); font-weight: 600;"><i class="fas fa-arrow-left"></i> Назад</a>
    </div>

    <?php if (empty($goals)): ?>
        <div class="empty-state">
            <i class="fas fa-bullseye"></i>
            <h2>Нямаш активни цели</h2>
            <p style="color: var(--text-muted); margin-bottom: 25px;">Започни да планираш бъдещето си днес.</p>
            <button onclick="openModal('addGoalModal')" class="btn-primary" style="width: auto; padding: 12px 30px;">Добави първа цел</button>
        </div>
    <?php else: ?>
        <div class="goal-grid">
            <?php foreach ($goals as $goal): 
                $percent = ($goal['target_amount'] > 0) ? ($goal['current_amount'] / $goal['target_amount']) * 100 : 0;
                $days_left = (strtotime($goal['deadline']) - time()) / (60 * 60 * 24);
                $is_urgent = $days_left < 30;
                // Форматиране на датата dd/mm/yyyy
                $formatted_date = date('d/m/Y', strtotime($goal['deadline']));
            ?>
                <div class="goal-card" onclick="alert('Детайли за целта и графика очаквайте скоро!')">
                    <h3 style="margin-top: 0;"><?php echo htmlspecialchars($goal['title']); ?></h3>
                    
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?php echo min($percent, 100); ?>%"></div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 15px;">
                        <span><?php echo number_format($goal['current_amount'], 2); ?> €</span>
                        <span style="color: var(--text-muted);">от <?php echo number_format($goal['target_amount'], 2); ?> €</span>
                    </div>

                    <div class="deadline-badge <?php echo $is_urgent ? 'near-deadline' : 'safe-deadline'; ?>">
                        <i class="far fa-calendar-alt"></i> 
                        <?php echo $is_urgent ? "Срокът изтича след " . round($days_left) . " дни!" : "Срок: " . $formatted_date; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="fab" onclick="openModal('addGoalModal')"><i class="fas fa-plus"></i></button>
    <?php endif; ?>
</div>

<!-- Modal за Добавяне -->
<div id="addGoalModal" class="modal">
    <div class="modal-content">
        <h2 style="margin-top: 0; color: var(--primary);">Нова цел</h2>
        <form action="actions/add_goal.php" method="POST">
            <label>Име на целта</label>
            <input type="text" name="title" required placeholder="Напр. Нов лаптоп">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label>Целева сума (€)</label>
                    <input type="number" name="target_amount" step="0.01" required>
                </div>
                <div>
                    <label>Краен срок</label>
                    <input type="date" name="deadline" required>
                </div>
            </div>

            <div style="background: var(--bg); padding: 15px; border-radius: 12px; border: 1px solid var(--border);">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_invested" style="width: auto; margin: 0;"> Инвестирам за тази цел
                </label>
                <div id="invest_fields" style="display:none; margin-top: 10px;">
                    <label>Очаквана год. доходност (%)</label>
                    <input type="number" name="expected_return" step="0.1" value="7.0">
                </div>
            </div>

            <button type="submit" class="btn-primary">Запази целта</button>
            <button type="button" onclick="closeModal('addGoalModal')" style="background:none; border:none; color:var(--text-muted); width:100%; margin-top:10px; cursor:pointer;">Отказ</button>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    
    document.querySelector('input[name="is_invested"]').addEventListener('change', function() {
        document.getElementById('invest_fields').style.display = this.checked ? 'block' : 'none';
    });

    if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');
</script>
</body>
</html>