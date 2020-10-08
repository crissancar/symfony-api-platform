<?php


namespace App\Exception\Group;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class NotOwnedOfGroupException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You are not the owner of this group');
    }
}