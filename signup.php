<?php
require_once 'connexion.php';
require_once 'classUser.php';

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
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-4">GameVault</h1>
        <p class="text-gray-400 text-center mb-8">Créez votre compte</p>

        <?php if ($error): ?>
            <div class="bg-red-500 text-white p-4 rounded mb-4"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="bg-green-500 text-white p-4 rounded mb-4"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-300 mb-1">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-2 rounded bg-gray-700 border text-white" required>
            </div>
            <div>
                <label for="email" class="block text-gray-300 mb-1">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 rounded bg-gray-700 border text-white" required>
            </div>
            <div>
                <label for="password" class="block text-gray-300 mb-1">Mot de passe</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded bg-gray-700 border text-white" required>
            </div>
            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 py-2 rounded">S'inscrire</button>
        </form>

        <p class="mt-4 text-center text-gray-400">Déjà un compte ? 
            <a href="signin.php" class="text-purple-500">Se connecter</a>
        </p>
    </div>
</body>
</html>
