<?php


namespace app;

use app\Database;

class Router
{
    public array $getUrl;
    public array $postUrl;
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function get($url, $fn): void
    {
        $this->getUrl[$url] = $fn;
    }


    public function post($url, $fn): void
    {
        $this->postUrl[$url] = $fn;
    }


    public function resolve()
    {
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getUrl[$currentUrl] ?? null;
        } else {
            $fn = $this->postUrl[$currentUrl] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            echo "Page not found";
        }
    }


    public function renderView($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once __DIR__ . "/views/$view.php";
        $content = ob_get_clean();
        include_once __DIR__ . '/views/_layout.php';
    }

}