@php
    use Illuminate\Support\Str;
@endphp

@extends('layout')

@section('content')
    <form method="GET" action="/">
      @csrf
      <div class="mb-3">
        <input type="search" class="form-control" id="q" name="q" value={{ request()->get('q') }}>
      </div>
      <button type="submit" class="btn btn-primary">Search</button>
    </form>
    @forelse ($posts as $post)
      <div class="card mt-3">

        <div class="card-head">
          <h5 class="card-title">{{ $post["_source"]["title"] }}</h5>    
        </div>
        <div class="card-body row">
          <div class="col-md-11">
          <p class="card-text">
            {{ Illuminate\Support\Str::limit($post["_source"]["content"], $limit = 500, $end = '...') }}
          </p>              
          </div> 
          <div class="col-md-1">
            <form action="{{ route('post.edit', $post['_id'])  }}" method="GET">
              @csrf
              @method('GET')
              <button class="btn btn-secondary" type="submit">Edit</button>
            </form>       
            <form action="{{ route('post.delete', $post['_id'])  }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>              
          </div> 
        </div>
      </div>
    @empty
      <div class="card mt-3">
        
        <div class="card-body">
          There are no records available
        </div>
      </div>
    @endforelse
@endsection