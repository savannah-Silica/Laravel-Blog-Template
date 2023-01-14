<?php

namespace App\Http\Controllers;

use App\Models\Blog as ModelBlog;
use Illuminate\Http\Request;

class Blog extends Controller
{
    //index 
    public function index() {
        return view('Posts.index', [
            'Posts' => ModelBlog::latest()->filter(request(['tag', 'search']))->paginate(5)
        ]);
    }


    //show blog detail

    public function detail(ModelBlog $blog) {
        return view('Posts.detail', [
            'blog' => $blog
        ]);
    }
    // show create form
    public function create() {
        return view('Posts.create');
    }


    //Store created blog
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'body' => 'required',
            'tags' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        ModelBlog::create($data);

        return redirect('/')->with('message', 'Blog created successfully!');
    }

    //Show edit Form

    public function edit(ModelBlog $blog) {
        return view('Posts.edit', ['blog' => $blog]);
    }

    //Update blog

    public function update(Request $request, ModelBlog $blog) {
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'body' => 'required',
            'author' => 'required',
            'tags' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $blog->update($data);

        return back()->with('message', 'Blog updated successfully!');
    }


    public function destroy(ModelBlog $blog) {
        $blog->delete();
        return redirect('/')->with('message', 'Blog deleted successfully!');
    }

    
}
