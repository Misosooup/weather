<?php

namespace App\Exceptions;

use App\Response\ApiResponse;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
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
        'current_password',
        'password',
        'password_confirmation',
    ];
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Container $container, LoggerInterface $logger)
    {
        parent::__construct($container);
        $this->logger = $logger;
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param Request $request
     * @param Throwable $e
     */
    public function render($request, Throwable $e)
    {
        $this->logger->log(LogLevel::ERROR, $e->getMessage());
        $this->logger->log(LogLevel::ERROR, $e->getTraceAsString());

        return ApiResponse::generateErrorResponse($e->getMessage(), $e->getCode(), $e->getTrace());
    }
}
