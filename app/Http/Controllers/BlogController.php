<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Event;
use App\Postscomment;

class BlogController extends Controller
{
    public function show($id){
        //dd($id);
        //$eventsimages = Event::all();
        //$postDetails = Blog::where('id', $id)->with('postcomments')->get();
        //$postDetails = Blog::find($id)->first();
        $postDetails = Blog::findOrFail($id);
        $postComments = Blog::findOrFail($id)->postcomments;
        $postImage = Blog::findOrFail($id)->blogimage;
        //dd($postDetails);
        
        //echo "<pre>"; print_r(json_decode(json_encode($postDetails))); die;
        return view('post', compact('postDetails', 'postComments', 'postImage'));
    }
}
