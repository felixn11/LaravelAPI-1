<?php
namespace App\Http\Controllers;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller{

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not found!'){
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithInternalError($message = 'Internal Error'){
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message = 'Not Found!'){

       return $this->respond([
           'error' => [
               'message' => $message,
               'status_code' => $this->getStatusCode()
           ]
       ]);
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {

        \Log::info('This is some useful information.');
        \Log::info($data);
        \Log::info($headers);
        return response()->json($data, $this->getStatusCode(), $headers);
    }
}