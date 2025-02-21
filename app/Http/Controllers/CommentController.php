<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Announcement $announcement)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->announcement_id = $announcement->id;
        $comment->save();

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès.');
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $reply = new Comment();
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->announcement_id = $comment->announcement_id;
        $reply->parent_id = $comment->id;
        $reply->save();

        return redirect()->back()->with('success', 'Réponse ajoutée avec succès.');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Commentaire supprimé avec succès.');
    }
}
