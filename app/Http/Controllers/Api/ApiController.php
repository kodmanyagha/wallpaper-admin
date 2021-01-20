<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*****************
     * @var \stdClass
     */
    protected $returnData;
    protected $prettyPrint;

    public function __construct()
    {
        $this->returnData       = new \stdClass();
        $this->returnData->data = new \stdClass();

        if (env('APP_ENV') == 'local')
            $this->prettyPrint = true;
    }

    protected function set($key, $data, $parent = false)
    {
        if ($parent === true)
            $this->returnData->{$key} = $data;
        else
            $this->returnData->data->{$key} = $data;
    }

    protected function setData($data)
    {
        $this->returnData->data = $data;
    }

    protected function success($data = null)
    {
        $this->returnData->status = 'success';

        if (!is_null($data))
            $this->returnData->data = $data;

        return $this->printJson();
    }

    protected function error($errorMessages = null, $data = null)
    {
        $this->returnData->status = 'error';

        if (!is_null($data))
            $this->returnData->data = $data;

        $this->returnData->errorMessages = $errorMessages;

        return $this->printJson();
    }

    protected function printJson()
    {
        $eol = $this->prettyPrint ? PHP_EOL : "";
        return response(o2s($this->returnData, $this->prettyPrint) . $eol, 200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    /***
     * @param int $recordsFiltered
     * @param int $recordsTotal
     * @param array|object|null $data
     * @param int $draw
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function dt($recordsFiltered, $recordsTotal, $data, $draw = 1)
    {
        $this->returnData->recordsFiltered = $recordsFiltered;
        $this->returnData->recordsTotal    = $recordsTotal;
        $this->returnData->data            = $data;

        if ($draw > 0)
            $this->returnData->draw = $draw;

        return $this->printJson();
    }
}
