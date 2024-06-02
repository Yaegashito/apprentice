<?php

use App\Models\articleTag;

?>
<x-layout>
  <div class="article-page">
  <div class="banner">
    <div class="container">
      <h1>{{ $id->title }}</h1>

      <div class="article-meta">
        <a href="/profile/eric-simons"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
        <div class="info">
          <a href="/profile/eric-simons" class="author">{{ $user[0]->name }}</a>
          <span class="date">January 20th</span>
        </div>
        <button class="btn btn-sm btn-outline-secondary">
          <i class="ion-plus-round"></i>
          &nbsp; Follow {{ $user[0]->name }} <span class="counter">(10)</span>
        </button>
        &nbsp;&nbsp;
        <button class="btn btn-sm btn-outline-primary">
          <i class="ion-heart"></i>
          &nbsp; Favorite Post <span class="counter">(29)</span>
        </button>
        @if (Route::has('login'))
        @auth
        <button class="btn btn-sm btn-outline-secondary">
            <i class="ion-edit"></i> <a href="{{ route('edit', $id) }}">Edit Article</a>
        </button>
        <button class="btn btn-sm btn-outline-danger">
            <i class="ion-trash-a"></i> <a href="{{ route('delete', $id) }}">Delete Article</a>
        </button>
        @endauth
        @endif
      </div>
    </div>
  </div>

  <div class="container page">
    <div class="row article-content">
      <div class="col-md-12">
        <p>
            {{ $id->about }}
        </p>
        {{-- <h2 id="introducing-ionic">Introducing RealWorld.</h2> --}}
        <p>{{ $id->body }}</p>
        <ul class="tag-list">
            @foreach (articleTag::where(['article_id' => $id->id])->get() as $articleTag)
                <li class="tag-default tag-pill tag-outline">{{ $articleTag->articleTag }}</li>
            @endforeach
          {{-- <li class="tag-default tag-pill tag-outline">implementations</li> --}}
        </ul>
      </div>
    </div>

    <hr />

    <div class="article-actions">
      <div class="article-meta">
        <a href="profile.html"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
        <div class="info">
          <a href="" class="author">{{ $user[0]->name }}</a>
          <span class="date">January 20th</span>
        </div>

        <button class="btn btn-sm btn-outline-secondary">
          <i class="ion-plus-round"></i>
          &nbsp; Follow {{ $user[0]->name }}
        </button>
        &nbsp;
        <button class="btn btn-sm btn-outline-primary">
          <i class="ion-heart"></i>
          &nbsp; Favorite Article <span class="counter">(29)</span>
        </button>
        @if (Route::has('login'))
        @auth
        <button class="btn btn-sm btn-outline-secondary">
          <i class="ion-edit"></i>  <a href="{{ route('edit', $id) }}">Edit Article</a>
        </button>
        <button class="btn btn-sm btn-outline-danger">
          <i class="ion-trash-a"></i>  <a href="{{ route('delete', $id) }}">Delete Article</a>
        </button>
        @endauth
        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-md-8 offset-md-2">
        <form class="card comment-form" method="post" action="{{ route('comment.store', $id) }}">
          @csrf
          <div class="card-block">
            <textarea class="form-control" name="body" placeholder="Write a comment..." rows="3"></textarea>
          </div>
          <div class="card-footer">
            <img src="http://i.imgur.com/Qr71crq.jpg" class="comment-author-img" />
            <button class="btn btn-sm btn-primary">Post Comment</button>
          </div>
        </form>

        @foreach ($id->comments()->latest()->get() as $comment)
        <div class="card">
          <div class="card-block">
            <p class="card-text">
              {{ $comment->body }}
            </p>
          </div>
          <div class="card-footer">
            <a href="/profile/author" class="comment-author">
              <img src="http://i.imgur.com/Qr71crq.jpg" class="comment-author-img" />
            </a>
            &nbsp;
            <a href="/profile/jacob-schmidt" class="comment-author">Jacob Schmidt</a>
            <span class="date-posted">Dec 29th</span>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
</x-layout>
