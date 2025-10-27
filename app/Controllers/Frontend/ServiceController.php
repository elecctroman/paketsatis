<?php

namespace App\Controllers\Frontend;

use Core\Controller;
use Core\Response;
use Core\Request;
use App\Models\Service;
use App\Models\Category;
use Core\Security;

class ServiceController extends Controller
{
    public function category(Request $request): Response
    {
        $slug = (string) $request->route('slug');
        $category = (new Category())->findBySlug($slug);
        if (!$category || (int) ($category['is_active'] ?? 0) !== 1) {
            return new Response($this->view->render('errors.404'), 404);
        }
        $services = (new Service())->forCategory((int) $category['id']);
        $content = $this->view->render('public.category', [
            'title' => $category['name'] . ' Hizmetleri',
            'category' => $category,
            'services' => $services,
        ]);
        return new Response($content);
    }

    public function show(Request $request): Response
    {
        $slug = (string) $request->route('slug');
        $service = (new Service())->findBySlug($slug);
        if (!$service || (int) ($service['is_active'] ?? 0) !== 1) {
            return new Response($this->view->render('errors.404'), 404);
        }
        $tiers = [];
        if (!empty($service['tier_json'])) {
            $decoded = json_decode($service['tier_json'], true);
            if (is_array($decoded)) {
                $tiers = $decoded['tiers'] ?? [];
            }
        }
        $content = $this->view->render('public.service', [
            'title' => $service['name'],
            'service' => $service,
            'tiers' => $tiers,
            'csrf' => Security::csrfToken(),
        ]);
        return new Response($content);
    }
}
