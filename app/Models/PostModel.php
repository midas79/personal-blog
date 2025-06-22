<?php

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
}