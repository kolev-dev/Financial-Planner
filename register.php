<?php
require 'includes/db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Криптиране на паролата

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$user, $email, $pass]);
        header("Location: login.php?success=1");
        exit();
    } catch (PDOException $e) {
        $message = "Грешка: Имейлът вече съществува!";
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Регистрация - FinPlanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #59a758;
            --accent: #a658a7;
            --bg-body: #F8FAFC;
            --bg-card: #FFFFFF;
            --text-main: #0F172A;
            --border: #E2E8F0;
        }
        body.dark-mode {
            --bg-body: #0f172a; --bg-card: #1e293b; --text-main: #f1f5f9; --border: #334155;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; transition: 0.3s; }
        
        .auth-card { background: var(--bg-card); padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border: 1px solid var(--border); }
        .auth-card h2 { text-align: center; color: var(--primary); margin-bottom: 30px; font-weight: 800; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-body); color: var(--text-main); box-sizing: border-box; outline: none; }
        .form-group input:focus { border-color: var(--primary); }
        
        .btn-auth { width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; font-size: 16px; }
        .btn-auth:hover { opacity: 0.9; transform: translateY(-2px); }
        
        .switch-auth { text-align: center; margin-top: 20px; font-size: 14px; }
        .switch-auth a { color: var(--accent); text-decoration: none; font-weight: 600; }
        
        .error { color: #e74c3c; text-align: center; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="auth-card">
        <h2>Регистрация</h2>
        <?php if($message): ?> <div class="error"><?php echo $message; ?></div> <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Потребителско име</label>
                <input type="text" name="username" required placeholder="Ivan123">
            </div>
            <div class="form-group">
                <label>Имейл адрес</label>
                <input type="email" name="email" required placeholder="ivan@example.com">
            </div>
            <div class="form-group">
                <label>Парола</label>
                <input type="password" name="password" required placeholder="********">
            </div>
            <button type="submit" class="btn-auth">Създай профил</button>
        </form>
        
        <div class="switch-auth">
            Вече имаш профил? <a href="login.php">Влез тук</a>
        </div>
    </div>

    <script>
        if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');
    </script>
</body>
</html>