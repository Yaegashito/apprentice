<?php

use App\Models\articleTag;

?>
<x-layout>
<div class="home-page">
  <div class="banner">
    <div class="container">
      <h1 class="logo-font">conduit</h1>
      <p>A place to share your knowledge.</p>
    </div>
  </div>

  <div class="container page">
    <div class="row">
      <div class="col-md-9">
        <div class="feed-toggle">
          <ul class="nav nav-pills outline-active">
            <li class="nav-item">
              <a class="nav-link" href="">Your Feed</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="">Global Feed</a>
            </li>
          </ul>
        </div>

        @foreach ($articles as $article)
            <div class="article-preview">
                <div class="article-meta">
                    <a href="/profile/eric-simons"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
                    <div class="info">
                        <a href="/profile/eric-simons" class="author">{{ $user[0]->name }}</a>
                        <span class="date">{{ $article->created_at }}</span>
                    </div>
                    <button class="btn btn-outline-primary btn-sm pull-xs-right">
                        <i class="ion-heart"></i> 29
                    </button>
                </div>
                <a href="{{ route('article', $article->id) }}" class="preview-link">
                    <h1>{{ $article->title }}</h1>
                    {{-- <p>This is the description for the post.</p> --}}
                    <span>Read more...</span>
                    <ul class="tag-list">
                        @foreach (articleTag::where(['article_id' => $article->id])->get() as $articleTag)
                            <li class="tag-default tag-pill tag-outline">{{ $articleTag->articleTag }}</li>
                        @endforeach
                        {{-- <li class="tag-default tag-pill tag-outline">implementations</li> --}}
                    </ul>
                </a>
            </div>
        @endforeach

        {{-- <div class="article-preview">
          <div class="article-meta">
            <a href="/profile/albert-pai"><img src="http://i.imgur.com/N4VcUeJ.jpg" /></a>
            <div class="info">
              <a href="/profile/albert-pai" class="author">Albert Pai</a>
              <span class="date">January 20th</span>
            </div>
            <button class="btn btn-outline-primary btn-sm pull-xs-right">
              <i class="ion-heart"></i> 32
            </button>
          </div>
          <a href="/article/the-song-you" class="preview-link">
            <h1>The song you won't ever stop singing. No matter how hard you try.</h1>
            <p>This is the description for the post.</p>
            <span>Read more...</span>
            <ul class="tag-list">
              <li class="tag-default tag-pill tag-outline">realworld</li>
              <li class="tag-default tag-pill tag-outline">implementations</li>
            </ul>
          </a>
        </div> --}}

        <ul class="pagination">
          <li class="page-item active">
            <a class="page-link" href="">1</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="">2</a>
          </li>
        </ul>
      </div>

      <div class="col-md-3">
        <div class="sidebar">
          <p>Popular Tags</p>

          <div class="tag-list">
            @foreach ($tags as $tag)
                <a href="" class="tag-pill tag-default">{{ $tag->tag }}</a>
            @endforeach
            {{-- <a href="" class="tag-pill tag-default">javascript</a>
            <a href="" class="tag-pill tag-default">emberjs</a>
            <a href="" class="tag-pill tag-default">angularjs</a>
            <a href="" class="tag-pill tag-default">react</a>
            <a href="" class="tag-pill tag-default">mean</a>
            <a href="" class="tag-pill tag-default">node</a>
            <a href="" class="tag-pill tag-default">rails</a> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</x-layout>
