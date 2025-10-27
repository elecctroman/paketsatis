<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\Response;
use Core\Request;
use Core\Validator;
use Core\Security;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(): Response
    {
        $services = (new Service())->all();
        $content = $this->view->render('admin.services', [
            'services' => $services,
            'csrf' => Security::csrfToken(),
        ]);
        return new Response($content);
    }

    public function store(Request $request): Response
    {
        $data = $request->all();
        $validator = new Validator($data, [
            'name' => 'required|min:3',
            'category_id' => 'required|numeric',
            'price_per_1000' => 'required|numeric'
        ]);
        if ($validator->fails() || !Security::verifyCsrf($data['_token'] ?? null)) {
            return new Response('Validation failed', 422);
        }
        (new Service())->create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => strtolower(preg_replace('/[^a-z0-9]+/i', '-', $data['name'])),
            'description' => $data['description'] ?? '',
            'min_qty' => $data['min_qty'] ?? 100,
            'max_qty' => $data['max_qty'] ?? 1000,
            'price_per_1000' => $data['price_per_1000'],
            'tier_json' => json_encode($data['tiers'] ?? []),
            'guarantee_days' => $data['guarantee_days'] ?? 0,
            'is_active' => isset($data['is_active']) ? 1 : 0,
            'provider_map_json' => json_encode([]),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return new Response('Created');
    }
}
