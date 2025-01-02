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
    <div class="fixed inset-y-0 left-0 w-64 bg-gray-800">
        <div class="flex items-center justify-center h-20 bg-gray-700">
            <h1 class="text-2xl font-bold">GameVault</h1>
        </div>
        <nav class="mt-5">
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-home mr-3"></i>
                Dashboard
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-gamepad mr-3"></i>
                Mes Jeux
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-users mr-3"></i>
                Utilisateurs
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-comments mr-3"></i>
                Chat
            </a>
        </nav>
    </div>

    <div class="ml-64 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Tableau de bord</h2>
            <div class="flex items-center">
                <span class="mr-4">Admin</span>
                <img src="https://via.placeholder.com/40" class="rounded-full">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-gamepad text-purple-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Total Jeux</h3>
                        <p class="text-2xl font-bold">1,234</p>
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
                    <i class="fas fa-star text-yellow-500 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-gray-400">Critiques</h3>
                        <p class="text-2xl font-bold">3,456</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">Activités Récentes</h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <img src="https://via.placeholder.com/32" class="rounded-full mr-4">
                    <div>
                        <p class="font-medium">John Doe a ajouté Elden Ring à sa collection</p>
                        <p class="text-sm text-gray-400">Il y a 5 minutes</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <img src="https://via.placeholder.com/32" class="rounded-full mr-4">
                    <div>
                        <p class="font-medium">slm coco cv</p>
                        <p class="text-sm text-gray-400">Il y a 15 minutes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 