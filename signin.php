<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">GameVault</h1>
                <p class="text-gray-400">Connectez-vous à votre compte</p>
            </div>

            <form action="login_process.php" method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-300 mb-2" for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-purple-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-300 mb-2" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-purple-500"
                           required>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="rounded bg-gray-700 border-gray-600 text-purple-500 focus:ring-purple-500">
                        <label for="remember" class="ml-2 text-gray-300">Se souvenir de moi</label>
                    </div>
                    <a href="#" class="text-purple-500 hover:text-purple-400">Mot de passe oublié?</a>
                </div>

                <button type="submit" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                    Se connecter
                </button>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-800 text-gray-400">Ou continuer avec</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <button class="flex items-center justify-center px-4 py-2 border border-gray-600 rounded-lg hover:bg-gray-700 transition duration-300">
                        <i class="fab fa-google mr-2"></i> Google
                    </button>
                    <button class="flex items-center justify-center px-4 py-2 border border-gray-600 rounded-lg hover:bg-gray-700 transition duration-300">
                        <i class="fab fa-discord mr-2"></i> Discord
                    </button>
                </div>
            </div>

            <p class="mt-8 text-center text-gray-400">
                Pas encore de compte? 
                <a href="signup.php" class="text-purple-500 hover:text-purple-400">S'inscrire</a>
            </p>
        </div>
    </div>
</body>
</html> 