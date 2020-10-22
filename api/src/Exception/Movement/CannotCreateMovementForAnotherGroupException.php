<?php


namespace App\Exception\Movement;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateMovementForAnotherGroupException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You can not create movements for another group');
    }
}