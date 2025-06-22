<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Blog extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Blog listing page
     */
    public function index()
    {
        // Get parameters
        $search = $this->request->getGet('search');
        $categorySlug = $this->request->getGet('category');
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 6;

        // Build base query
        $postModel = new PostModel();
        $builder = $postModel->builder();

        $builder->select('posts.*, categories.name as category_name, categories.slug as category_slug, users.username as author_name')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->where('posts.status', 'published')
            ->orderBy('posts.published_at', 'DESC');

        // Apply filters
        if ($search) {
            $builder->groupStart()
                ->like('posts.title', $search)
                ->orLike('posts.content', $search)
                ->orLike('posts.excerpt', $search)
                ->groupEnd();
        }

        if ($categorySlug) {
            $builder->where('categories.slug', $categorySlug);
        }

        // Get total count
        $totalPosts = $builder->countAllResults(false);

        // Calculate pagination
        $totalPages = ceil($totalPosts / $perPage);
        $offset = ($page - 1) * $perPage;

        // Get posts for current page
        $posts = $builder->limit($perPage, $offset)->get()->getResultArray();

        // Create manual pagination data
        $pagination = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,
            'perPage' => $perPage,
            'hasNext' => $page < $totalPages,
            'hasPrevious' => $page > 1,
            'nextPage' => $page < $totalPages ? $page + 1 : null,
            'previousPage' => $page > 1 ? $page - 1 : null,
            'firstPage' => 1,
            'lastPage' => $totalPages
        ];

        // Get categories for sidebar
        $categories = $this->categoryModel->getCategoriesWithPostCount();

        // Get selected category info
        $selectedCategory = null;
        if ($categorySlug) {
            $selectedCategory = $this->categoryModel->getCategoryBySlugWithCount($categorySlug);
        }

        // Get recent posts for sidebar
        $recentPosts = $this->postModel->select('posts.title, posts.slug, posts.published_at, posts.featured_image')
            ->where('posts.status', 'published')
            ->orderBy('posts.published_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'title' => $selectedCategory ? 'Category: ' . $selectedCategory['name'] : 'Blog',
            'posts' => $posts,
            'categories' => $categories,
            'recentPosts' => $recentPosts,
            'selectedCategory' => $selectedCategory,
            'search' => $search,
            'pagination' => $pagination
        ];

        return view('blog/index', $data);
    }

    /**
     * Category page
     */
    public function category($slug)
    {
        $category = $this->categoryModel->getCategoryBySlugWithCount($slug);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 6;

        // Build query
        $postModel = new PostModel();
        $builder = $postModel->builder();

        $builder->select('posts.*, categories.name as category_name, categories.slug as category_slug, users.username as author_name')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->where('posts.category_id', $category['id'])
            ->where('posts.status', 'published')
            ->orderBy('posts.published_at', 'DESC');

        // Get total count
        $totalPosts = $builder->countAllResults(false);

        // Calculate pagination
        $totalPages = ceil($totalPosts / $perPage);
        $offset = ($page - 1) * $perPage;

        // Get posts for current page
        $posts = $builder->limit($perPage, $offset)->get()->getResultArray();

        // Create manual pagination data
        $pagination = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,
            'perPage' => $perPage,
            'hasNext' => $page < $totalPages,
            'hasPrevious' => $page > 1,
            'nextPage' => $page < $totalPages ? $page + 1 : null,
            'previousPage' => $page > 1 ? $page - 1 : null,
            'firstPage' => 1,
            'lastPage' => $totalPages
        ];

        // Get categories for sidebar
        $categories = $this->categoryModel->getCategoriesWithPostCount();

        // Get recent posts for sidebar
        $recentPosts = $this->postModel->select('posts.title, posts.slug, posts.published_at, posts.featured_image')
            ->where('posts.status', 'published')
            ->orderBy('posts.published_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'title' => 'Category: ' . $category['name'],
            'category' => $category,
            'posts' => $posts,
            'categories' => $categories,
            'recentPosts' => $recentPosts,
            'pagination' => $pagination
        ];

        return view('blog/category', $data);
    }

    /**
     * Single post page
     */
    public function post($slug)
    {
        $post = $this->postModel->getPostBySlug($slug);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found');
        }

        // Get related posts (same category, excluding current post)
        $relatedPosts = [];
        if ($post['category_id']) {
            $relatedPosts = $this->postModel->select('posts.*, users.username as author_name')
                ->join('users', 'users.id = posts.user_id', 'left')
                ->where('posts.category_id', $post['category_id'])
                ->where('posts.id !=', $post['id'])
                ->where('posts.status', 'published')
                ->orderBy('posts.published_at', 'DESC')
                ->limit(3)
                ->findAll();
        }

        // Get categories for sidebar
        $categories = $this->categoryModel->getCategoriesWithPostCount();

        // Get recent posts for sidebar
        $recentPosts = $this->postModel->select('posts.title, posts.slug, posts.published_at, posts.featured_image')
            ->where('posts.status', 'published')
            ->where('posts.id !=', $post['id'])
            ->orderBy('posts.published_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'title' => $post['title'],
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'categories' => $categories,
            'recentPosts' => $recentPosts
        ];

        return view('blog/post', $data);
    }

    /**
     * Search posts
     */
    public function search()
    {
        $search = $this->request->getGet('q');

        if (!$search) {
            return redirect()->to('blog');
        }

        return redirect()->to('blog?search=' . urlencode($search));
    }
}