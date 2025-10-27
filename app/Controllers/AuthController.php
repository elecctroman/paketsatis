<?php

namespace App\Controllers;

use Core\Controller;
use Core\Response;
use Core\Request;
use Core\Validator;
use Core\Security;
use Core\Auth;
use Core\Session;

class AuthController extends Controller
{
    public function showLogin(): Response
    {
        $content = $this->view->render('public.login', [
            'csrf' => Security::csrfToken(),
            'errors' => Session::getFlash('errors', [])
        ]);
        return new Response($content);
    }

    public function login(Request $request): Response
    {
        $data = $request->all();
        $validator = new Validator($data, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails() || !Security::verifyCsrf($data['_token'] ?? null)) {
            Session::flash('errors', ['Invalid credentials']);
            return new Response('Invalid', 422);
        }
        if (Auth::attempt($data['email'], $data['password'])) {
            return new Response('OK');
        }
        Session::flash('errors', ['Login failed']);
        return new Response('Unauthorized', 401);
    }

    public function logout(): Response
    {
        Auth::logout();
        return new Response('Logged out');
    }
}
