<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // parse html from response
        $exceptionHtml = $this->render(null, $exception)->getContent();
        Mail::to('menchuxoyon@gmail.com')->send(new \App\ExceptionOccured($exceptionHtml));
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        // if($this->isHttpException($exception))
        // {
        //     return $this->renderHttpException($exception);
        // }
        // Check exception rendering - if env is production, we don't want to show exception, so we send errors/500.blade.php view
        //else 
        if ($request != null) {
            if ($exception instanceof \ErrorException) {
                return response('Fatal Error!', 500);
            } else {
                return response()->view('errors.500', [], 500);
            }
        }
        else
        {
            return parent::render($request, $exception);
        }
    }
}
