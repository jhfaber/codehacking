@extends('layouts.admin')
@section('content')
    <h1>Post</h1>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
              <th>Photos</th>
            <th>User</th>
            <th>Category</th>
            <th>Title</th>
            <th>Body</th>
              <th>Created</th>
              <th>Updated</th>
          </tr>
        </thead>
          <tbody>

              @if($posts)
                    @foreach($posts as $post)

                          <tr>
                                <td>{{$post->id}}</td>
                              <td><img height=50 width="50" src="{{$post->photo_id ? $post->photo->file : 'http://placehold.it/400x400'}}" alt=""></td>
                                <td>{{$post->user->name}}</td>
                                <td>{{$post->category_id}}</td>
                                <td>{{$post->title}}</td>
                                <td>{{$post->body}}</td>
                                <td>{{$post->created_at->diffForhumans()}}</td>
                                <td>{{$post->updated_at->diffForhumans()}}</td>

                          </tr>

                    @endforeach
                @endif
          </tbody>
      </table>
    </div>
    @stop