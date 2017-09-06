@extends('layouts.admin')
@section('content')
    <h1>Edit User</h1>

    <div class="col-sm-3">
        <img src="{{$user->photo ? $user->photo->file : 'http://placehold.it/400x400'}}" alt="" class="img-responsive img-rounded" height="125" width="125">
    </div>
    <div class="col-sm-9" >

            {!! Form::model($user,['method'=>'PATCH', 'action'=>['AdminUsersController@update',$user->id],'files'=>true]) !!}
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null,['class'=>'form-control']) !!}

            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::email('email', null,['class'=>'form-control']) !!}

            </div>
            <div class="form-group">
                {!! Form::label('role_id', 'Role:') !!}
                {!! Form::select('role_id',$roles, null,['class'=>'form-control']) !!}

            </div>

            <div class="form-group">
            {!! Form::label('is_active', 'Status:') !!}
            <!-- Number after array is the default value -->
                {!! Form::select('is_active', array(1=>'Active',0=>'No active'),null,['class'=>'form-control']) !!}

            </div>

            <div class="form-group">
                {!! Form::label('photo_id', 'File:') !!}
                {!! Form::file('photo_id', null ,['class'=>'form-control']) !!}

            </div>
            <div class="form-group">
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password', ['class'=>'form-control']) !!}

            </div>
            <div class="form-group">
                {!! Form::submit('Update user',['class'=>'btn btn-primary' ]) !!}

            {!! Form::close() !!}
                <br>
                <br>

                @include('includes.errors')


        </div>

    </div>





@endsection