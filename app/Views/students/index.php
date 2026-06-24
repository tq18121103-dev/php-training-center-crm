<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<header class="topbar">
    <strong>Students</strong>

    <nav>
        <a href="/">Dashboard</a>
        <a href="/students">Students</a>
        <a href="/students/create">Create Student</a>
    </nav>
</header>

<main class="container">

    <h1>Student List</h1>

    <?php if ($message = flash_get('success')): ?>
        <p style="color:green;">
            <?= e($message) ?>
        </p>
    <?php endif; ?>

    <a class="btn" href="/students/create">
        Create Student
    </a>

    <br><br>

    <form method="get" action="/students">

        <input
            type="text"
            name="keyword"
            value="<?= e($keyword ?? '') ?>"
            placeholder="Search by name, email, phone, code, course"
        >

        <button type="submit">
            Search
        </button>

        <a href="/students">
            Reset
        </a>

    </form>

    <br>

    <table border="1" cellpadding="10">

        <thead>
            <tr>
                <th>ID</th>
                <th>Student Code</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php if (empty($students)): ?>

            <tr>
                <td colspan="8">
                    No students found.
                </td>
            </tr>

        <?php else: ?>

            <?php foreach ($students as $student): ?>

                <tr>
                    <td><?= e((string)$student['id']) ?></td>
                    <td><?= e($student['student_code']) ?></td>
                    <td><?= e($student['full_name']) ?></td>
                    <td><?= e($student['email']) ?></td>
                    <td><?= e($student['phone']) ?></td>
                    <td><?= e($student['course']) ?></td>
                    <td><?= e($student['status']) ?></td>

                    <td>

                        <a href="/students/edit?id=<?= e((string)$student['id']) ?>">
                            Edit
                        </a>

                        |

                        <form
                            method="post"
                            action="/students/delete"
                            style="display:inline;"
                            onsubmit="return confirm('Delete this student?');"
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?= e((string)$student['id']) ?>"
                            >

                            <button type="submit">
                                Delete
                            </button>

                        </form>

                    </td>
                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

        </tbody>

    </table>

    <br>

    <?php if (($totalPages ?? 1) > 1): ?>
        <div>
            Pages:

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a
                    href="/students?keyword=<?= e($keyword ?? '') ?>&page=<?= $i ?>"
                    style="<?= ($i === ($page ?? 1)) ? 'font-weight:bold; color:red;' : '' ?>"
                >
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>


</main>

</body>
</html>