<?php
session_start();
include('connexion.php'); // Inclure votre classe de connexion à la base de données

$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection(); // Maintenant, $conn contiendra la connexion à la base de données

if (!isset($_SESSION['username'])) {
    header('Location: signin.php');
    exit;
}

$username = $_SESSION['username'];

// Récupérer les informations de l'utilisateur au début pour l'affichage initial
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

// Vérifier si l'utilisateur existe dans la base de données
if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}

// Si le formulaire est soumis, mettre à jour les informations de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    // Si un mot de passe est fourni, le hacher avant de le mettre à jour
    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
    }

    // Mettre à jour la base de données
    $update_query = "UPDATE users SET username = ?, email = ? WHERE username = ?";
    // Si un mot de passe est fourni, l'inclure dans la requête de mise à jour
    if (!empty($new_password)) {
        $update_query = "UPDATE users SET username = ?, email = ?, user_password = ? WHERE username = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->execute([$new_username, $new_email, $new_password, $username]);
    } else {
        $stmt = $conn->prepare($update_query);
        $stmt->execute([$new_username, $new_email, $username]);
    }

    // DEBUGGING: Output POST data to check if form data is correct
    // You can remove this once you've confirmed it works.
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    // Refresh session data to reflect updated username
    $_SESSION['username'] = $new_username;

    // Rediriger après la mise à jour pour recharger les données mises à jour
    header('Location: profil.php');
    exit;
}

// Rafraîchir les informations de l'utilisateur après la mise à jour
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="bg-gray-800 fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold">GameVault</h1>
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="index.php" class="text-gray-300 hover:text-white px-3 py-2">Accueil</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Jeux</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-16 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Profile Header -->
            <div class="bg-gray-800 rounded-lg p-6 mb-6">
                <div class="flex items-start space-x-6">
                    <div class="relative">
                        <img src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'images/profil.webp'); ?>" alt="Profile" class="w-32 h-32 rounded-full">
                        <button class="absolute bottom-0 right-0 bg-purple-600 p-2 rounded-full hover:bg-purple-700">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($user['username']); ?></h2>
                                <p class="text-gray-400">@<?php echo htmlspecialchars($user['username']); ?></p>
                            </div>
                            <button class="bg-purple-600 px-4 py-2 rounded-lg hover:bg-purple-700">
                                Éditer le profil
                            </button>
                        </div>
                        <p class="mt-4 text-gray-300">Rôle: <?php echo htmlspecialchars($user['role_user']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Profile Information Form -->
            <div class="bg-gray-800 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Mettre à jour les informations</h3>
                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-gray-300 mb-2">Nom d'utilisateur</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2">Mot de passe (laisser vide si vous ne voulez pas changer)</label>
                        <input type="password" name="password" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                    </div>
                    <button type="submit" class="w-full bg-purple-600 px-4 py-2 rounded-lg hover:bg-purple-700">
                        Mettre à jour les informations
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
