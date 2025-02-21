@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
        <div class="space-y-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Créer une nouvelle annonce</h1>
                <p class="mt-2 text-sm text-gray-600">Remplissez les informations ci-dessous pour créer votre annonce.</p>
            </div>

            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white shadow-lg rounded-xl p-6 sm:p-8">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="title">
                            Titre
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </div>
                            <input class="block w-full pl-10 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                                   id="title"
                                   type="text"
                                   name="title"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="description">
                            Description
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                            </div>
                            <textarea class="block w-full pl-10 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      required></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="type">
                                Type
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
                                        <line x1="4" y1="22" x2="4" y2="15"/>
                                    </svg>
                                </div>
                                <select class="block w-full pl-10 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                                        id="type"
                                        name="type"
                                        required>
                                    <option value="lost">Perdu</option>
                                    <option value="found">Trouvé</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="category">
                                Catégorie
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 7h-7L10 3H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                    </svg>
                                </div>
                                <select class="block w-full pl-10 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                                        id="category"
                                        name="category"
                                        required>
                                    @foreach($categories as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="date">
                                Date
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                </div>
                                <input class="block w-full pl-10 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                                       id="date"
                                       type="date"
                                       name="date"
                                       required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="location">
                                Lieu
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                </div>
                                <input class="block w-full pl-10 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                                       id="location"
                                       type="text"
                                       name="location"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition duration-150 bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/>
                                    <line x1="16" y1="5" x2="22" y2="5"/>
                                    <line x1="19" y1="2" x2="19" y2="8"/>
                                    <circle cx="9" cy="9" r="2"/>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Télécharger un fichier</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG jusqu'à 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Créer l'annonce
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
    body {
        background-color: #f9fafb;
    }

    /* Style personnalisé pour le champ de date */
    input[type="date"] {
        min-height: 38px;
    }

    /* Amélioration du style de focus pour tous les champs */
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
    }

    /* Style pour le survol des champs */
    input:hover, select:hover, textarea:hover {
        border-color: #93c5fd;
    }

    /* Style personnalisé pour le champ de téléchargement */
    .file-upload-hover:hover {
        background-color: #f3f4f6;
    }
</style>

