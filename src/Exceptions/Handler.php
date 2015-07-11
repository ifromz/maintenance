<?php

namespace Stevebauman\Maintenance\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return response()->view('maintenance::errors.404');
        } else if ($e instanceof HttpException) {
            return response()->view('maintenance::errors.403');
        }

        return parent::render($request, $e);
    }
}
