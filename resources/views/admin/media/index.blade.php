@extends('layouts.admin')
@section('content')
    <h1>Media</h1>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Created at</th>

          </tr>
        </thead>
        <tbody>
        @foreach($photos as $photo)
          <tr>
            <td>{{$photo->id}}</td>
            <td><img height="100px" width="100px" src="{{$photo->file}}" alt=""></td>
            <td>{{$photo->created_at ? $photo->created_at : 'No date'}}</td>
            <td>
              {!! Form::open(['method'=>'DELETE', 'action'=>['AdminMediaController@destroy', $photo->id]]) !!}

                      <div class="form-group">
                          {!! Form::submit('Delete',['class'=>'btn btn-danger' ]) !!}
                      </div>
              {!! Form::close() !!}
            </td>


          </tr>
            @endforeach
        </tbody>
      </table>
     </div>

@stop