<?php
require_once 'connextion.php';
$database = new DbConnection();
$pdo = $database->getConnection();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-gray-800">
        <div class="flex items-center justify-center h-20 bg-gray-700">
            <h1 class="text-2xl font-bold">GameVault Admin</h1>
        </div>
        <nav class="mt-5">
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-home mr-3"></i>
                Dashboard
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-gamepad mr-3"></i>
                Gestion des Jeux
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-users mr-3"></i>
                Utilisateurs
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-comments mr-3"></i>
                Chat
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-ban mr-3"></i>
                Bannissements
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Tableau de bord</h2>
            <div class="flex items-center">
                <span class="mr-4">Admin</span>
                <img src="https://via.placeholder.com/40" class="rounded-full">
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-gamepad text-purple-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Total Jeux</h3>
                        <p class="text-2xl font-bold">
                            <?php 
                            require_once 'GameClass.php';
                            $game = new Game($pdo);
                            $games = $game->getAllGames();
                            echo count($games);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-users text-blue-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Utilisateurs</h3>
                        <p class="text-2xl font-bold">5,678</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-comments text-green-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Messages</h3>
                        <p class="text-2xl font-bold">9,012</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-ban text-red-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Bannissements</h3>
                        <p class="text-2xl font-bold">123</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Game Management Section -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold">Gestion des Jeux</h3>
                <button onclick="openAddGameModal()" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Ajouter un Jeu
                </button>
            </div>

            <!-- Games Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-4">Titre</th>
                            <th class="p-4">Type</th>
                            <th class="p-4">Note</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Temps de jeu</th>
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
                                        <?= number_format($gameItem['rating'], 1) ?>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        <?= $gameItem['status'] === 'Disponible' ? 'bg-green-500' : 'bg-red-500' ?>">
                                        <?= htmlspecialchars($gameItem['status']) ?>
                                    </span>
                                </td>
                                <td class="p-4"><?= $gameItem['temps_jeu'] ?> heures</td>
                                <td class="p-4"><?= $gameItem['date_sortie'] ?></td>
                                <td class="p-4">
                                    <button onclick="openEditGameModal(<?= $gameItem['jeu_id'] ?>)" 
                                            class="text-blue-500 hover:text-blue-400 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteGame(<?= $gameItem['jeu_id'] ?>)" 
                                            class="text-red-500 hover:text-red-400">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Management Section -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <h3 class="text-xl font-bold mb-6">Gestion des Utilisateurs</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-4">Utilisateur</th>
                            <th class="p-4">Rôle</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemple d'utilisateur -->
                        <tr class="border-b border-gray-700">
                            <td class="p-4 flex items-center">
                                <img src="https://via.placeholder.com/32" class="rounded-full mr-3">
                                John Doe
                            </td>
                            <td class="p-4">Utilisateur</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-xs bg-green-500">Actif</span>
                            </td>
                            <td class="p-4">
                                <button class="text-blue-500 hover:text-blue-400 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-400">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chat Moderation Section -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h3 class="text-xl font-bold mb-6">Modération du Chat</h3>
            <div class="space-y-4">
                <!-- Exemple de message -->
                <div class="flex items-start space-x-4">
                    <img src="https://via.placeholder.com/40" class="rounded-full">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold">John Doe</h4>
                            <span class="text-sm text-gray-400">Il y a 5 minutes</span>
                        </div>
                        <p class="text-gray-300">Message exemple du chat...</p>
                        <div class="mt-2">
                            <button class="text-red-500 hover:text-red-400 mr-3">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                            <button class="text-yellow-500 hover:text-yellow-400">
                                <i class="fas fa-flag"></i> Signaler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Game Modal -->
    <div id="addGameModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Ajouter un Jeu</h3>
            <form id="addGameForm" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-300 mb-2">Titre</label>
                    <input type="text" name="title" required 
                           class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Description</label>
                    <textarea name="description" required 
                              class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600"></textarea>
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Type</label>
                    <input type="text" name="type" required 
                           class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Status</label>
                    <select name="status" required 
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                        <option value="Disponible">Disponible</option>
                        <option value="Non disponible">Non disponible</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Temps de jeu (heures)</label>
                    <input type="number" name="temps_jeu" required 
                           class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
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
                    <button type="submit" 
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

    function openEditGameModal(gameId) {
        // Implement edit modal logic
        console.log('Edit game:', gameId);
    }

    function deleteGame(gameId) {
        if(confirm('Êtes-vous sûr de vouloir supprimer ce jeu ?')) {
            fetch(`delete_game.php?id=${gameId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de la suppression');
                }
            });
        }
    }

    document.getElementById('addGameForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('add_game.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                closeAddGameModal();
                location.reload();
            } else {
                alert('Erreur lors de l\'ajout du jeu');
            }
        });
    });
    </script>
</body>
</html>