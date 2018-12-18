<?php 

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

trait ResponseTrait
{
    protected $statusCode = 200;
    
     /**
     * Fractal manager instance
     *
     * @var Manager
     */
    protected $fractal;

    public function setFractal(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Getter for statusCode
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter for statusCode
     *
     * @param int $statusCode Value to set
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Send custom data response
     *
     * @param $status
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCustomResponse($status, $message)
    {
        return response()->json(['status' => $status, 'message' => $message], $status);
    }

    protected function respondWithCollection($paginator, $callback)
    {
        $resource = new Collection($paginator->items(), $callback);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    public function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }
    
    public function sendData($result, $message)
    {
      $response = [
        'success' => true,
        'data' => $result,
        'message' => $message
      ];

      return response()->json($response, 201);
    }

    /**
     * success response method.
     *
     * @return Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
      $response = [
        'success' => true,
        'data' => $result,
        'message' => $message
      ];

      return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
      $response = [
        'success' => false,
        'message' => $error
      ];

      if (!empty($errorMessages)) {
        $response['data'] = $errorMessages;
      }

      return response()->json($response, $code);
    }

    protected function respondWithArray(array $array, array $headers = [])
    {
        return response()->json($array, $this->statusCode, $headers);
    }
}