<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\articleTag;
use App\Models\User;

class ConduitController extends Controller
{
    public function dashboard()
    {
        $articles = Article::all();
        $tags = Tag::all();
        $user = User::all();

        return view('dashboard')
            ->with(['articles' => $articles, 'tags' => $tags, 'user' => $user]);
    }

    public function editor()
    {
        return view('editor');
    }

    public function article(Article $id)
    {
        $user = User::all();

        return view('article')
            ->with(['id' => $id, 'user' => $user]);
    }

    public function store(Request $request, Article $id)
    {
        $request->validate([
            'title' => 'required'
        ], [
            'title.required' => 'タイトルを入力してください'
        ]);

        $id->title = $request->title;
        $id->about = $request->about;
        $id->body = $request->body;
        $id->save();

        $tags = explode(" ", $request->tags);
        foreach ($tags as $tag) {
            $articleTag = new articleTag();
            $articleTag->article_id = $id->id;
            $articleTag->articleTag = $tag;
            $articleTag->save();
        }

        return redirect()
            ->route('home');
    }

    public function edit(Article $id)
    {
        return view('edit', $id);
    }

    public function update(Request $request, Article $id)
    {
        $request->validate([
            'title' => 'required'
        ], [
            'title.required' => 'タイトルを入力してください'
        ]);

        $id->title = $request->title;
        $id->about = $request->about;
        $id->body = $request->body;
        $id->save();

        $tags = explode(" ", $request->tags);
        ArticleTag::where(['article_id' => $id->id])->delete();
        foreach ($tags as $tag) {
            $articleTag = new ArticleTag();
            $articleTag->article_id = $id->id;
            $articleTag->articleTag = $tag;
            $articleTag->save();
        }

        return redirect()
            ->route('home', $id);
    }

    public function delete(Article $id)
    {
        $id->delete();

        return redirect()
            ->route('home', $id);
    }
}
