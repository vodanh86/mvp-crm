<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Banner;
use App\Models\FormalityAdmin;
use App\Models\FormalityOps;
use App\Models\FormalityLevel;
use App\Models\FormalityArea;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function index()
    {
        $categories = Category::orderBy('order')
        ->get()
        ->groupBy('parent_id');
        $featurePages = Page::orderBy('id', 'desc')
        ->take(5)
        ->get();
        $banners = Banner::where('show', 1)
        ->orderBy('order')
        ->get();
        $pages = Page::orderBy('id', 'desc')
        ->get()
        ->groupBy('category_id');
        return view('portal.index', ['categories' => $categories, 'pages' => $pages, 'banners' => $banners, 'featurePages' => $featurePages]);
    }

    public function services()
    {
        return view('portal.services');
    }

    public function detail($id)
    {
        $page = Page::find($id);
        return view('portal.detail', ['page' => $page]);
    }

    public function contact()
    {
        return view('portal.contact');
    }

    public function about()
    {
        return view('portal.about');
    }

    public function news()
    {
        return view('portal.news');
    }

    public function category()
    {
        $id = 1;
        $pages = Page::where('category_id', $id)
        ->orderBy('id', 'desc')
        ->paginate(12);
        $categories = Category::orderBy('order')
        ->get()
        ->groupBy('parent_id');
        $banners = Banner::where('show', 1)
        ->orderBy('order')
        ->get();
        return view('portal.category', ['pages' => $pages, 'page' => $pages[0], 'banners' => $banners, 'categories' => $categories, 'category' => Category::find($id)]);
    }

    public function share()
    {
        $id = 2;
        $pages = Page::where('category_id', $id)
        ->orderBy('id', 'desc')
        ->paginate(12);
        $categories = Category::orderBy('order')
        ->get()
        ->groupBy('parent_id');
        $banners = Banner::where('show', 1)
        ->orderBy('order')
        ->get();
        return view('portal.share', ['pages' => $pages, 'page' => $pages[0], 'banners' => $banners, 'categories' => $categories, 'category' => Category::find($id)]);
    }
}
