<?php

namespace App\controllers;

class PostController
{
    public function index() {
        $posts = [
            ['id' => 1, 'title' => 'Post title', 'content' => 'Post content _' . random_int(11, 111)],
            ['id' => 2, 'title' => 'Post title 2', 'content' => 'Post content _' . random_int(11, 111)],
            ['id' => 3, 'title' => 'Post title 3', 'content' => 'Post content _' . random_int(11, 111)],
        ];

        return view('posts', compact('posts'));
    }
}
