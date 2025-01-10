<!DOCTYPE html>
<html lang="en">
<body>
<nav class="fixed w-full z-10 bg-zinc-900/30 backdrop-blur-sm border-b border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                   <a href="/Briefs/Brief-10/GameVault/index.php"><h1 class="text-2xl font-bold">Game<span class="gradient-text">Vault</span></h1></a>
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="/Briefs/Brief-10/GameVault/index.php" class="text-gray-300 hover:text-white px-3 py-2">Accueil</a>
                        <div class="flex space-x-4">
                            <?php if (isset($_SESSION['username'])): ?>
                                <a href="/Briefs/Brief-10/GameVault/views/bibliotheque.php" class="text-gray-300 hover:text-white px-3 py-2">Ma Collection</a>
                                <a href="/Briefs/Brief-10/GameVault/views/historique.php" class="text-gray-300 hover:text-white px-3 py-2">Mon Historique</a>
                                <a href="/Briefs/Brief-10/GameVault/views/favoris.php" class="text-gray-300 hover:text-white px-3 py-2">Mes Favoris</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <?php if (isset($_SESSION['username'])): ?>
                        <div class="flex items-center space-x-4">
                            <img src="<?php echo htmlspecialchars($_SESSION['image'] ?? 'images/profil.webp'); ?>"
                                alt=""
                                class="w-10 h-10 rounded-full cursor-pointer"
                                onclick="window.location.href='/Briefs/Brief-10/GameVault/views/user/profil.php';">
                            <span class="text-white"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <button
                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg"
                                onclick="window.location.href='/Briefs/Brief-10/GameVault/processes/logout.php';">
                                Déconnexion
                            </button>
                        </div>
                    <?php else: ?>
                        <button
                            class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg mr-4"
                            onclick="window.location.href='/Briefs/Brief-10/GameVault/views/user/signin.php';">
                            Connexion
                        </button>
                        <button
                            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg"
                            onclick="window.location.href='/Briefs/Brief-10/GameVault/views/user/signup.php';">
                            Inscription
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

</body>
</html>