<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\DuplicateRecordException;
use PDO;
use PDOException;

class PaymentRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("
            SELECT *
            FROM payments
            ORDER BY id DESC
        ");

        return $stmt->fetchAll();
    }

    public function search(string $keyword): array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM payments
            WHERE payment_code LIKE :keyword
            OR student_email LIKE :keyword
            OR payment_status LIKE :keyword
            ORDER BY id DESC
        ");

        $stmt->execute([
            'keyword' => '%' . $keyword . '%',
        ]);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM payments
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO payments
                (
                    payment_code,
                    student_email,
                    amount,
                    payment_status
                )
                VALUES
                (
                    :payment_code,
                    :student_email,
                    :amount,
                    :payment_status
                )
            ");

            $stmt->execute([
                'payment_code' => $data['payment_code'],
                'student_email' => $data['student_email'],
                'amount' => $data['amount'],
                'payment_status' => $data['payment_status'],
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new DuplicateRecordException(
                    'Payment code already exists.'
                );
            }

            throw $e;
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE payments
                SET
                    payment_code = :payment_code,
                    student_email = :student_email,
                    amount = :amount,
                    payment_status = :payment_status
                WHERE id = :id
            ");

            $stmt->execute([
                'id' => $id,
                'payment_code' => $data['payment_code'],
                'student_email' => $data['student_email'],
                'amount' => $data['amount'],
                'payment_status' => $data['payment_status'],
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new DuplicateRecordException(
                    'Payment code already exists.'
                );
            }

            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM payments
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }

    public function paginate(string $keyword, int $limit, int $offset): array
    {
        $sql = "
            SELECT *
            FROM payments
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE payment_code LIKE :keyword
                OR student_email LIKE :keyword
                OR payment_status LIKE :keyword
            ";
        }

        $sql .= "
            ORDER BY id DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function count(string $keyword = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM payments
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE payment_code LIKE :keyword
                OR student_email LIKE :keyword
                OR payment_status LIKE :keyword
            ";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}