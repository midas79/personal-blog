<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get categories with post count
     */
    public function getCategoriesWithPostCount()
    {
        try {
            return $this->select('categories.*, COALESCE(COUNT(posts.id), 0) as post_count')
                ->join('posts', 'posts.category_id = categories.id AND posts.status = \'published\'', 'left')
                ->groupBy('categories.id, categories.name, categories.slug, categories.description, categories.created_at, categories.updated_at')
                ->orderBy('categories.name', 'ASC')
                ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error in getCategoriesWithPostCount: ' . $e->getMessage());
            // Return basic categories without post count as fallback
            return $this->orderBy('name', 'ASC')->findAll();
        }
    }

    /**
     * Get category by slug with post count
     */
    public function getCategoryBySlugWithCount($slug)
    {
        try {
            return $this->select('categories.*, COALESCE(COUNT(posts.id), 0) as post_count')
                ->join('posts', 'posts.category_id = categories.id AND posts.status = \'published\'', 'left')
                ->where('categories.slug', $slug)
                ->groupBy('categories.id, categories.name, categories.slug, categories.description, categories.created_at, categories.updated_at')
                ->first();
        } catch (\Exception $e) {
            log_message('error', 'Error in getCategoryBySlugWithCount: ' . $e->getMessage());
            // Return basic category without post count as fallback
            return $this->where('slug', $slug)->first();
        }
    }

    /**
     * Get categories for dropdown/select (simple version)
     */
    public function getCategoriesForSelect()
    {
        $categories = $this->orderBy('name', 'ASC')->findAll();
        $options = [];

        foreach ($categories as $category) {
            $options[$category['id']] = $category['name'];
        }

        return $options;
    }

    /**
     * Get category by slug (simple version)
     */
    public function getCategoryBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }
}