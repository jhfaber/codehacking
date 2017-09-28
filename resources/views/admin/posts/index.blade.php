@extends('layouts.admin')
@section('content')
    <h1>Post</h1>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Use</th>
            <th>Category</th>
            <th>Photos</th>
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
                                <td>{{$post->user_id}}</td>
                                <td>{{$post->category_id}}</td>
                                <td>{{$post->photo_id}}</td>
                                <td>{{$post->body}}</td>
                                <td>{{$post->created_at}}</td>
                                <td>{{$post->updated_at}}</td>

                          </tr>

                    @endforeach
                @endif
          </tbody>
      </table>
    </div>
    @stop