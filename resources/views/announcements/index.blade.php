@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Toutes les annonces</h1>

    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <div class="md:w-1/4">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
            <select id="category" name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $value => $label)
                    <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:w-1/2">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
            <div class="flex gap-2">
                <input type="text"
                       id="search"
                       name="search"
                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Rechercher par titre"
                       value="{{ request('search') }}">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Filtrer
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($announcements as $announcement)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($announcement->image)
                    <img src="{{ asset('storage/' . $announcement->image) }}"
                         alt="Image de {{ $announcement->title }}"
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">Pas d'image</span>
                    </div>
                @endif

                <div class="p-6">
                    <div class="flex items-center gap-2 mb-4">
                        @if($announcement->type === 'lost')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Perdu
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Trouvé
                            </span>
                        @endif
                        <span class="text-sm text-gray-500">
                            {{ $announcement->date->format('d/m/Y') }}
                        </span>
                    </div>

                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('announcements.show', $announcement) }}"
                           class="text-gray-900 hover:text-blue-600">
                            {{ $announcement->title }}
                        </a>
                    </h2>

                    <div class="mb-4">
                        <p class="text-gray-600 text-sm mb-2">
                            <span class="font-medium">Lieu:</span> {{ $announcement->location }}
                        </p>
                        <p class="text-gray-600 text-sm">
                            <span class="font-medium">Catégorie:</span> {{ $categories[$announcement->category] }}
                        </p>
                    </div>

                    <p class="text-gray-700 mb-4 line-clamp-3">
                        {{ $announcement->description }}
                    </p>

                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>Publié par {{ $announcement->user->name }}</span>
                        <span>{{ $announcement->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500">Aucune annonce trouvée.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $announcements->links() }}
    </div>
</div>

@push('scripts')
<script>
document.getElementById('category').addEventListener('change', function() {
    updateFilters();
});

document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        updateFilters();
    }
});

function updateFilters() {
    const category = document.getElementById('category').value;
    const search = document.getElementById('search').value;

    let url = new URL(window.location.href);

    if (category) {
        url.searchParams.set('category', category);
    } else {
        url.searchParams.delete('category');
    }

    if (search) {
        url.searchParams.set('search', search);
    } else {
        url.searchParams.delete('search');
    }

    window.location.href = url.toString();
}
</script>
@endpush
@endsection
