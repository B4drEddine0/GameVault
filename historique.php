<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Historique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    <!-- Navigation -->
    <nav class="fixed w-full z-10 bg-zinc-900/30 backdrop-blur-sm border-b border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold">Game<span class="gradient-text">Vault</span></h1>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Votre <span class="gradient-text">Historique</span></h2>
                <button class="text-zinc-400 hover:text-white transition-colors">
                    <i class="fas fa-trash-alt"></i> Effacer l'historique
                </button>
            </div>

            <!-- Timeline -->
            <div class="space-y-6">
                <!-- Date Section -->
                <div class="border-l-2 border-indigo-500/30 pl-6 ml-3">
                    <h3 class="text-lg font-semibold mb-4 text-zinc-400">Aujourd'hui</h3>
                    
                    <!-- Game Cards Container -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Game Card -->
                        <div class="bg-[#1e1b4b]/30 rounded-lg backdrop-blur-sm border border-zinc-700/30 overflow-hidden group">
                            <div class="relative">
                                <img src="path_to_image.jpg" alt="Game" class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-indigo-600/90 px-2 py-1 rounded text-sm">
                                        <i class="fas fa-clock mr-1"></i> 14:30
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold mb-1">Nom du Jeu</h4>
                                <p class="text-zinc-400 text-sm mb-3">Type de jeu</p>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                        <span class="text-zinc-400">4.5</span>
                                    </div>
                                    <button class="text-indigo-400 hover:text-indigo-300 transition-colors">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Yesterday Section -->
                <div class="border-l-2 border-indigo-500/30 pl-6 ml-3">
                    <h3 class="text-lg font-semibold mb-4 text-zinc-400">Hier</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Similar Game Cards -->
                    </div>
                </div>

                <!-- Cette Semaine Section -->
                <div class="border-l-2 border-indigo-500/30 pl-6 ml-3">
                    <h3 class="text-lg font-semibold mb-4 text-zinc-400">Cette Semaine</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Similar Game Cards -->
                    </div>
                </div>
            </div>

            <!-- Empty State (when no history) -->
            <div class="hidden text-center py-20">
                <div class="bg-[#1e1b4b]/30 rounded-lg backdrop-blur-sm border border-zinc-700/30 p-8 max-w-md mx-auto">
                    <i class="fas fa-history text-4xl text-indigo-400 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Aucun historique</h3>
                    <p class="text-zinc-400">Commencez à explorer des jeux pour voir votre historique apparaître ici.</p>
                    <a href="index.php" class="inline-block mt-4 px-6 py-2 bg-indigo-600/90 hover:bg-indigo-500 rounded-lg transition-colors glow-effect">
                        Découvrir des jeux
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
