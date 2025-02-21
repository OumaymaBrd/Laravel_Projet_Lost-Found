<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('user');

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->latest()->paginate(10);
        $categories = $this->getCategories();

        return view('announcements.index', compact('announcements', 'categories'));
    }

    public function create()
    {
        $categories = $this->getCategories();
        return view('announcements.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:lost,found',
            'category' => 'required|in:clothes,electronics,keys,other',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $announcement = new Announcement($request->all());
        $announcement->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
            $announcement->image = $imagePath;
        }

        $announcement->save();

        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'Annonce créée avec succès.');
    }

    public function show(Announcement $announcement)
    {
        $announcement->load(['comments' => function($query) {
            $query->whereNull('parent_id')
                  ->with(['user', 'replies.user'])
                  ->orderBy('created_at', 'desc');
        }, 'user']);

        $categories = $this->getCategories();

        return view('announcements.show', compact('announcement', 'categories'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        $categories = $this->getCategories();
        return view('announcements.edit', compact('announcement', 'categories'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:lost,found',
            'category' => 'required|in:clothes,electronics,keys,other',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $announcement->fill($request->except('image'));

        if ($request->hasFile('image')) {
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $imagePath = $request->file('image')->store('announcements', 'public');
            $announcement->image = $imagePath;
        }

        $announcement->save();

        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);

        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }

    public function myAnnouncements(Request $request)
    {
        $query = Announcement::where('user_id', Auth::id());

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->latest()->paginate(10);
        $categories = $this->getCategories();

        return view('announcements.my', compact('announcements', 'categories'));
    }

    public function markAsFound(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        $announcement->status = 'found';
        $announcement->save();
        return redirect()->back()->with('success', 'Annonce marquée comme trouvée.');
    }

    public function claimItem(Announcement $announcement)
    {
        if ($announcement->status !== 'active') {
            return redirect()->back()->with('error', 'Cet objet n\'est plus disponible.');
        }

        $announcement->status = 'claimed';
        $announcement->claimer_id = Auth::id();
        $announcement->save();

        return redirect()->back()->with('success', 'Vous avez revendiqué cet objet.');
    }

    private function getCategories()
    {
        return [
            'clothes' => 'Vêtements',
            'electronics' => 'Appareils électroniques',
            'keys' => 'Clés',
            'other' => 'Autre'
        ];
    }
}
