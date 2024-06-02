<x-layout>
    <div class="editor-page">
  <div class="container page">
    <div class="row">
      <div class="col-md-10 offset-md-1 col-xs-12">
        <ul class="error-messages">
          @error('title')
            <li>{{ $message }}</li>
          @enderror
        </ul>

        <form method="post" action="{{ route('edit.update', $id) }}">
          @method('PATCH')
          @csrf
          <fieldset>
            <fieldset class="form-group">
              <input type="text" name="title" class="form-control form-control-lg" placeholder="Article Title" />
            </fieldset>
            <fieldset class="form-group">
              <input type="text" name="about" class="form-control" placeholder="What's this article about?" />
            </fieldset>
            <fieldset class="form-group">
              <textarea
                class="form-control"
                name="body"
                rows="8"
                placeholder="Write your article (in markdown)"
              ></textarea>
            </fieldset>
            <fieldset class="form-group">
              <input type="text" class="form-control" placeholder="Enter tags" name="tags"/>
              <div class="tag-list">
                {{-- <span class="tag-default tag-pill"> <i class="ion-close-round"></i> tag </span> --}}
              </div>
            </fieldset>
            <button class="btn btn-lg pull-xs-right btn-primary" type="submit">
              Publish Article
            </button>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
</x-layout>
