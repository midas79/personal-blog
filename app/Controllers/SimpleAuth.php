<?php

namespace App\Controllers;

use App\Models\UserModel;

class SimpleAuth extends BaseController
{
    public function login()
    {
        // Jika sudah login, redirect ke admin
        if (session()->get('logged_in')) {
            return redirect()->to('/admin');
        }

        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Validasi input
            if (empty($email) || empty($password)) {
                return redirect()->back()->with('error', 'Email and password are required');
            }

            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                // Login berhasil - set session
                session()->set([
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'logged_in' => true
                ]);

                return redirect()->to('/admin')->with('success', 'Welcome back, ' . $user['username'] . '!');
            } else {
                return redirect()->back()->with('error', 'Invalid email or password');
            }
        }

        // Tampilkan form login
        return view('simple_login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'You have been logged out successfully');
    }
}