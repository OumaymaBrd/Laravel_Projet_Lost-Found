@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-md mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Connexion</h2>
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" required autofocus class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">Se connecter</button>
        </div>
    </form>
    <p class="mt-4 text-center text-sm text-gray-600">Pas encore de compte ? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">S'inscrire</a></p>
</div>
@endsection

<style>
    body {
        background-color: #f3f4f6;
        font-family: 'Arial', sans-serif;
    }
    .container {
        /* min-height: calc(100vh - 4rem); */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>

