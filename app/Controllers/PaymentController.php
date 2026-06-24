<?php

namespace App\Controllers;

use App\Core\DuplicateRecordException;
use App\Repositories\PaymentRepository;

class PaymentController
{
    private PaymentRepository $repository;

    public function __construct()
    {
        $this->repository = new PaymentRepository();
    }

    public function index(): void
    {
        $keyword = trim($_GET['keyword'] ?? '');

        if ($keyword !== '') {
            $payments = $this->repository->search($keyword);
        } else {
            $payments = $this->repository->all();
        }

        view('payments/index', [
            'payments' => $payments,
            'keyword' => $keyword,
        ]);
    }

    public function create(): void
    {
        view('payments/create', [
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function store(): void
    {
        $data = [
            'payment_code' => trim($_POST['payment_code'] ?? ''),
            'student_email' => trim($_POST['student_email'] ?? ''),
            'amount' => trim($_POST['amount'] ?? ''),
            'payment_status' => trim($_POST['payment_status'] ?? ''),
        ];

        $errors = $this->validate($data);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;

            redirect('/payments/create');
        }

        try {
            $this->repository->create($data);

            flash_set('success', 'Payment created successfully.');

            redirect('/payments');
        } catch (DuplicateRecordException $e) {
            $_SESSION['errors'] = [
                'payment_code' => $e->getMessage(),
            ];

            $_SESSION['old'] = $data;

            redirect('/payments/create');
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $payment = $this->repository->find($id);

        if (!$payment) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        view('payments/edit', [
            'payment' => $payment,
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'payment_code' => trim($_POST['payment_code'] ?? ''),
            'student_email' => trim($_POST['student_email'] ?? ''),
            'amount' => trim($_POST['amount'] ?? ''),
            'payment_status' => trim($_POST['payment_status'] ?? ''),
        ];

        $errors = $this->validate($data);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;

            redirect('/payments/edit?id=' . $id);
        }

        try {
            $this->repository->update($id, $data);

            flash_set('success', 'Payment updated successfully.');

            redirect('/payments');
        } catch (DuplicateRecordException $e) {
            $_SESSION['errors'] = [
                'payment_code' => $e->getMessage(),
            ];

            $_SESSION['old'] = $data;

            redirect('/payments/edit?id=' . $id);
        }
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $this->repository->delete($id);

        flash_set('success', 'Payment deleted successfully.');

        redirect('/payments');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['payment_code'] === '') {
            $errors['payment_code'] = 'Payment code is required';
        }

        if (!filter_var($data['student_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['student_email'] = 'Invalid student email';
        }

        if ($data['amount'] === '' || !is_numeric($data['amount']) || (float) $data['amount'] <= 0) {
            $errors['amount'] = 'Amount must be greater than 0';
        }

        $allowedStatuses = ['pending', 'paid', 'cancelled'];

        if ($data['payment_status'] === '') {
            $errors['payment_status'] = 'Payment status is required';
        } elseif (!in_array($data['payment_status'], $allowedStatuses, true)) {
            $errors['payment_status'] = 'Invalid payment status';
        }

        return $errors;
    }
}