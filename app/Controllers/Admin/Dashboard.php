<?php
// app/Controllers/Admin/Dashboard.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $postModel;
    protected $categoryModel;
    protected $userModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        try {
            // Get user data from session
            $userData = [
                'id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'email' => session()->get('email'),
                'full_name' => session()->get('full_name')
            ];

            // Dashboard statistics with error handling
            $totalPosts = 0;
            $publishedPosts = 0;
            $draftPosts = 0;
            $totalCategories = 0;
            $recentPosts = [];

            try {
                $totalPosts = $this->postModel->countAll();
                $publishedPosts = $this->postModel->where('status', 'published')->countAllResults(false);
                $draftPosts = $this->postModel->where('status', 'draft')->countAllResults(false);
                $totalCategories = $this->categoryModel->countAll();
            } catch (\Exception $e) {
                log_message('error', 'Error getting dashboard stats: ' . $e->getMessage());
            }

            // Get recent posts with multiple fallback strategies
            try {
                // First attempt: Try with joins
                $recentPosts = $this->postModel
                    ->select('
                        posts.id,
                        posts.title,
                        posts.slug,
                        posts.content,
                        posts.excerpt,
                        posts.status,
                        posts.created_at,
                        posts.updated_at,
                        categories.name as category_name,
                        users.username as author_name
                    ')
                    ->join('categories', 'categories.id = posts.category_id', 'left')
                    ->join('users', 'users.id = posts.user_id', 'left')
                    ->orderBy('posts.created_at', 'DESC')
                    ->limit(5)
                    ->findAll();

                // If no results with joins, try without joins
                if (empty($recentPosts)) {
                    $recentPosts = $this->postModel
                        ->select('id, title, slug, status, created_at')
                        ->orderBy('created_at', 'DESC')
                        ->limit(5)
                        ->findAll();
                }

            } catch (\Exception $e) {
                log_message('error', 'Error getting recent posts: ' . $e->getMessage());

                // Final fallback - basic query
                try {
                    $recentPosts = $this->postModel
                        ->orderBy('created_at', 'DESC')
                        ->limit(5)
                        ->findAll();
                } catch (\Exception $e2) {
                    log_message('error', 'Error getting basic posts: ' . $e2->getMessage());
                    $recentPosts = [];
                }
            }

            $data = [
                'title' => 'Admin Dashboard',
                'totalPosts' => $totalPosts,
                'publishedPosts' => $publishedPosts,
                'draftPosts' => $draftPosts,
                'totalCategories' => $totalCategories,
                'recentPosts' => $recentPosts,
                'user' => (object) $userData
            ];

            return view('admin/dashboard', $data);

        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());

            // Return basic dashboard with minimal data
            $data = [
                'title' => 'Admin Dashboard',
                'totalPosts' => 0,
                'publishedPosts' => 0,
                'draftPosts' => 0,
                'totalCategories' => 0,
                'recentPosts' => [],
                'user' => (object) [
                    'username' => session()->get('username') ?? 'Admin',
                    'email' => session()->get('email') ?? 'admin@example.com'
                ]
            ];

            return view('admin/dashboard', $data);
        }
    }
}