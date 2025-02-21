@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Mes annonces</h1>

    <div class="mb-6">
        <form action="{{ route('announcements.my') }}" method="GET" class="flex items-center space-x-4">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                <select name="category" id="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $value => $label)
                        <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Recherche</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Rechercher par titre">
            </div>
            <div class="mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($announcements as $announcement)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                @if($announcement->image)
                    <img src="{{ asset('storage/' . $announcement->image) }}" alt="Image de l'annonce" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-2">
                        <a href="{{ route('announcements.show', $announcement) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $announcement->title }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-4">
                        {{ $announcement->type === 'lost' ? 'Perdu' : 'Trouvé' }} le {{ $announcement->date->format('d/m/Y') }}
                    </p>
                    <p class="text-gray-600 mb-2">Lieu: {{ $announcement->location }}</p>
                    <p class="text-gray-600 mb-4">
                        Catégorie: {{ $categories[$announcement->category] }}
                    </p>
                    <p class="text-gray-800 mb-4">{{ Str::limit($announcement->description, 100) }}</p>
                    <p class="text-gray-600 text-sm">
                        Publié le {{ $announcement->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $announcements->links() }}
    </div>
</div>
@endsection
