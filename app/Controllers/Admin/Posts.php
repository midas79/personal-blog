<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;

class Posts extends BaseController
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
        // Get filter parameters
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $category = $this->request->getGet('category');

        // Build query
        $builder = $this->postModel->select('posts.*, categories.name as category_name, users.username as author_name')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->join('users', 'users.id = posts.user_id', 'left');

        // Apply filters
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

        if ($category) {
            $builder->where('posts.category_id', $category);
        }

        $posts = $builder->orderBy('posts.created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Manage Posts',
            'posts' => $posts,
            'categories' => $this->categoryModel->findAll(),
            'search' => $search,
            'status' => $status,
            'category' => $category
        ];

        return view('admin/posts/index', $data);
    }

    public function create()
    {
        // Get category from query parameter if exists
        $selectedCategory = $this->request->getGet('category');

        $data = [
            'title' => 'Create New Post',
            'categories' => $this->categoryModel->findAll(),
            'post' => null,
            'selectedCategory' => $selectedCategory
        ];

        return view('admin/posts/form', $data);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]',
            'excerpt' => 'required|min_length[10]|max_length[500]',
            'category_id' => 'required|integer',
            'status' => 'required|in_list[draft,published]',
            'featured_image' => 'if_exist|uploaded[featured_image]|max_size[featured_image,2048]|ext_in[featured_image,jpg,jpeg,png,gif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = url_title($this->request->getPost('title'), '-', true);

        // Check if slug exists
        $existingPost = $this->postModel->where('slug', $slug)->first();
        if ($existingPost) {
            $slug .= '-' . time();
        }

        // Handle file upload
        $featuredImage = null;
        $file = $this->request->getFile('featured_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $featuredImage = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $featuredImage);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $slug,
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'featured_image' => $featuredImage,
            'category_id' => $this->request->getPost('category_id'),
            'meta_description' => $this->request->getPost('meta_description'),
            'tags' => $this->request->getPost('tags'),
            'user_id' => session()->get('user_id'),
            'status' => $this->request->getPost('status'),
            'published_at' => ($this->request->getPost('status') === 'published') ? date('Y-m-d H:i:s') : null
        ];

        if ($this->postModel->insert($data)) {
            return redirect()->to('/admin/posts')->with('success', 'Post created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create post.');
        }
    }

    public function edit($id)
    {
        $post = $this->postModel->find($id);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found');
        }

        $data = [
            'title' => 'Edit Post',
            'categories' => $this->categoryModel->findAll(),
            'post' => $post
        ];

        return view('admin/posts/form', $data);
    }

    public function update($id)
    {
        $post = $this->postModel->find($id);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]',
            'excerpt' => 'required|min_length[10]|max_length[500]',
            'category_id' => 'required|integer',
            'status' => 'required|in_list[draft,published]',
            'featured_image' => 'if_exist|uploaded[featured_image]|max_size[featured_image,2048]|ext_in[featured_image,jpg,jpeg,png,gif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = url_title($this->request->getPost('title'), '-', true);

        // Check if slug exists (exclude current post)
        $existingPost = $this->postModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existingPost) {
            $slug .= '-' . time();
        }

        // Handle file upload
        $featuredImage = $post['featured_image']; // Keep existing image
        $file = $this->request->getFile('featured_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old image if exists
            if ($post['featured_image'] && file_exists(ROOTPATH . 'public/uploads/' . $post['featured_image'])) {
                unlink(ROOTPATH . 'public/uploads/' . $post['featured_image']);
            }

            $featuredImage = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $featuredImage);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $slug,
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'featured_image' => $featuredImage,
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status'),
            'published_at' => ($this->request->getPost('status') === 'published') ?
                ($post['published_at'] ?? date('Y-m-d H:i:s')) : null
        ];

        if ($this->postModel->update($id, $data)) {
            return redirect()->to('/admin/posts')->with('success', 'Post updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update post.');
        }
    }

    public function delete($id)
    {
        $post = $this->postModel->find($id);

        if (!$post) {
            return redirect()->to('/admin/posts')->with('error', 'Post not found.');
        }

        // Delete featured image if exists
        if ($post['featured_image'] && file_exists(ROOTPATH . 'public/uploads/' . $post['featured_image'])) {
            unlink(ROOTPATH . 'public/uploads/' . $post['featured_image']);
        }

        if ($this->postModel->delete($id)) {
            return redirect()->to('/admin/posts')->with('success', 'Post deleted successfully!');
        } else {
            return redirect()->to('/admin/posts')->with('error', 'Failed to delete post.');
        }
    }
}