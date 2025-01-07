<?php
session_start();
require_once 'classUser.php';

$user = new user();
if(isset($_GET['id'])) {
    $user->setId($_GET['id']);
    $userInfo = $user->getSelectedUser();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Modifier un Utilisateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="bg-[#1e1b4b]/30 backdrop-blur-sm p-8 rounded-lg border border-indigo-500/10 w-full max-w-2xl">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Modifier <span class="gradient-text">Utilisateur</span></h1>
                <a href="dashboard.php" class="text-zinc-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </a>
            </div>

            <form action="gameProcess.php" method="POST" class="space-y-6">
                <input type="hidden" name="users_id" value="<?= htmlspecialchars($userInfo['users_id']) ?>">
                
                <div>
                    <label class="block text-zinc-300 mb-2">username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($userInfo['username']) ?>" required 
                           class="w-full px-4 py-3 rounded-lg bg-[#1e1b4b]/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all">
                </div>

                <div>
                    <label class="block text-zinc-300 mb-2">Image (URL)</label>
                    <input type="text" name="image" value="<?= htmlspecialchars($userInfo['image']) ?>" required 
                           class="w-full px-4 py-3 rounded-lg bg-[#1e1b4b]/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all">
                </div>

                <div>
                    <label class="block text-zinc-300 mb-2">Role</label> 
                           <select name="role_user" value="<?= htmlspecialchars($userInfo['role_user']) ?>" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                            <option value="Admin">Admin</option>
                            <option value="joueur">joueur</option>
                           </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="dashboard.php" 
                       class="px-6 py-3 border border-zinc-700/50 rounded-lg hover:bg-zinc-700/30 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" name="updateUser" 
                            class="px-6 py-3 bg-indigo-600/90 hover:bg-indigo-500 rounded-lg transition-colors glow-effect">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 