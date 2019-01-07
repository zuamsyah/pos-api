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

    /**
     * Setter Fractal
     * @param Manager $fractal
     */
    public function setFractal(Manager $fractal)
    {
        $this->fractal = $fractal;
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

    /**
     * Send Collection response
     * @param  $paginator
     * @param  $callback 
     * @return respondWithArray          
     */
    protected function respondWithCollection($paginator, $callback)
    {
        $resource = new Collection($paginator->items(), $callback);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Send Item response
     * @param  $item    
     * @param  $callback
     * @return respondWithArray 
     */
    public function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }
    
    /**
     * Send Data response
     * @param  $result 
     * @param  $message
     * @return \Illuminate\Http\JsonResponse   
     */
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

    /**
     * Send response error
     * @param  $error        
     * @param  array   $errorMessages
     * @param  integer $code         
     * @return Illuminate\Http\Response              
     */
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

    /**
     * Send response with array
     * @param  array  $array  
     * @param  array  $headers
     * @return Illuminate\Http\Response
     */
    protected function respondWithArray(array $array, array $headers = [])
    {
        return response()->json($array, $this->statusCode, $headers);
    }
}