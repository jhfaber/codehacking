<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostsCreateRequest;
use Auth;
use App\Photo;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        $input = $request->all();
        $user= Auth::user(); //return the actually user looged in

        if($file =$request->file('photo_id')){
            $name= time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        /**
         * $user->posts() it is the accessing the relationship between User and his Post
         * so by using this $user->posts()->create($input); you are creating the new Post,
         * but you're also associating that newly created Post with the User
         */
        $user->posts()->create($input);

        return redirect('/admin/posts');



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
        $post = Post::findOrFail($id);
        $categories = Category::pluck('name')->all();
        return view('/admin.posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $input = $request->all();
         //i am a genius for doing that:
         $input['category_id'] = $input['category_id']+1;
        if($file =$request->file('photo_id')){
            $name= time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        /**
         * First we are accessing the current authenticated user, with Auth::user() and then we are accessing his/hers posts with ->posts() and then we are filtering out the posts with ->whereId($id) and then we are retrieving that particular single post with ->first() and finally after all that we are updating that retrieved post with ->update($input)
         * Take care: whereId retrieve one arrary, first retrieve the first element of that array, ni this case is a array of one
         */
          Auth::user()->posts()->whereId($id)->first()->update($input);

        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::findOrFail($id);
        unlink(public_path().$post->photo->file);
        Photo::findOrFail($post->photo_id)->delete();
        $post->delete();
        return redirect('/admin/posts');
    }

    public function post($id){
        $post = Post::findOrFail($id);
        $comments = $post->comments()->whereIsActive(1)->get();

        return view('post', compact('post','comments'));
    }
}
