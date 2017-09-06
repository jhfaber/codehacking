@extends('layouts.admin')
@section('content')
    <h1>Users</h1>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
              <th>#</th>
              <th>Photo</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Created</th>
              <th>Updated</th>
          </tr>
        </thead>
        <tbody>

        @if($users)
            @foreach($users as $user)
                  <tr>
                      <td>{{$user->id}}</td>
                      {{--Los siquientes dos lineas funcionan, pero el src que se dejo funciona con una funcion que se dejo en Photo, this funciton is called--}}
                      {{--getFileAtribute, that recovery automaty the word /images/--}}

                      {{--<td><img height="50" width="70"  src="/images/{{$user->photo ? $user->photo->file : 'No user photo'}}" alt="No found"></td>--}}
                      <td><img height="50" width="70"  src="{!! asset($user->photo ? $user->photo->file : 'http://placehold.it/400x400') !!}" alt="http://placehold.it/400x400"></td>
                      <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->role->name}}</td>
                      <td>{{$user->is_active == 1 ? 'Active' : 'No Active'}}</td>
                      <!-- Then next code is a conditional if x = x ? that :else that -->
                      <td>{{$user->created_at != null ? $user->created_at->diffForHumans() : 'No value'}}</td>
                      <td>{{$user->updated_at != null ? $user->updated_at->diffForHumans() : 'No value'}}</td>
                  </tr>
            @endforeach

        @endif
        </tbody>
      </table>
     </div>



@endsection
