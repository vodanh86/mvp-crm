<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Media;
use App\Models\Banner;
use App\Admin\Controllers\Constant;

class PostController extends Controller
{
    //
    public function index($category)
    {
        $posts = Post::where('category_id', Constant::CATEGORY_ROUTE[$category])
        ->where("show", 1)
        ->orderBy('id')
        ->get();
        return view('travel.'.$category, ['posts' => $posts]);
    }

    public function location($type)
    {
        $posts = Post::where('category_id', 1)
        ->where('type', Constant::LOCATION_TYPE_ROUTE[$type])
        ->where("show", 1)
        ->orderBy('id')
        ->get();
        return view('travel.location', ['posts' => $posts]);
    }

    public function news($id)
    {
        $post = Post::find($id);
        return view('travel.news', ['post' => $post]);
    }

    public function category($id)
    {
        $posts = Post::where('category_id', $id)
        ->orderBy('id', 'desc')
        ->paginate(16);
        return view('travel.category', ['posts' => $posts, 'type' => $id]);
    }

    public function gallery($id)
    {
        $media = Media::where('post_id', $id)->paginate(16);
        return view('travel.gallery', ['media' => $media, 'post' => Post::find($id)]);
    }

    public function media()
    {
        $posts = Post::where('category_id', 5)
        ->where('show', 1)->paginate(16);
        return view('travel.media', ['posts' => $posts]);
    }

    public function map()
    {
        $locations = Post::where('category_id', 1)
        ->orderBy('type')
        ->get()
        ->groupBy('type');
        $posts = Post::orderBy('id')
        ->get()
        ->groupBy('category_id');
        return view('travel.map', ['locations' => $locations, 'posts' => $posts]);
    }
}
