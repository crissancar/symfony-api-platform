<?php


namespace App\Exception\Group;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateGroupForAnotherUserException extends AccessDeniedHttpException
{
    public function __construct()
    {
         parent::__construct('You can not create groups fot another user');
    }
}