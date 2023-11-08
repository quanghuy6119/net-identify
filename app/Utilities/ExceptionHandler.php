<?php
namespace App\Utilities;

use App\Domain\Exceptions\AdapterException;
use App\Domain\Exceptions\AlreadyExistedException;
use App\Domain\Exceptions\ArgumentNullException;
use App\Domain\Exceptions\ConflictException;
use App\Domain\Exceptions\HttpClientException;
use App\Domain\Exceptions\InvalidInputException;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Exceptions\SerializerException;
use App\Domain\Exceptions\UploadFailException;
use App\Services\StatusCode;
use App\Utilities\Traits\ResponseAPI;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ExceptionHandler{

    use ResponseAPI;

    private static $instance;

    private static function getInstance() 
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Handle invalid input exception
     *
     * @param InvalidInputException $exception
     * @return \Illuminate\Http\Response
     */
    public static function invalidInput(InvalidInputException $exception) 
    {
        $instance = self::getInstance();

        return $instance->sendError(__('response.inputs_invalid'), $exception->getError(), StatusCode::INVALID_INPUT, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Handle null argument exception
     *
     * @param ArgumentNullException $exception
     * @return \Illuminate\Http\Response
     */
    public static function argumentNull(ArgumentNullException $exception) 
    {
        $instance = self::getInstance();

        return $instance->sendError($exception->getMessage(), null, StatusCode::ARGUMENT_NULL, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Handle server errors exception
     *
     * @param Exception $message
     * @return \Illuminate\Http\Response
     */
    public static function serverError(Exception $exception)
    {
        $instance = self::getInstance();

        return $instance->sendError($exception->getMessage(), null, StatusCode::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Conflict exception
     *
     * @param ConflictException $exception
     * @return \Illuminate\Http\Response
     */
    public static function conflict(ConflictException $exception)
    {
        $instance = self::getInstance();

        return $instance->sendError($exception->getMessage(), $exception->getError(), $exception->getStatusCode(), Response::HTTP_CONFLICT);
    }

    /**
     * Handle serializer error exception
     *
     * @return \Illuminate\Http\Response
     */
    public static function serializeError(SerializerException $ex)
    {
        $instance = self::getInstance();

        return $instance->sendError(
            $ex->getMessage(), 
            $ex->getPrevious(), 
            $ex->getCode(), 
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Handle not found data exception
     *
     * @return \Illuminate\Http\Response
     */
    public static function notFound(NotFoundException $ex)
    {
        $instance = self::getInstance();

        return $instance->sendError($ex->getMessage(), null, $ex->getStatusCode(), Response::HTTP_NOT_FOUND);
    }
    
    /**
     * Handle database exception
     *
     * @return \Illuminate\Http\Response
     */
    public static function databaseError(Exception $exception)
    {
        $instance = self::getInstance();

        return $instance->sendError(
            __('response.server_error'), 
            ['details' => [$exception->getMessage()]], 
            StatusCode::DATABASE_EXCEPTION_ERROR, 
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Handle record existed exception
     *
     * @return \Illuminate\Http\Response
     */
    public static function recordExisted(AlreadyExistedException $ex)
    {
        $instance = self::getInstance();

        return $instance->sendError(
            $ex->getMessage(), 
            $ex->getError(), 
            $ex->getStatusCode(), 
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * Handle http client exception
     *
     * @return \Illuminate\Http\Response
     */
    public static function httpClientError(HttpClientException $ex)
    {
        $instance = self::getInstance();

        return $instance->sendError($ex->getMessage(), $ex->getError(), $ex->getStatusCode(), $ex->getHttpStatus());
    }

    /**
     * Handle upload file failed exception
     *
     * @return \Illuminate\Http\Response
     */
    public static function uploadFileFailed(UploadFailException $ex)
    {
        $instance = self::getInstance();

        return $instance->sendError(
            $ex->getMessage(), 
            null, 
            StatusCode::FAILED_TO_UPLOAD,
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Handle convert exception
     *
     * @return \Illuminate\Http\Response
     */
    public static function convertError(AdapterException $ex)
    {
        $instance = self::getInstance();

        return $instance->sendError(
            $ex->getMessage(), 
            $ex->getPrevious(), 
            $ex->getCode(), 
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}