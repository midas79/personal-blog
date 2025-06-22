<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\PostModel;

class Categories extends BaseController
{
    protected $categoryModel;
    protected $postModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->postModel = new PostModel();
    }

    public function index()
    {
        // Get search parameter
        $search = $this->request->getGet('search');

        // Build query
        $builder = $this->categoryModel->select('categories.*, COUNT(posts.id) as post_count')
            ->join('posts', 'posts.category_id = categories.id', 'left')
            ->groupBy('categories.id');

        // Apply search filter
        if ($search) {
            $builder->like('categories.name', $search)
                ->orLike('categories.description', $search);
        }

        $categories = $builder->orderBy('categories.created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Categories Management',
            'categories' => $categories,
            'search' => $search
        ];

        return view('admin/categories/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Category',
            'category' => null
        ];

        return view('admin/categories/form', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]|is_unique[categories.name]',
            'description' => 'permit_empty|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = url_title($this->request->getPost('name'), '-', true);

        // Check if slug exists
        $existingCategory = $this->categoryModel->where('slug', $slug)->first();
        if ($existingCategory) {
            $slug .= '-' . time();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $slug,
            'description' => $this->request->getPost('description')
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/categories')->with('success', 'Category created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create category.');
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $data = [
            'title' => 'Edit Category',
            'category' => $category
        ];

        return view('admin/categories/form', $data);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $rules = [
            'name' => "required|min_length[2]|max_length[100]|is_unique[categories.name,id,{$id}]",
            'description' => 'permit_empty|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = url_title($this->request->getPost('name'), '-', true);

        // Check if slug exists (exclude current category)
        $existingCategory = $this->categoryModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existingCategory) {
            $slug .= '-' . time();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $slug,
            'description' => $this->request->getPost('description')
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/categories')->with('success', 'Category updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update category.');
        }
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found.');
        }

        // Check if category has posts
        $postCount = $this->postModel->where('category_id', $id)->countAllResults();

        if ($postCount > 0) {
            return redirect()->to('/admin/categories')
                ->with('error', "Cannot delete category '{$category['name']}' because it has {$postCount} post(s). Please move or delete the posts first.");
        }

        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/categories')->with('success', 'Category deleted successfully!');
        } else {
            return redirect()->to('/admin/categories')->with('error', 'Failed to delete category.');
        }
    }

    public function show($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        // Get posts in this category
        $posts = $this->postModel->select('posts.*, users.username as author_name')
            ->join('users', 'users.id = posts.user_id', 'left')
            ->where('posts.category_id', $id)
            ->orderBy('posts.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Category: ' . $category['name'],
            'category' => $category,
            'posts' => $posts
        ];

        return view('admin/categories/show', $data);
    }
}