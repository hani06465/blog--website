<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
//use Ramsey\uuid\Type\Time;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addpost(){
        return view('admin.add_post');
    }
    public function createpost(Request $request){
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $image = $request->image;
        // and instead of using the images name from the user we have to save the name of the image like in time.. ex: if it is text.png we do it like 12345.png:
        if($image=$request->image){
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $post->image = $imagename;
        }
        
        
        $post->user_name = Auth::User()->name;
        $post->user_id = Auth::User()->id;
        $post->save();
        if($image=$request->image && $post->save()){
            // since we can't save the image in data base we are to store it in the public repostiry by creating folder called img:
            $request->image->move('img',$imagename);
           
        }
         return redirect()->route('admin.Addpost')->with('status','Added successfully!');
    }
    public function allpost(){
        $post = Post::all();
        return view('admin.allpost',compact('post'));
    }
    public function updatePost($id){
         $post = Post::findOrFail($id);
         return view('admin.updatepost',compact('post'));
    }
    public function postupdate(Request $request,$id){
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $image = $request->image;
        if($image = $request->image){
                // and instead of using the images name from the user we have to save the name of the image like in time.. ex: if it is text.png we do it like 12345.png:
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $post->image=$imagename;
        }
        
        $post->user_name = Auth::User()->name;
        $post->user_id = Auth::User()->id;
        $post->save();
        if($image = $request->image && $post->save()){
            // since we can't save the image in data base we are to store it in the public repostiry by creating folder called img:
            $request->image->move('img',$imagename);
            
        }
        return redirect()->route('admin.allpost')->with('status','updated Successfully!');
    }

    public function deletePost($id){
       $post = Post::findOrFail($id);
        
       return view('admin.postdelete',compact('post'));
       
    }

    public function postDelete(Request $request, $id){
        $post = Post::findOrFail($id);
        if($request->id == $post->id){
            $post->delete();
            return redirect()->route('admin.allpost')->with('danger','Deleted Successfully!');
        }else{
             return redirect()->route('admin.allpost');
        }
        


    }
}
