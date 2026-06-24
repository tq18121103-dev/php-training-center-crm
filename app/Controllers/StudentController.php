<?php

namespace App\Controllers;

use App\Core\DuplicateRecordException;
use App\Repositories\StudentRepository;

class StudentController
{
    private StudentRepository $repository;

    public function __construct()
    {
        $this->repository = new StudentRepository();
    }

    public function index(): void
    {
        $keyword = trim($_GET['keyword'] ?? '');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $students = $this->repository->paginate($keyword, $limit, $offset);
        $total = $this->repository->count($keyword);
        $totalPages = max(1, (int) ceil($total / $limit));

        view('students/index', [
            'students' => $students,
            'keyword' => $keyword,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public function create(): void
    {
        view('students/create', [
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function store(): void
    {
        $data = [
            'student_code' => trim($_POST['student_code'] ?? ''),
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'course' => trim($_POST['course'] ?? ''),
            'status' => trim($_POST['status'] ?? ''),
        ];

        $errors = $this->validate($data);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;

            redirect('/students/create');
        }

        try {
            $this->repository->create($data);

            flash_set('success', 'Student created successfully.');

            redirect('/students');
        } catch (DuplicateRecordException $e) {
            $_SESSION['errors'] = [
                'email' => $e->getMessage(),
            ];

            $_SESSION['old'] = $data;

            redirect('/students/create');
        }
    }


    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $student = $this->repository->find($id);

        if (!$student) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        view('students/edit', [
            'student' => $student,
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'student_code' => trim($_POST['student_code'] ?? ''),
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'course' => trim($_POST['course'] ?? ''),
            'status' => trim($_POST['status'] ?? ''),
        ];

        $errors = $this->validate($data);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;

            redirect('/students/edit?id=' . $id);
        }

        try {
            $this->repository->update($id, $data);

            flash_set('success', 'Student updated successfully.');

            redirect('/students');
        } catch (DuplicateRecordException $e) {
            $_SESSION['errors'] = [
                'email' => $e->getMessage(),
            ];

            $_SESSION['old'] = $data;

            redirect('/students/edit?id=' . $id);
        }
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $this->repository->delete($id);

        flash_set('success', 'Student deleted successfully.');

        redirect('/students');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['student_code'] === '') {
            $errors['student_code'] = 'Student code is required';
        }

        if ($data['full_name'] === '') {
            $errors['full_name'] = 'Name is required';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email';
        }

        if ($data['phone'] === '') {
            $errors['phone'] = 'Phone is required';
        }

        if ($data['course'] === '') {
            $errors['course'] = 'Course is required';
        }

        $allowedStatuses = ['new', 'contacted', 'enrolled'];

        if ($data['status'] === '') {
            $errors['status'] = 'Status is required';
        } elseif (!in_array($data['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Invalid status';
        }

        return $errors;
    }
}