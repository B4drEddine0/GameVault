<?php
session_start();
require_once 'connexion.php';
require_once 'UserClass.php';

$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } else {
        $dbConnection = (new DbConnection())->getConnection();

        if ($dbConnection) {
            try {
                $stmt = $dbConnection->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);

                if ($stmt->fetchColumn()) {
                    $error = "Cet email est déjà utilisé.";
                } else {
                    $user = new User(null, $username, $email, $password, 'joueur');
                    $user->hashPassword();

                    $stmt = $dbConnection->prepare("
                        INSERT INTO users (username, email, user_password, role_user)
                        VALUES (:username, :email, :user_password, :role_user)
                    ");
                    if ($stmt->execute([
                        'username' => $user->getUsername(),
                        'email' => $user->getEmail(),
                        'user_password' => $user->getPassword(),
                        'role_user' => $user->getRole()
                    ])) {
                        $success = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                    } else {
                        $error = "Erreur lors de l'inscription.";
                    }
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
    <title>GameVault - Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
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
            <p class="text-center text-zinc-400 mb-8">Créez <span class="gradient-text">Votre Compte</span></p>

            <?php if ($error): ?>
                <div class="bg-red-500/10 text-red-400 p-4 rounded mb-4"><?= htmlspecialchars($error) ?></div>
            <?php elseif ($success): ?>
                <div class="bg-green-500/10 text-green-400 p-4 rounded mb-4"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block text-zinc-300 mb-2">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" 
                           class="w-full px-4 py-3 rounded-lg bg-zinc-800/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all" required>
                </div>
                <div>
                    <label for="email" class="block text-zinc-300 mb-2">Email</label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-3 rounded-lg bg-zinc-800/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all" required>
                </div>
                <div>
                    <label for="password" class="block text-zinc-300 mb-2">Mot de passe</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-3 rounded-lg bg-zinc-800/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all" required>
                </div>
                <button type="submit" 
                        class="w-full bg-indigo-600/90 hover:bg-indigo-500 text-white font-bold py-3 px-4 rounded-lg transition-colors glow-effect">
                    S'inscrire
                </button>
            </form>

            <p class="mt-8 text-center text-zinc-400">
                Déjà un compte? <a href="signin.php" class="gradient-text hover:opacity-80 transition-opacity">Se connecter</a>
            </p>
        </div>
    </div>
</body>
</html>
