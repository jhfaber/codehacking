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
              <th>View Post</th>
              <th>Manage Comments</th>
              <th>Created</th>
              <th>Updated</th>
          </tr>
        </thead>
          <tbody>

              @if($posts)
                    @foreach($posts as $post)

                          <tr>
                                <td>{{$post->id}}</td>
                              <td><img height=50 width="100" src="{{$post->photo_id ? $post->photo->file : 'http://placehold.it/400x400'}}" alt=""></td>
                                <td><a href="{{route('posts.edit', $post->id)}}">{{$post->user->name}}</a></td>
                                <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
                                <td>{{str_limit($post->title, 10)}}</td>
                                <!--str_limit doing that only appear 15 characters AWESOME! search helper strings laravel-->
                                <td>{{str_limit($post->body,19)}}</td>
                                <td><a href="{{route('home.post', $post->id)}}">View</a></td>
                                <td><a href="{{route('comments.show', $post->id)}}">Manage</a></td>
                                <td>{{$post->created_at->diffForhumans()}}</td>
                                <td>{{$post->updated_at->diffForhumans()}}</td>

                          </tr>

                    @endforeach
                @endif
          </tbody>
      </table>
    </div>
    @stop