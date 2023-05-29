@extends('layout')

@section('content')
    <form method="POST"  action="/post/new">
      <h1>New Record</h1>
      @csrf
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea id="content" class="form-control" name="content"></textarea>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </form>
@endsection

@push('scripts')
  <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#content'
    });
  </script> -->
@endpush