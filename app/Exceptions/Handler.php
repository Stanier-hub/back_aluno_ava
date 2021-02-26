<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Exception;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        
    }

    //Seguir https://github.com/spatie/laravel-permission/tree/master/src/Exceptions
    public function render($request, Throwable $exception)
    {

        if($request->is("api/*")){

            if ($exception instanceof ValidationException) {
                return response()->json($exception->errors(),$exception->status);
            }

             if ($exception instanceof \Illuminate\Database\QueryException) {
                return response()->json($exception,"404");
            }

            if ($exception instanceof \Spatie\Permission\Exceptions\PermissionDoesNotExist) {
                return response()->json('Permissao nao existe.',406);
            }

            if ($exception instanceof \Spatie\Permission\Exceptions\PermissionAlreadyExists) {
                return response()->json('Permissao ja existe.',406);
            }

            if ($exception instanceof \Spatie\Permission\Exceptions\RoleAlreadyExists) {
                return response()->json('Papel ja existe.',406);
            }

            if ($exception instanceof \Spatie\Permission\Exceptions\RoleDoesNotExist) {
                return response()->json('Papel nao existe.',406);
            } 
        }



        return parent::render($request, $exception);
    }
   
}
