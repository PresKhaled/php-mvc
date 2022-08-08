<?php

namespace App\controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class PostController
{
    /**
     * -
     *
     * @throws Exception
     */
    #[NoReturn] public function index(): void
    {
        $posts = [
            ['id' => 1, 'title' => 'Post title', 'content' => 'Post content _' . random_int(11, 111)],
            ['id' => 2, 'title' => 'Post title 2', 'content' => 'Post content _' . random_int(11, 111)],
            ['id' => 3, 'title' => 'Post title 3', 'content' => 'Post content _' . random_int(11, 111)],
        ];

        view('posts', compact('posts'));
    }
}
