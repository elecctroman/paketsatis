<?php

namespace Core;

abstract class Controller
{
    protected Request $request;
    protected Response $response;
    protected View $view;

    public function __construct(Request $request, Response $response, View $view)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
    }
}
