@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $announcement->title }}</h1>

            <div class="flex items-center mb-4">
                @if($announcement->type === 'lost')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        Perdu
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Trouvé
                    </span>
                @endif
                <span class="mx-2">•</span>
                <span class="text-gray-600">
                    Le {{ $announcement->date->format('d/m/Y') }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Lieu</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $announcement->location }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Catégorie</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $categories[$announcement->category] }}</p>
                </div>
            </div>

            @if($announcement->image)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $announcement->image) }}"
                         alt="Image de {{ $announcement->title }}"
                         class="w-full h-auto rounded-lg shadow-md">
                </div>
            @endif

            <div class="prose max-w-none mb-6">
                <h2 class="text-xl font-semibold mb-2">Description</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $announcement->description }}</p>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <p class="text-gray-600">
                    Publié par <span class="font-medium">{{ $announcement->user->name }}</span>
                    le {{ $announcement->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            @if(Auth::check())
                @if(Auth::id() === $announcement->user_id)
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ route('announcements.edit', $announcement) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-md transition-colors">
                            Modifier
                        </a>
                        @if($announcement->type === 'lost' && $announcement->status === 'active')
                            <form action="{{ route('announcements.markAsFound', $announcement) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-md transition-colors">
                                    Marquer comme trouvé
                                </button>
                            </form>
                        @endif
                    </div>
                @elseif($announcement->type === 'found' && $announcement->status === 'active')
                    <form action="{{ route('announcements.claimItem', $announcement) }}" method="POST" class="mt-6">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md transition-colors">
                            C'est à moi
                        </button>
                    </form>
                @endif
            @endif
        </div>

        <div class="bg-gray-50 p-6">
            <h2 class="text-2xl font-bold mb-6">Commentaires</h2>

            @auth
                <form action="{{ route('comments.store', $announcement) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Votre commentaire
                        </label>
                        <textarea name="content"
                                  id="content"
                                  rows="3"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  required></textarea>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-md transition-colors">
                        Publier le commentaire
                    </button>
                </form>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-8">
                    <p class="text-yellow-700">
                        <a href="{{ route('login') }}" class="font-medium underline hover:text-yellow-800">
                            Connectez-vous
                        </a>
                        pour laisser un commentaire.
                    </p>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($announcement->comments->whereNull('parent_id') as $comment)
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-1">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                    <span class="text-gray-500 mx-1">•</span>
                                    <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="mt-1 text-gray-700">
                                    {{ $comment->content }}
                                </div>

                                @if(Auth::check())
                                    <form action="{{ route('comments.reply', $comment) }}" method="POST" class="mt-4">
                                        @csrf
                                        <div class="flex gap-2">
                                            <input type="text"
                                                   name="content"
                                                   class="flex-1 min-w-0 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                   placeholder="Répondre à ce commentaire"
                                                   required>
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-md transition-colors">
                                                Répondre
                                            </button>
                                        </div>
                                    </form>
                                @endif

                                @if($comment->replies->count() > 0)
                                    <div class="mt-4 space-y-4 pl-6 border-l-2 border-gray-100">
                                        @foreach($comment->replies as $reply)
                                            <div class="bg-gray-50 rounded-md p-3">
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-900">{{ $reply->user->name }}</span>
                                                    <span class="text-gray-500 mx-1">•</span>
                                                    <span class="text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="mt-1 text-gray-700">
                                                    {{ $reply->content }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        Aucun commentaire pour le moment.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
