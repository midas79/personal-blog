<?php
// app/Models/PostModel.php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'content', 'excerpt', 'featured_image', 'category_id', 'user_id', 'status', 'published_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPublishedPosts($limit = 10)
    {
        return $this->select('posts.*, categories.name as category_name, users.full_name as author_name')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->where('posts.status', 'published')
            ->orderBy('posts.published_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getPostBySlug($slug)
    {
        return $this->select('posts.*, categories.name as category_name, users.full_name as author_name')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->where('posts.slug', $slug)
            ->where('posts.status', 'published')
            ->first();
    }

    /**
     * Get recent posts for dashboard
     */
    public function getRecentPostsForDashboard($limit = 5)
    {
        try {
            return $this->select('
                posts.id,
                posts.title,
                posts.slug,
                posts.status,
                posts.created_at,
                categories.name as category_name,
                users.username as author_name
            ')
                ->join('categories', 'categories.id = posts.category_id', 'left')
                ->join('users', 'users.id = posts.user_id', 'left')
                ->orderBy('posts.created_at', 'DESC')
                ->limit($limit)
                ->findAll();

        } catch (\Exception $e) {
            log_message('error', 'Error in getRecentPostsForDashboard: ' . $e->getMessage());

            // Fallback tanpa JOIN
            return $this->select('id, title, slug, status, created_at')
                ->orderBy('created_at', 'DESC')
                ->limit($limit)
                ->findAll();
        }
    }

    /**
     * Get all posts with details for admin
     */
    public function getAllPostsWithDetails($search = null, $status = null, $categoryId = null)
    {
        $builder = $this->select('
            posts.id,
            posts.title,
            posts.slug,
            posts.content,
            posts.excerpt,
            posts.featured_image,
            posts.status,
            posts.created_at,
            posts.updated_at,
            categories.name as category_name,
            users.username as author_name
        ')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('posts.title', $search)
                ->orLike('posts.content', $search)
                ->orLike('posts.excerpt', $search)
                ->groupEnd();
        }

        if ($status) {
            $builder->where('posts.status', $status);
        }

        if ($categoryId) {
            $builder->where('posts.category_id', $categoryId);
        }

        return $builder->orderBy('posts.created_at', 'DESC')->findAll();
    }

    /**
     * Get posts by category
     */
    public function getPostsByCategory($categoryId, $limit = 10)
    {
        return $this->select('posts.*, categories.name as category_name, users.full_name as author_name')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->where('posts.category_id', $categoryId)
            ->where('posts.status', 'published')
            ->orderBy('posts.published_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}