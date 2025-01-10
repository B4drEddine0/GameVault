<?php
session_start();
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../classes/Game.php';
require_once __DIR__ . '/../classes/User.php';

$user = new User();
$banned = $user->getBannedUsers();

include __DIR__ . '/components/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
<body class="bg-gray-900 text-white">
    <div class="fixed inset-y-0 left-0 w-64 bg-[#1e1b4b]/80 backdrop-blur-sm">
        <div class="flex items-center justify-center h-20 bg-[#1e1b4b]">
            <h1 class="text-2xl font-bold">Game<span class="gradient-text">Vault</span> Admin</h1>
        </div>
        <nav class="mt-5">
            <a class="dashBtn flex items-center px-6 py-3 text-zinc-300 hover:bg-indigo-600/20 cursor-pointer">
                <i class="fas fa-home mr-3"></i>
                Dashboard
            </a>
            <a class="jeuBtn flex items-center px-6 py-3 text-zinc-300 hover:bg-indigo-600/20 cursor-pointer">
                <i class="fas fa-gamepad mr-3"></i>
                Gestion des Jeux
            </a>
            <a class="userBtn flex items-center px-6 py-3 text-zinc-300 hover:bg-indigo-600/20 cursor-pointer">
                <i class="fas fa-users mr-3"></i>
                Utilisateurs
            </a>
            <a class="banBtn flex items-center px-6 py-3 text-zinc-300 hover:bg-indigo-600/20 cursor-pointer">
                <i class="fas fa-ban mr-3"></i>
                Bannissements
            </a>
            <a href='index.php' class="flex items-center px-6 mt-96 text-zinc-300 hover:text-green-500 cursor-pointer">
            <i class="fas fa-tachometer-alt mr-3"></i>
                 Interface
            </a>
            <a onclick="window.location.href='logout.php';" class="flex items-center px-6 py-3 text-zinc-300 hover:text-red-500 cursor-pointer">
                <i class="fas fa-sign-out-alt mr-3"></i>
                 LogOut
            </a>
        </nav>
    </div>

    <div class="ml-64 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Tableau de bord</h2>
            <div class="flex items-center">
                <span class="mr-4"><?php echo htmlspecialchars($_SESSION['username'])?></span>
                <img src="<?php $user = new User(); $profile = $user->getProfile($_SESSION['user_id']); echo $profile['image'];?>" class="rounded-full w-10 h-10">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#1e1b4b]/30 p-6 rounded-lg backdrop-blur-sm border border-indigo-500/10">
                <div class="flex items-center">
                    <i class="fas fa-gamepad text-purple-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Total Jeux</h3>
                        <p class="text-2xl font-bold">
                            <?php 
                            $game = new Game();
                            $games = $game->getAllGames();
                            echo count($games);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-[#1e1b4b]/30 p-6 rounded-lg backdrop-blur-sm border border-indigo-500/10">
                <div class="flex items-center">
                    <i class="fas fa-users text-blue-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Utilisateurs</h3>
                        <p class="text-2xl font-bold">
                            <?php 
                                $users = $user->getActiveUsers();
                                $userscount = $user->getAllUsers();
                                echo count($userscount);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-[#1e1b4b]/30 p-6 rounded-lg backdrop-blur-sm border border-indigo-500/10">
                <div class="flex items-center">
                    <i class="fas fa-comments text-green-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Messages</h3>
                        <p class="text-2xl font-bold">9,012</p>
                    </div>
                </div>
            </div>
            <div class="bg-[#1e1b4b]/30 p-6 rounded-lg backdrop-blur-sm border border-indigo-500/10">
                <div class="flex items-center">
                    <i class="fas fa-ban text-red-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Bannissements</h3>
                        <p class="text-2xl font-bold"><?php echo count($banned);?> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[#1e1b4b]/30 rounded-lg p-6 mb-8 border border-indigo-500/10 hidden" id='jeuSection'>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold">Gestion des Jeux</h3>
                <button onclick="openAddGameModal()" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Ajouter un Jeu
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#1e1b4b]/50">
                        <tr>
                            <th class="p-4">Titre</th>
                            <th class="p-4">Type</th>
                            <th class="p-4">Note</th>
                            <th class="p-4">Date de sortie</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($games as $gameItem): ?>
                            <tr class="border-b border-gray-700">
                                <td class="p-4"><?= htmlspecialchars($gameItem['title']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($gameItem['type']) ?></td>
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <span class="text-yellow-500 mr-1">★</span>
                                        <?= number_format($game->avgRate($gameItem['jeu_id']), 1) ?>
                                    </div>
                                </td>
                                <td class="p-4"><?= $gameItem['date_sortie'] ?></td>
                                <td class="p-4">
                                        <button onclick="window.location.href='modify_game.php?id=<?=$gameItem['jeu_id']?>'" 
                                                class="text-blue-500 hover:text-blue-400 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    <form action="gameProcess.php" method='GET' class='inline'>
                                        <button name='deletedId' value='<?= $gameItem['jeu_id'] ?>' onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce jeu ?')" 
                                                class="text-red-500 hover:text-red-400">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                        
                                   
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="bg-[#1e1b4b]/30 rounded-lg p-6 mb-8 border border-indigo-500/10 hidden" id='userSection'>
            <h3 class="text-xl font-bold mb-6">Gestion des Utilisateurs</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#1e1b4b]/50">
                        <tr>
                            <th class="p-4">Utilisateur</th>
                            <th class="p-4">Rôle</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($users as $userItem): ?>
                        <tr class="border-b border-gray-700">
                            <td class="p-4 flex items-center">
                                <img src="<?php echo htmlspecialchars($userItem['image'])?>" class="rounded-full mr-3 w-10 h-10">
                                <?php echo htmlspecialchars($userItem['username'])?>
                            </td>
                            <td class="p-4"><?php echo htmlspecialchars($userItem['role_user'])?></td>
                            <td class="p-4"><?php echo htmlspecialchars($userItem['statut'])?></td>
                            <td class="p-4">
                                <button onclick="window.location.href='modify_user.php?id=<?=$userItem['users_id']?>'"  
                                  class="text-blue-500 hover:text-blue-400 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="gameProcess.php" method='GET' class='inline'>
                                    <button class="text-red-500 hover:text-red-400"  name='banne' value='<?=$userItem['users_id']?>'> 
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                
                            </td>
                            <?php endforeach;?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="bg-[#1e1b4b]/30 rounded-lg p-6 border border-indigo-500/10 hidden" id='banSection'>
            <h3 class="text-xl font-bold mb-6">Gestion des Bannissements</h3>
            <div class="space-y-4">
            <table class="w-full text-left">
                    <thead class="bg-[#1e1b4b]/50">
                        <tr>
                            <th class="p-4">Utilisateur</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($banned as $bannedItem): ?>
                        <tr class="border-b border-gray-700">
                            <td class="p-4 flex items-center">
                                <img src="<?php echo htmlspecialchars($bannedItem['image'])?>" class="rounded-full mr-3 w-10 h-10">
                                <?php echo htmlspecialchars($bannedItem['username'])?>
                            </td>
                            <td class="p-4"><?php echo htmlspecialchars($bannedItem['statut'])?></td>
                            <td class="p-4">
                                <form action="gameProcess.php" method='GET' class='inline'>
                                    <button class="text-red-500 hover:text-red-400"  name='banne' value='<?=$bannedItem['users_id']?>'> 
                                        <i class="fas fa-undo ml-4"></i>
                                    </button>
                                </form>
                                
                            </td>
                            <?php endforeach;?>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>


    <div id="addGameModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-[#1e1b4b]/80 backdrop-blur-sm p-8 rounded-lg border border-indigo-500/10 w-full max-w-md">
            <h3 id="editTitle" class="text-xl font-bold mb-4">Ajouter un Jeu</h3>
            <form id="addGameForm" action='gameProcess.php' method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-300 mb-2">Titre</label>
                    <input type="text" name="title" value='' required 
                           class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Description</label>
                    <textarea name="description" required 
                              class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600"></textarea>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-1/2 px-2 mb-4">
                        <label class="block text-gray-300 mb-2">ImagePrincipal(url)</label>
                        <input type="text" name="image" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600" required>
                    </div>
                    <div class="w-1/2 px-2 mb-4">
                        <label class="block text-gray-300 mb-2">Image2(url)</label>
                        <input type="text" name="image2" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                    </div>
                    <div class="w-1/2 px-2 mb-4">
                        <label class="block text-gray-300 mb-2">Image3(url)</label>
                        <input type="text" name="image3" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                    </div>
                    <div class="w-1/2 px-2 mb-4">
                        <label class="block text-gray-300 mb-2">Image4(url)</label>
                        <input type="text" name="image4" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-300 mb-2">Type</label>
                           <select name="type" value="Select-Type" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                            <option value="Action">Action</option>
                            <option value="Aventure">Aventure</option>
                            <option value="Football">Football</option>
                            <option value="Battlefield">Battlefield</option>
                            <option value="Racing">Racing</option>
                            <option value="RPG">RPG</option>
                            <option value="Strategy">Strategy</option>
                            <option value="Puzzle">Puzzle</option>
                            <option value="Simulation">Simulation</option>
                            <option value="Sports">Sports</option>
                            <option value="Horror">Horror</option>
                            <option value="Fighting">Fighting</option>
                           </select>
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Date de sortie</label>
                    <input type="date" name="date_sortie" required 
                           class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeAddGameModal()" 
                            class="px-4 py-2 border border-gray-600 rounded-lg hover:bg-gray-700">
                        Annuler
                    </button>
                    <button type="submit" name='ajoute'  id="addBtn"
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
    function openAddGameModal() {
        document.getElementById('addGameModal').classList.remove('hidden');
    }

    function closeAddGameModal() {
        document.getElementById('addGameModal').classList.add('hidden');
    }

    document.querySelector('.dashBtn').onclick = function() {
        document.getElementById('userSection').classList.add('hidden');
        document.getElementById('jeuSection').classList.add('hidden');
        document.getElementById('banSection').classList.add('hidden');
    }

    document.querySelector('.userBtn').onclick = function() {
        document.getElementById('userSection').classList.remove('hidden');
        document.getElementById('jeuSection').classList.add('hidden');
        document.getElementById('banSection').classList.add('hidden');
    }
    
    document.querySelector('.jeuBtn').onclick = function() {
        document.getElementById('userSection').classList.add('hidden');
        document.getElementById('jeuSection').classList.remove('hidden');
        document.getElementById('banSection').classList.add('hidden');
    }

    document.querySelector('.banBtn').onclick = function() {
        document.getElementById('userSection').classList.add('hidden');
        document.getElementById('jeuSection').classList.add('hidden');
        document.getElementById('banSection').classList.remove('hidden');
    }


    </script>
</body>
</html>

include __DIR__ . '/components/footer.php';