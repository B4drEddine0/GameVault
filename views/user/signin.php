<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../classes/User.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } else {
        $dbConnection = (new DbConnection())->getConnection();

        if ($dbConnection) {
            try {
                $stmt = $dbConnection->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['user_password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['users_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role_user'];
                    $_SESSION['image'] = $user['image'];
                    header("Location: " . ($_SESSION['role'] === 'admin' ? 'dashboard.php' : 'index.php'));
                    exit();
                } else {
                    $error = "Email ou mot de passe incorrect.";
                }
            } catch (PDOException $e) {
                $error = "Erreur: " . $e->getMessage();
            }
        } else {
            $error = "Connexion à la base de données impossible.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(to right, #818cf8, #6366f1);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .glow-effect {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }
        body {
            background: linear-gradient(to bottom, #1e1b4b, #111827);
            min-height: 100vh;
        }
    </style>
</head>
<body class="text-zinc-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-zinc-800/30 p-8 rounded-lg shadow-xl w-full max-w-md backdrop-blur-sm border border-zinc-700/30">
            <h1 class="text-3xl font-bold text-center mb-2">Game<span class="gradient-text">Vault</span></h1>
            <p class="text-center text-zinc-400 mb-8">Bienvenue dans <span class="gradient-text">Votre Univers</span></p>

            <?php if ($error): ?>
                <div class="bg-red-500/10 text-red-400 p-4 rounded mb-4"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <div>
                    <label class="block text-zinc-300 mb-2" for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-3 rounded-lg bg-zinc-800/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all" required>
                </div>
                <div>
                    <label class="block text-zinc-300 mb-2" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-3 rounded-lg bg-zinc-800/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all" required>
                </div>
                <button type="submit" 
                        class="w-full bg-indigo-600/90 hover:bg-indigo-500 text-white font-bold py-3 px-4 rounded-lg transition-colors glow-effect">
                    Se connecter
                </button>
            </form>

            <p class="mt-8 text-center text-zinc-400">
                Pas encore de compte? <a href="signup.php" class="gradient-text hover:opacity-80 transition-opacity">S'inscrire</a>
            </p>
        </div>
    </div>
</body>
</html>
