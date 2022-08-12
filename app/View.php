<?php

namespace App;

use Exception;

class View
{
    /**
     * -
     *
     * @throws Exception
     */
    public static function make(string $path, array $params = []): bool|string
    {
        $path = view_path($path);

        $layout = self::getLayout();
        $viewContent = self::getViewContent($path, $params);

        $count = 1;

        return str_replace('{{CONTENT}}', $viewContent, $layout, $count);
    }

    protected static function getLayout(): bool|string
    {
        ob_start();

        require(views_path() . '/layouts/main.php');

        return ob_get_clean();
    }

    protected static function getViewContent(string $path, array $params): bool|string
    {
        extract($params);

        ob_start();

        require $path;

        return ob_get_clean();
    }
}
