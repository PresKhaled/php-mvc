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
        $path = (views_path() . '/' . str_replace('.', '/', $path));

        if (is_dir($path)) {
            $path .= '/index';
        }

        if (!is_file($path .= '.php')) {
            throw new Exception("Target view (file): '$path' not found.");
        }

        $layout = self::getLayout();
        $viewContent = self::getViewContent($path, $params);
        // dump($layout, $viewContent, str_replace('{{CONTENT}}', $viewContent, $layout));

        $count = 1;

        return str_replace('{{CONTENT}}', $viewContent, $layout, $count);
    }

    protected static function getLayout(): bool|string
    {
        ob_start();

        require_once(views_path() . '/layouts/main.php');

        return ob_get_clean();
    }

    protected static function getViewContent(string $path, array $params): bool|string
    {
        extract($params);

        ob_start();

        require_once $path;

        return ob_get_clean();
    }
}
