<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Support</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #1e1b4b, #111827);
            min-height: 100vh;
        }

        .gradient-text {
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .support-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .support-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.2);
        }
    </style>
</head>

<body class="text-zinc-100">
    <?php include 'header.php' ?>

    <div class="pt-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold mb-4">Centre de <span class="gradient-text">Support</span></h1>
                <p class="text-zinc-400 max-w-2xl mx-auto">
                    Besoin d'aide ? Notre équipe est là pour vous accompagner. Retrouvez ci-dessous nos différents canaux de support.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                <div class="support-card bg-[#1e1b4b]/30 rounded-lg p-6 backdrop-blur-sm border border-zinc-700/30">
                    <div class="text-indigo-500 mb-4 text-3xl">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Support Email</h3>
                    <p class="text-zinc-400 mb-4">Notre équipe répond sous 24-48h ouvrées</p>
                    <a href="mailto:support@gamevault.com" class="text-indigo-400 hover:text-indigo-300">
                        support@gamevault.com
                    </a>
                </div>

                <div class="support-card bg-[#1e1b4b]/30 rounded-lg p-6 backdrop-blur-sm border border-zinc-700/30">
                    <div class="text-indigo-500 mb-4 text-3xl">
                        <i class="fab fa-discord"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Discord</h3>
                    <p class="text-zinc-400 mb-4">Rejoignez notre communauté Discord</p>
                    <a href="#" class="text-indigo-400 hover:text-indigo-300">
                        discord.gg/gamevault
                    </a>
                </div>

                <div class="support-card bg-[#1e1b4b]/30 rounded-lg p-6 backdrop-blur-sm border border-zinc-700/30">
                    <div class="text-indigo-500 mb-4 text-3xl">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Réseaux Sociaux</h3>
                    <p class="text-zinc-400 mb-4">Suivez-nous pour les dernières actualités</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-indigo-400 hover:text-indigo-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-indigo-400 hover:text-indigo-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-indigo-400 hover:text-indigo-300">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-8 text-center">Questions Fréquentes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <div class="bg-[#1e1b4b]/30 rounded-lg p-6 backdrop-blur-sm border border-zinc-700/30">
                        <h3 class="font-bold mb-2">Comment ajouter un jeu à ma bibliothèque ?</h3>
                        <p class="text-zinc-400">Naviguez vers la page du jeu et cliquez sur le bouton "Ajouter à ma bibliothèque".</p>
                    </div>
                    <div class="bg-[#1e1b4b]/30 rounded-lg p-6 backdrop-blur-sm border border-zinc-700/30">
                        <h3 class="font-bold mb-2">Comment modifier mon profil ?</h3>
                        <p class="text-zinc-400">Accédez à votre profil en cliquant sur votre avatar, puis sur "Modifier le profil".</p>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center">
                <h2 class="text-2xl font-bold mb-4">Heures de Support</h2>
                <p class="text-zinc-400">
                    Lundi - Vendredi: 9h00 - 18h00<br>
                    Week-end: Support limité via Discord
                </p>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>
</body>

</html> 