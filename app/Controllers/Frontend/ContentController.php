<?php

namespace App\Controllers\Frontend;

use Core\Controller;
use Core\Response;
use Core\Request;
use App\Models\Content;
use Core\Security;

class ContentController extends Controller
{
    public function blogIndex(): Response
    {
        $posts = (new Content())->latestByType('blog', 12);
        $content = $this->view->render('public.blog_index', [
            'title' => 'Blog',
            'posts' => $posts,
        ]);
        return new Response($content);
    }

    public function blogShow(Request $request): Response
    {
        $slug = (string) $request->route('slug');
        $post = (new Content())->findBySlug($slug);
        if (!$post || $post['type'] !== 'blog') {
            return new Response($this->view->render('errors.404'), 404);
        }
        $content = $this->view->render('public.blog_show', [
            'title' => $post['title'],
            'post' => $post,
            'body' => Security::sanitizeHtml($post['body_html'] ?? ''),
        ]);
        return new Response($content);
    }

    public function page(Request $request): Response
    {
        $slug = (string) $request->route('slug');
        $page = (new Content())->findBySlug($slug);
        if (!$page || $page['type'] !== 'page') {
            return new Response($this->view->render('errors.404'), 404);
        }
        $content = $this->view->render('public.page', [
            'title' => $page['title'],
            'page' => $page,
            'body' => Security::sanitizeHtml($page['body_html'] ?? ''),
        ]);
        return new Response($content);
    }
}
