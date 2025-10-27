<?php

namespace App\Controllers\Frontend;

use Core\Controller;
use Core\Response;
use App\Models\Category;
use App\Models\Service;
use Core\Security;

class HomeController extends Controller
{
    public function index(): Response
    {
        $categories = (new Category())->all();
        $services = (new Service())->all();
        $content = $this->view->render('public.home', [
            'categories' => $categories,
            'services' => $services,
            'csrf' => Security::csrfToken(),
        ]);
        return new Response($content);
    }
}
