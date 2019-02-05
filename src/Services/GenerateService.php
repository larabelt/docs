<?php

namespace Belt\Docs\Services;

use Belt;
use Parsedown;

class GenerateService
{

    use Belt\Core\Behaviors\HasConfig;
    use Belt\Core\Behaviors\HasDisk;

    /**
     * @var string
     */
    protected $configPath = 'belt.docs';

    public $parsedown;

//    public function parsedown()
//    {
//        return $this->parsedown ?: $this->parsedown = new Parsedown();
//    }
//
//    public function convert($contents)
//    {
//        $html = '';
//
//        try {
//            $html = $this->parsedown()->parse($contents);
//        } catch (\Exception $e) {
//
//        }
//
//        return $html;
//    }

    /**
     *
     */
    public function generate()
    {
        $raw_src_path = 'docs/raw';

        $compiled_src_path = 'docs/compiled';

        $image_copy_path = 'public/images/docs';

        $files = $this->disk()->allFiles($raw_src_path . '/img');

        foreach ($files as $raw_path) {
            $image_path = str_replace_first($raw_src_path . '/img', $image_copy_path, $raw_path);
            $this->disk()->put($image_path, $this->disk()->get($raw_path));
        }

        $files = $this->disk()->allFiles($raw_src_path);

        foreach ($files as $raw_path) {

            $compiled_path = str_replace_first($raw_src_path, $compiled_src_path, $raw_path);

            $this->disk()->put($compiled_path, $this->contents($raw_path));
        }
    }

    /**
     * @param $path
     * @return mixed|string
     */
    public function contents($path)
    {
        $contents = $this->disk()->get($path);

        foreach ((array) $this->config('vars', []) as $key => $value) {
            $contents = str_replace(sprintf('{{%s}}', $key), $value, $contents);
        }

        return $contents;
    }


}