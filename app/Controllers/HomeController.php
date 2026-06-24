<?php

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        view('dashboard', [
            'title' => 'Training Center CRM Dashboard',
        ]);
    }
}