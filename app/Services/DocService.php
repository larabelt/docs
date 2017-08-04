<?php

namespace App\Services;

use Parsedown;

class DocService
{

    public $parsedown;

    public function parsedown()
    {
        return $this->parsedown ?: $this->parsedown = new Parsedown();
    }

    public function path($key)
    {
        $path = sprintf('%s/%s.md', resource_path('docs'), $key);

        return $path;
    }

    public function contents($path)
    {
        $contents = '';

        if (file_exists($path)) {
            $contents = file_get_contents($path);
        }

        return $contents;
    }

    public function get($key)
    {
        $path = $this->path($key);

        if ($contents = $this->contents($path)) {
            return $this->convert($contents);
        }
    }

    public function convert($contents)
    {
        $html = '';

        try {
            $html = $this->parsedown()->parse($contents);
        } catch (\Exception $e) {

        }

        return $html;
    }
}