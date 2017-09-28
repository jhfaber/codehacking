<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Photo;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::pluck('name','id')->all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {

        /**
         * AWESOME CODE, the next code store in two differents tables photos and
         * users, first store the file, it is important assignate to a object,
         * because that object have the id of the photo and the path of the photo,
         * save the id of the photo as foreign key, thanks to that, we can retrieve
         * the user and her correnonding photo,
         *
         */
        $input = $request->all();

        if($file= $request->file('photo_id')){
            $name= time(). $file->getClientOriginalName(); //name format
            $file->move('images',$name);
            $photo= Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id; //it is a foreign key photo->id is the id of the photo
        }
        $input['password']=bcrypt($request->password);
//          return $photo;
        User::create($input);
        return redirect('/admin/users');


//        $data= $request->name;
//        return 'the name is '.$data;

//        $user = new User();
//        $user->name = $request->name;
//        $user->email = $request->email;
//        $user->role_id = $request->role_id;
//        $user->save();

//        User::create($request->all());
//        return redirect('/admin/users');
//        return 'hi';


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name','id');
        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        /**
         * DON'T SAVE A PASSWORD EMPTY, if the password is empty don't update
         * that
         */
        if(trim($request->password) =='' ){

            $input = $request->except('password');


        }else{

            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        /**
         *THE NEXT CODE IS FOR VALIDATE IF THE FORM HAVE ONE PHOTO,
         * IF THAT IS THE CASE, change the name with the actual date and the
         * original name of the file, later moves that to a directory, /images/{name}
         * later update the path of the file in Photo model,
         */
        $user = User::findOrFail($id);
        if($file = $request->file('photo_id')){
            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;


        }
        $user->update($input);
        return redirect('admin/users');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->photo_id!=NULL){
            unlink(public_path().$user->photo->file);
            Photo::findOrFail($user->photo_id)->delete();
        }





        //mesage after delete one user
        Session::flash('deleted_user', 'The user has been deleted');
        $user->delete();

        return redirect('admin/users');
    }
}
