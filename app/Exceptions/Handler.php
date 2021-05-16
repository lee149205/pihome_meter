<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ValidationException){
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $errors = $exception->errors();
            $errorCode = ErrorCode::VALIDATION_ERROR;
            $errorMessage = $exception->getMessage();

            if(isset($exception->validator)){
                $failedRules = $exception->validator->failed();
                $errorCode = $errorMessage = [];

                foreach ($failedRules as $name => $types) {

                    foreach ($types as $type => $values){

                        $errorCode[] = ErrorCode::VALIDATION_ERROR.'_'.$name . '_' . strtolower($type);
                    }
                }

                $errorCode = implode(',',  $errorCode);

                foreach ($errors as $name => $messages) {

                    foreach ($messages as $message){
                        $errorMessage[] = $message;
                    }
                }

                $errorMessage = implode(',',  $errorMessage);
            }

        } else if($exception instanceof InvalidException){
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $errorCode = $exception->getErrorCode();
            $errorCode = $errorCode ?: ErrorCode::VALIDATION_ERROR;
            $errorMessage = $exception->getMessage();

        } else if($exception instanceof NotAllowException){
            $statusCode = Response::HTTP_FORBIDDEN;
            $errorCode = $exception->getErrorCode();
            $errorCode = $errorCode ?: ErrorCode::FORBIDDEN;
            $errorMessage = $exception->getMessage();

        } else if($exception instanceof NotFoundHttpException){
            $statusCode = Response::HTTP_NOT_FOUND;
            $errorCode = ErrorCode::NOT_FOUND;
            $errorMessage = $exception->getMessage();

        } else if($exception instanceof NotFoundException){
            $statusCode = Response::HTTP_NOT_FOUND;
            $errorCode = $exception->getErrorCode();
            $errorCode = $errorCode ?: ErrorCode::NOT_FOUND;
            $errorMessage = $exception->getMessage();

        } else if($exception instanceof UnauthorizedException){
            $statusCode = Response::HTTP_UNAUTHORIZED;
            $errorCode = $exception->getErrorCode();
            $errorCode = $errorCode ?: ErrorCode::ACTION_UNAUTHORIZED;
            $errorMessage = $exception->getMessage();

        } else if($exception instanceof ThirdPartyException){
            $statusCode = $exception->getCode();
            $responseData = $exception->getExtraData();

            return response()->json($responseData, $statusCode);

        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $errorCode = ErrorCode::SERVER_ERROR;
            $errorMessage = $exception->getMessage();
        }

        return response()->json([
            'success' => false,
            'errorCode' => $errorCode,
            'errorMessage' => $errorMessage
        ], $statusCode);
    }
}
