<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        try {
            // Get latest published posts for homepage
            $posts = [];
            try {
                $posts = $this->postModel->getPublishedPosts(6);
            } catch (\Exception $e) {
                log_message('error', 'Error getting published posts: ' . $e->getMessage());
                // Fallback to basic posts
                try {
                    $posts = $this->postModel
                        ->where('status', 'published')
                        ->orderBy('created_at', 'DESC')
                        ->limit(6)
                        ->findAll();
                } catch (\Exception $e2) {
                    log_message('error', 'Error getting basic posts: ' . $e2->getMessage());
                    $posts = [];
                }
            }

            // Get categories with post count
            $categories = [];
            try {
                $categories = $this->categoryModel->getCategoriesWithPostCount();
            } catch (\Exception $e) {
                log_message('error', 'Error getting categories with post count: ' . $e->getMessage());
                // Fallback to basic categories
                try {
                    $categories = $this->categoryModel->findAll();
                    // Add post_count = 0 for each category
                    foreach ($categories as &$category) {
                        $category['post_count'] = 0;
                    }
                } catch (\Exception $e2) {
                    log_message('error', 'Error getting basic categories: ' . $e2->getMessage());
                    $categories = [];
                }
            }

            // Get some stats for homepage
            $stats = [
                'totalPosts' => 0,
                'totalCategories' => 0
            ];

            try {
                $stats['totalPosts'] = $this->postModel->where('status', 'published')->countAllResults(false);
                $stats['totalCategories'] = $this->categoryModel->countAll();
            } catch (\Exception $e) {
                log_message('error', 'Error getting stats: ' . $e->getMessage());
            }

            $data = [
                'title' => 'Welcome to My Personal Blog',
                'posts' => $posts,
                'categories' => $categories,
                'stats' => $stats
            ];

            return view('home', $data);

        } catch (\Exception $e) {
            log_message('error', 'Home controller error: ' . $e->getMessage());

            // Return minimal home page
            $data = [
                'title' => 'Welcome to My Personal Blog',
                'posts' => [],
                'categories' => [],
                'stats' => ['totalPosts' => 0, 'totalCategories' => 0]
            ];

            return view('home', $data);
        }
    }

    public function about()
    {
        $data = [
            'title' => 'About - Dionisius Surya Jaya'
        ];

        return view('about', $data);
    }
}