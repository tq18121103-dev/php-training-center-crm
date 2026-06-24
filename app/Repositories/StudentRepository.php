<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\DuplicateRecordException;
use PDO;
use PDOException;

class StudentRepository
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
            FROM students
            ORDER BY id DESC
        ");

        return $stmt->fetchAll();
    }

    public function search(string $keyword): array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM students
            WHERE full_name LIKE :keyword
               OR email LIKE :keyword
               OR phone LIKE :keyword
               OR student_code LIKE :keyword
               OR course LIKE :keyword
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
            FROM students
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO students
                (
                    student_code,
                    full_name,
                    email,
                    phone,
                    course,
                    status
                )
                VALUES
                (
                    :student_code,
                    :full_name,
                    :email,
                    :phone,
                    :course,
                    :status
                )
            ");

            $stmt->execute([
                'student_code' => $data['student_code'],
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'course' => $data['course'],
                'status' => $data['status'],
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new DuplicateRecordException(
                    'Student email or code already exists.'
                );
            }

            throw $e;
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE students
                SET
                    student_code = :student_code,
                    full_name = :full_name,
                    email = :email,
                    phone = :phone,
                    course = :course,
                    status = :status
                WHERE id = :id
            ");

            $stmt->execute([
                'id' => $id,
                'student_code' => $data['student_code'],
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'course' => $data['course'],
                'status' => $data['status'],
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new DuplicateRecordException(
                    'Student email or code already exists.'
                );
            }

            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM students
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }

    public function paginate(string $keyword, int $limit, int $offset): array
    {
        $sql = "
            SELECT *
            FROM students
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE full_name LIKE :keyword
                   OR email LIKE :keyword
                   OR phone LIKE :keyword
                   OR student_code LIKE :keyword
                   OR course LIKE :keyword
            ";
        }

        $allowedSorts = [
            'id' => 'id',
            'student_code' => 'student_code',
            'full_name' => 'full_name',
            'email' => 'email',
            'course' => 'course',
            'status' => 'status',
        ];

        $sort = $_GET['sort'] ?? 'id';
        $direction = strtoupper($_GET['direction'] ?? 'DESC');

        $sortColumn = $allowedSorts[$sort] ?? 'id';

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        $sql .= "
            ORDER BY $sortColumn $direction
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
            FROM students
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE full_name LIKE :keyword
                   OR email LIKE :keyword
                   OR phone LIKE :keyword
                   OR student_code LIKE :keyword
                   OR course LIKE :keyword
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