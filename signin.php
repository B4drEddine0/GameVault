<?php
require_once 'connexion.php';
require_once 'classUser.php';

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
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role_user'];
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
</head>
<body class="bg-gray-900 text-white">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
            <h1 class="text-3xl font-bold text-center mb-8">GameVault</h1>

            <?php if ($error): ?>
                <div class="bg-red-500 text-white p-4 rounded mb-4"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-300 mb-2" for="email">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white" required>
                </div>
                <div>
                    <label class="block text-gray-300 mb-2" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white" required>
                </div>
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg">
                    Se connecter
                </button>
            </form>

            <p class="mt-8 text-center text-gray-400">
                Pas encore de compte? <a href="signup.php" class="text-purple-500">S'inscrire</a>
            </p>
        </div>
    </div>
</body>
</html>
