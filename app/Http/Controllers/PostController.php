<?php

namespace App\Http\Controllers;

use App\Mail\PostCreated;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->authorizeResource(Post::class, 'post');

        //$this->middleware('can:update,post')->only('edit', 'update');
        //$this->middleware('can:delete,post')->only('destroy');
        // $this->middleware('log')->only('index');
        // $this->middleware('subscribed')->except('store');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $postsQuery = Post::with(['user', 'category'])->latest();
        if ($request->query('category')) {
            $postsQuery->where('category_id', (int) $request->query('category'));
        }

        if ($request->query('user')) {
            $postsQuery->where('user_id', (int) $request->query('user'));
        }
        $posts = $postsQuery->paginate(10)->withQueryString();
        return view('post.index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|numeric|exists:categories,id',
            'title' => 'required',
            'content' => 'required',
            'tags' => 'nullable|string',
        ]);

        $post = new Post;
        $post->user_id = $request->user()->id;
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        // $tagString = 'yazılım';
        // $tag = Tag::where('name', $tagString)->get();
        // $post->tags()->attach($tag->id);

        // Post::create($request->validated());

        $post->setTags($request->tags);
        session()->flash('status', __('Post Created!'));

        Mail::to($request->user())->send(new PostCreated($post));

        return redirect()->route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // $post = Post::with(['user', 'category', 'tags'])->findOrFail($post->id);
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'category_id' => 'required|numeric|exists:categories,id',
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->user_id = $request->user()->id;
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        session()->flash('status', __('Post Updated!'));

        return redirect()->route('posts.show', $post);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        session()->flash('status', __('Post Deleted'));

        return redirect()->route('posts.index');
    }
}
