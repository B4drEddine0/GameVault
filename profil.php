<?php
session_start();
include('connexion.php'); 

$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection(); 
if (!isset($_SESSION['username'])) {
    header('Location: signin.php');
    exit;
}

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $new_image = $_POST['image'];


    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
    }

    $update_query = "UPDATE users SET username = ?, email = ? , image = ? WHERE username = ?";
    if (!empty($new_password)) {
        $update_query = "UPDATE users SET username = ?, email = ?, user_password = ?, image = ? WHERE username = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->execute([$new_username, $new_email, $new_password, $new_image, $username]);
    } else {
        $stmt = $conn->prepare($update_query);
        $stmt->execute([$new_username, $new_email, $new_image, $username]);
    }

 
    $_SESSION['username'] = $new_username;

    header('Location: profil.php');
    exit;
}

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
    <style>
        body {
            background: linear-gradient(to bottom, #1e1b4b, #111827);
            min-height: 100vh;
        }

        .game-card {
            transition: transform 0.3s ease;
        }

        .game-card:hover {
            transform: translateY(-10px);
        }

        .gradient-text {
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .game-card img {
            backface-visibility: hidden;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(2deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes glow {
            0% {
                filter: drop-shadow(0 0 2px rgba(99, 102, 241, 0.2));
            }

            50% {
                filter: drop-shadow(0 0 8px rgba(99, 102, 241, 0.4));
            }

            100% {
                filter: drop-shadow(0 0 2px rgba(99, 102, 241, 0.2));
            }
        }

        svg.float-animation {
            filter: drop-shadow(0 0 4px rgba(99, 102, 241, 0.3));
            animation: float 4s ease-in-out infinite, glow 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-[#0F172A] text-gray-100">
    <nav class="bg-zinc-900/30 fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                <h1 class="text-2xl font-bold">Game<span class="gradient-text">Vault</span></h1>

                    <div class="ml-10 flex items-center space-x-4">
                        <a href="index.php" class="text-gray-300 hover:text-white px-3 py-2">Accueil</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Jeux</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-16 bg-[#1e1b4b]/100  min-h-screen">
        <div class="max-w-4xl bg-[#1e1b4b]/50  mx-auto px-4 py-8">
            <div class="bg-zinc-900/30 rounded-lg p-6 mb-6">
                <div class="flex items-start space-x-6">
                    <div class="relative">
                        <img src="<?php echo htmlspecialchars($user['image']) ; ?>" alt="Profile" class="w-32 h-32 rounded-full">
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

            <div class="bg-zinc-900/30 rounded-lg p-6">
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
                    <div>
                        <label class="block text-gray-300 mb-2">nouvel image (laisser vide si vous ne voulez pas changer)</label>
                        <input type="text" name="image" value="<?php echo htmlspecialchars($user['image']); ?>" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">

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
