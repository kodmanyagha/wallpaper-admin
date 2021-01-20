<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*****************
     * @var \stdClass
     */
    protected $viewData;

    public function __construct()
    {
        $this->viewData              = new \stdClass();
        $this->viewData->breadcrumbs = [];

        $this->middleware(function ($request, $next) {
            // you can access session data in here

            return $next($request);
        });
    }

    protected function addBreadcrumb($link, $title = null)
    {
        if (is_null($title)) {
            $title = $link;
            $link  = 'javascript:;';
        }

        $this->viewData->breadcrumbs[] = [
            'link'  => $link,
            'title' => $title
        ];
    }

    protected function set($key, &$data)
    {
        $this->viewData->{$key} = $data;
    }

    protected function json($data = null)
    {
        if (is_null($data))
            return response()->json($this->viewData);

        return response()->json($data);
    }

    /***************
     * @param string $view
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function view($view = null)
    {
        if (is_null($view)) {
            $class = substr(get_class($this), strlen('App\\Http\\Controllers\\'));
            $class = str_replace('\\', '.', $class);

            $view = $class . '.' . debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];
        }

        return view($view, ma($this->viewData));
    }
}
