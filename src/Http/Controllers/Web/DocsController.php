<?php

namespace Belt\Docs\Http\Controllers\Web;

use App\Services\DocService;
use Illuminate\Support\Str;

class DocsController extends Controller
{

    /**
     * @var DocService
     */
    private $service;

    /**
     * @return DocService
     */
    private function service()
    {
        return $this->service ?: $this->service = new DocService();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('docs.index');
    }

    /**
     * @param $key
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($key)
    {
        $html = $this->service()->get($key);

        if (!$html) {
            $this->abort(404);
        }

        return view('docs.show', [
            'title' => Str::title($key),
            'doc' => $html,
        ]);
    }
}
