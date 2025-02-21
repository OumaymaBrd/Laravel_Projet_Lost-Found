<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-white text-2xl font-bold">Lost & Found</a>
            <div>
                @auth
                    <a href="{{ route('announcements.create') }}" class="text-white mr-4">Créer une annonce</a>
                    <a href="{{ route('announcements.my') }}" class="text-white mr-4">Mes annonces</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-white">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white mr-4">Connexion</a>
                    <a href="{{ route('register') }}" class="text-white">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-6">
        @yield('content')
    </main>
</body>
</html>
