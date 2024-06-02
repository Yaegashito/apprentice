<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(request $request, Article $id)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $comment = new Comment();
        $comment->article_id = $id->id;
        $comment->body = $request->body;
        $comment->save();

        return redirect()
            ->route('article', $id);
    }

}
