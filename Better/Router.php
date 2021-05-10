<?php


namespace app;


class Router
{
    public array $getUrl;
    public array $postUrl;


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
            call_user_func($fn);
        } else {
            echo "Page not found";
        }
    }

}