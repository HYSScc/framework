<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction()
    {
        return $this->render('index.php');
    }

    public function loginAction()
    {
        return new Response('<h1>Login</h1>');
    }

    public function registerAction(Request $request)
    {
        return new Response('<h1>Register</h1>');
    }
}
