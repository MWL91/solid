<?php
/* model */
class Post extends Model {
    protected $table = 'posts';
    // ...
}

/* controller */
class PostController extends Controller {
    public function index() {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }
    // ...
}

/* blade file */
@foreach($posts as $post)
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->content }}</p>
@endforeach
