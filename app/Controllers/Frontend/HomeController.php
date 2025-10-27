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
        $categories = (new Category())->active();
        $services = (new Service())->featured(6);
        $content = $this->view->render('public.home', [
            'title' => 'PaketSatis - Sosyal Medya Hizmetleri',
            'categories' => $categories,
            'services' => $services,
            'csrf' => Security::csrfToken(),
        ]);
        return new Response($content);
    }
}
