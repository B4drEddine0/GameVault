<?php
session_start();
require_once 'GameClass.php';
require_once 'ChatClass.php';
require_once 'UserClass.php';


$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();


if(isset($_GET['id'])) {
    $game = new Game();
    $game->setJeu_id($_GET['id']);
    $game->addView();
    $gameDetails = $game->getSelectedGame();
    $notations = $game->getNotation($_GET['id']);
    if(isset($_GET['mode'])) {
        $_SESSION['added'] = true;
    }else{
        $_SESSION['added'] = false;
    }

    if(isset($_GET['statut'])) {
        echo "
            <div class='fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm'>
                <div class='max-w-md w-full mx-4 bg-[#1e1b4b]/95 rounded-lg border border-red-500/50 shadow-2xl shadow-red-500/20'>
                    <div class='p-6'>
                        <!-- Header -->
                        <div class='flex items-center space-x-4 mb-6'>
                            <div class='w-12 h-12 rounded-full bg-red-500/10 flex items-center justify-center'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-red-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/>
                                </svg>
                            </div>
                            <div>
                                <h3 class='text-xl font-bold text-white'>Accès Restreint</h3>
                                <p class='text-red-400'>Compte suspendu</p>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class='mb-6 text-zinc-300 leading-relaxed'>
                            Votre compte a été temporairement suspendu. Vous ne pouvez pas effectuer cette action pour le moment.
                        </div>

                        <!-- Actions -->
                        <div class='flex flex-col space-y-3'>
                            <a href='support.php' class='w-full px-4 py-3 bg-red-500/10 hover:bg-red-500/20 border border-red-500/50 rounded-lg text-red-400 text-center transition-colors'>
                                Contacter le Support
                            </a>
                            <a href='index.php' class='w-full px-4 py-3 bg-zinc-800/50 hover:bg-zinc-700/50 rounded-lg text-zinc-400 text-center transition-colors'>
                                Retour à l'Accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }
} else {
    header('Location: index.php');
    exit();
}
    $jeu_id = $_GET['id'];

    $_SESSION['game_id'] = $jeu_id;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($gameDetails['title']) ?> - GameVault</title>
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
    <?php include 'header.php'?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'already_in_collection'): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="max-w-md w-full mx-4 bg-[#1e1b4b]/95 rounded-lg border border-red-500/50 shadow-2xl shadow-red-500/20">
            <div class="p-6">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-red-500/10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Attention</h3>
                        <p class="text-red-400">Jeu déjà présent</p>
                    </div>
                </div>
                <div class="mb-6 text-zinc-300 leading-relaxed">
                    Ce jeu est déjà présent dans votre bibliothèque.
                </div>
                <div class="flex flex-col space-y-3">
                    <a href="bibliotheque.php" class="w-full px-4 py-3 bg-red-500/10 hover:bg-red-500/20 border border-red-500/50 rounded-lg text-red-400 text-center transition-colors">
                        Voir ma bibliothèque
                    </a>
                    <a href="game_details.php?id=<?= $_GET['id'] ?>" class="w-full px-4 py-3 bg-zinc-800/50 hover:bg-zinc-700/50 rounded-lg text-zinc-400 text-center transition-colors">
                        Fermer
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    <div class="pt-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-2 gap-12">
                <div class="relative group">
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-zinc-800/30 backdrop-blur-sm border border-zinc-700/30">
                        <img src="<?= !empty($gameDetails['image']) ? htmlspecialchars($gameDetails['image']) : 'images/default-game.jpg' ?>" 
                             alt="<?= htmlspecialchars($gameDetails['title']) ?>"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex mt-4 space-x-2">
                        <div class="w-1/3 rounded-lg overflow-hidden">
                            <img src="<?= !empty($gameDetails['image2']) ? htmlspecialchars($gameDetails['image2']) : 'images/default-game.jpg' ?>" 
                                alt="Image 2" 
                                class="w-full h-32 object-cover">
                        </div>
                        <div class="w-1/3 rounded-lg overflow-hidden">
                            <img src="<?= !empty($gameDetails['image3']) ? htmlspecialchars($gameDetails['image3']) : 'images/default-game.jpg' ?>" 
                                alt="Image 3" 
                                class="w-full h-32 object-cover">
                        </div>
                        <div class="w-1/3 rounded-lg overflow-hidden">
                            <img src="<?= !empty($gameDetails['image4']) ? htmlspecialchars($gameDetails['image4']) : 'images/default-game.jpg' ?>" 
                                alt="Image 4" 
                                class="w-full h-32 object-cover">
                        </div>
                    </div>
                </div>


                <div class="space-y-6 bg-zinc-800/30 backdrop-blur-sm p-6 rounded-lg border border-zinc-700/30">
                    <h1 class="text-4xl font-bold">
                        <?= htmlspecialchars($gameDetails['title']) ?>
                    </h1>

                    <div class="flex items-center space-x-2">
                        <div class="flex items-center">
                            <?php for($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star <?= $i < $game->avgRate($_GET['id']) ? 'text-amber-400' : 'text-zinc-600' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-zinc-400">(<?= number_format($game->avgRate($_GET['id']), 1) ?>)</span>
                    </div>

                    <div class="flex space-x-4 text-zinc-400">
                        <div class="flex items-center">
                            <i class="fas fa-gamepad mr-2"></i>
                            <?= htmlspecialchars($gameDetails['type']) ?>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <?= htmlspecialchars($gameDetails['date_sortie']) ?>
                        </div>
                    </div>

                    <div class="prose prose-invert">
                        <h2 class="text-xl font-bold mb-2">Description</h2>
                        <p class="text-zinc-400 leading-relaxed">
                            <?= nl2br(htmlspecialchars($gameDetails['description'])) ?>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <div class="bg-[#1e1b4b]/50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold gradient-text mb-1">
                                <i class="fas fa-comment mr-1"></i>
                                <?= $game->getCommentCount()?>
                            </div>
                            <p class="text-zinc-400 text-sm">Reviews total</p>
                        </div>

                        <div class="bg-[#1e1b4b]/50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold gradient-text mb-1">
                                <i class="fas fa-bookmark mr-1"></i>
                                <?= $game->getCollectionCount()?>  
                            </div>
                            <p class="text-zinc-400 text-sm">Enregistrer collections</p>
                        </div>

                        <div class="bg-[#1e1b4b]/50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold gradient-text mb-1">
                                <i class="fas fa-eye mr-1"></i>
                                <?= $game->getViewCount()?>
                            </div>
                            <p class="text-zinc-400 text-sm">Vues totales</p>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <form action="collectionProcess.php" method="POST">
                            <button type="button" id="addToCollectionBtn" class="px-6 py-3 bg-indigo-600/90 hover:bg-indigo-500 rounded-lg transition-colors glow-effect">
                                <i class="fas fa-bookmark mr-2"></i>
                                Ajouter à ma collection
                            </button>
                            <div id="addToCollectionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-md">
                                    <h2 class="text-xl font-bold text-white mb-4">Ajouter à ma collection</h2>
                                    <form method="POST">
                                        <div class="mb-4">
                                            <label for="playtime" class="block text-gray-300 mb-2">Temps de jeu (en heures)</label>
                                            <input type="time" name="playtime" id="playtime" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="status" class="block text-gray-300 mb-2">Statut du jeu</label>
                                            <select name="status" id="status" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600" required>
                                                <option value="En cours">En cours</option>
                                                <option value="Terminé">Terminé</option>
                                                <option value="Abandonné">Abandonné</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-end space-x-4">
                                            <button type="button" id="closeModalBtn" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 rounded-lg">
                                                Annuler
                                            </button>
                                            <button type="submit" name="confirmAddToCollection" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-lg">
                                                Ajouter
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </form>
                        <button class="px-6 py-3 bg-zinc-800/50 hover:bg-zinc-700/50 rounded-lg transition-colors">
                            <i class="fas fa-share mr-2"></i>
                            Partager
                        </button>
                    </div>
                </div>
            </div>


              <div class="mt-12">
                                <div class="flex justify-between items-center mb-8">
                                    <h2 class="text-2xl font-bold">Avis des <span class="gradient-text">Joueurs</span></h2>
                                    <button id='revBtn' class="px-4 py-2 bg-indigo-600/90 hover:bg-indigo-500 rounded-lg transition-colors glow-effect">
                                        Écrire un avis
                                    </button>
                                </div>

                                <div class="grid gap-6">
                                <?php foreach ($notations as $notation): ?>
                                    <div class="bg-[#1e1b4b]/30 backdrop-blur-sm rounded-lg border border-zinc-700/30 p-6">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-center">
                                                <img src="<?= $notation['image'] ?? 'default-avatar.jpg' ?>" alt="User Avatar" class="w-10 h-10 rounded-full mr-4">
                                                <div>
                                                    <h4 class="font-bold"><?= $notation['username'] ?? 'Utilisateur' ?></h4>
                                                    <div class="flex items-center">
                                                        <div class="flex text-amber-400">
                                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                                <i class="fas fa-star <?= $i <= ($notation['rating'] ?? 0) ? 'text-amber-400' : 'text-zinc-600' ?>"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                        <span class="text-zinc-400 text-sm ml-2"><?= $notation['create_at'] ?? '' ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-zinc-300"><?= $notation['content'] ?? '' ?></p>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="reviewModal" class="flex fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
                        <div class="bg-[#1e1b4b]/95 rounded-lg border border-zinc-700/30 p-6 w-full max-w-lg mx-4">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold">Écrire un avis</h3>
                                <button onclick="toggleReviewModal()" class="text-zinc-400 hover:text-white">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <form id="reviewForm" action='GameProcess.php' method='POST' class="space-y-6">
                                <input type="hidden" name="game_id" value="<?= $gameDetails['jeu_id'] ?>">
                                <div>
                                    <label class="block text-zinc-300 mb-2">Note</label>
                                    <div class="flex space-x-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                        <button type="button" 
                                                onclick="setRating(<?= $i ?>)" 
                                                class="text-2xl text-zinc-400 hover:text-amber-400 transition-colors rating-star"
                                                data-rating="<?= $i ?>">
                                            <i class="far fa-star"></i>
                                        </button>
                                        <?php endfor; ?>
                                    </div>
                                    <input type="hidden" name="rating" id="ratingInput" required>
                                </div>

                                <div>
                                    <label for="review" class="block text-zinc-300 mb-2">Votre avis</label>
                                    <textarea id="review" name="review" rows="4" required
                                            class="w-full px-4 py-3 rounded-lg bg-[#1e1b4b]/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all"
                                            placeholder="Partagez votre expérience..."></textarea>
                                </div>

                                <div class="flex justify-end space-x-4">
                                    <button type="button" onclick="toggleReviewModal()"
                                            class="px-4 py-2 border border-zinc-700/50 rounded-lg hover:bg-zinc-700/30 transition-colors">
                                        Annuler
                                    </button>
                                    <button type="submit" name='SubReview'
                                            class="px-4 py-2 bg-indigo-600/90 hover:bg-indigo-500 rounded-lg transition-colors glow-effect">
                                        Publier
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

        
                    <div class="fixed bottom-6 right-6 z-50">
                        <button onclick="toggleChat()" 
                                class="bg-indigo-600/90 hover:bg-indigo-500 w-14 h-14 rounded-full flex items-center justify-center glow-effect">
                            <i class="fas fa-comments text-xl"></i>
                        </button>

                        <div id="chatWindow" class="<?php echo (isset($_SESSION['added']) && $_SESSION['added'] === true) ? '' : 'hidden'; ?> absolute bottom-16 right-0 w-96 bg-[#1e1b4b]/95 backdrop-blur-sm rounded-lg border border-zinc-700/30 shadow-xl">
                            <div class="p-4 border-b border-zinc-700/30">
                                <h3 class="font-bold">Discussion du jeu</h3>
                            </div>
                            <div class="h-96 overflow-y-auto p-4 space-y-4 [&::-webkit-scrollbar]:w-2
                                    [&::-webkit-scrollbar-track]:rounded-full
                                    [&::-webkit-scrollbar-track]:bg-zinc-900/30
                                    [&::-webkit-scrollbar-thumb]:rounded-full
                                    [&::-webkit-scrollbar-thumb]:bg-zinc-900/30
                                    dark:[&::-webkit-scrollbar-track]:bg-zinc-900/30
                                    dark:[&::-webkit-scrollbar-thumb]:bg-zinc-900/30">
    
                                <?php $chat = new Chat(); $messages = $chat->getChat($jeu_id);
                                    foreach($messages as $msg) : 
                                ?>
                                <div class="flex items-start space-x-3">
                                    <img src="<?= htmlspecialchars($msg['image'])?>" alt="User" class="w-8 h-8 mt-4 rounded-full">
                                    <div class="bg-[#1e1b4b]/50 rounded-lg p-3">
                                        <p class="text-sm font-semibold"><?= htmlspecialchars($msg['username'])?></p>
                                        <p class="text-sm text-zinc-300"><?= htmlspecialchars($msg['content'])?> <span class="text-zinc-400 text-sm ml-2"><?php echo htmlspecialchars($msg['create_at']);?></span> </p>
                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <form method='POST' action='gameProcess.php'>
                            <div class="p-4 border-t border-zinc-700/30">
                                <div class="flex space-x-2">
                                    <input type="hidden" name='jeuId' value='<?=$jeu_id?>'>
                                    <input type="text" name ='message' placeholder="Votre message..." 
                                        class="flex-1 bg-[#1e1b4b]/50 border border-zinc-700/30 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                                    <button name='addMsg' class="bg-indigo-600/90 hover:bg-indigo-500 px-4 rounded-lg transition-colors">
                                        <i class="fas fa-paper-plane"></i> 
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                            </div>
                </div>
            </div>


            <?php include 'footer.php'?>
    <script>
        function toggleChat() {
            const chatWindow = document.getElementById('chatWindow');
            chatWindow.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const chatWindow = document.getElementById('chatWindow');
            const chatButton = event.target.closest('button');
            const chatContainer = event.target.closest('#chatWindow');
            
            if (!chatButton && !chatContainer && !chatWindow.classList.contains('hidden')) {
                chatWindow.classList.add('hidden');
            }
        });

        function toggleReviewModal() {
            const modal = document.getElementById('reviewModal');
            modal.classList.toggle('hidden');
            // modal.classList.toggle('flex');
        }

        function setRating(rating) {
            document.getElementById('ratingInput').value = rating;
            const stars = document.querySelectorAll('.rating-star');
            
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-zinc-400');
                    star.classList.add('text-amber-400');
                    star.querySelector('i').classList.remove('far');
                    star.querySelector('i').classList.add('fas');
                } else {
                    star.classList.remove('text-amber-400');
                    star.classList.add('text-zinc-400');
                    star.querySelector('i').classList.remove('fas');
                    star.querySelector('i').classList.add('far');
                }
            });
        }
        
        document.getElementById('revBtn').onclick = toggleReviewModal;


        const addToCollectionBtn = document.getElementById('addToCollectionBtn');
        const addToCollectionModal = document.getElementById('addToCollectionModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        addToCollectionBtn.addEventListener('click', () => {
            addToCollectionModal.classList.remove('hidden');
        });
        
        closeModalBtn.addEventListener('click', () => {
            addToCollectionModal.classList.add('hidden');
        });

        addToCollectionModal.addEventListener('click', (e) => {
            if (e.target === addToCollectionModal) {
                addToCollectionModal.classList.add('hidden');
            }
        });
    </script>
</body>
</html> 