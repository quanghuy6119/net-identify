<?php
namespace App\Utilities\Traits;

use App\Services\StatusCode;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseAPI{

    /**
     * Send responses to clients
     *
     * @param  mixed $message
     * @param  mixed $data
     * @param  mixed $statusCode
     * @param  mixed $httpStatus 
     * @param  mixed $isSuccess
     * @return JsonResponse
     */
    public function sendResponse($message, $data, $statusCode, $httpStatus , $isSuccess = true){
        if(!$message) return response()->json(['message' => 'Message is required'], 500);
        // Return success response
        if($isSuccess){
            return response()->json([
                'success' => true,
                'code' => $statusCode,
                'message' => $message,
                'data' => $data
            ], $httpStatus);
        } else {
            return response()->json([
                'success' => false,
                'code' => $statusCode,
                'message' => $message,
                'error' => $data
            ], $httpStatus);
        }
    }
        
    /**
     * Send any success response
     *
     * @param  mixed $message
     * @param  mixed $data
     * @param  mixed $statusCode
     * @param  mixed $httpStatus
     * @return JsonResponse
     */
    public function sendSuccess($message, $data, $statusCode = 200, $httpStatus = 200){
        return $this->sendResponse($message, $data, $statusCode, $httpStatus);
    }
            
    /**
     * Send a error response back to the client
     *
     * @param  mixed $message
     * @param  mixed $errors
     * @param  mixed $statusCode
     * @param  mixed $httpStatus
     * @return JsonResponse
     */
    public function sendError($message, $errors = null, $statusCode = 500, $httpStatus = 500){
        return $this->sendResponse($message, $errors, $statusCode, $httpStatus, false);
    }

    /**
     * Send any success response by status code
     *
     * @param  mixed $data
     * @param  mixed $statusCode
     * @return JsonResponse
     */
    public function sendSuccessByStatusCode($statusCode, $data = null)
    {
        // Get message and http status
        switch($statusCode)
        {
            case StatusCode::OK:
                $message = __('response.get_success');
                $httpStatus = Response::HTTP_OK;
                break;
            case StatusCode::CREATED:
                $message = __('response.create_success');
                $httpStatus = Response::HTTP_CREATED;
                break;
            case StatusCode::UPDATED:
                $message = __('response.update_success');
                $httpStatus = Response::HTTP_ACCEPTED;
                break;
            case StatusCode::DELETED:
                $message =  __('response.delete_success');
                $httpStatus = Response::HTTP_OK;
                break;
            case StatusCode::NOT_FOUND_DATA:
                $message = __('response.not_found');
                $httpStatus = Response::HTTP_OK;
                break;
        }
        // Return success
        return $this->sendSuccess($message, $data, $statusCode, $httpStatus);
    }
}