<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<main class="container">

<h1>Edit Student</h1>

<form method="post" action="/students/update">

    <input
        type="hidden"
        name="id"
        value="<?= e((string) $student['id']) ?>"
    >

    <div>
        <label>Student Code</label>

        <input
            name="student_code"
            value="<?= e($old['student_code'] ?? $student['student_code']) ?>"
        >

        <div>
            <?= e($errors['student_code'] ?? '') ?>
        </div>
    </div>

    <br>

    <div>
        <label>Name</label>

        <input
            name="full_name"
            value="<?= e($old['full_name'] ?? $student['full_name']) ?>"
        >

        <div>
            <?= e($errors['full_name'] ?? '') ?>
        </div>
    </div>

    <br>

    <div>
        <label>Email</label>

        <input
            name="email"
            value="<?= e($old['email'] ?? $student['email']) ?>"
        >

        <div>
            <?= e($errors['email'] ?? '') ?>
        </div>
    </div>

    <br>

    <div>
        <label>Phone</label>

        <input
            name="phone"
            value="<?= e($old['phone'] ?? $student['phone']) ?>"
        >

        <div>
            <?= e($errors['phone'] ?? '') ?>
        </div>
    </div>

    <br>

    <div>
        <label>Course</label>

        <input
            name="course"
            value="<?= e($old['course'] ?? $student['course']) ?>"
        >

        <div>
            <?= e($errors['course'] ?? '') ?>
        </div>
    </div>

    <br>

    <div>
        <label>Status</label>

        <select name="status">
            <option value="new"
                <?= (($old['status'] ?? $student['status']) === 'new') ? 'selected' : '' ?>>
                New
            </option>

            <option value="contacted"
                <?= (($old['status'] ?? $student['status']) === 'contacted') ? 'selected' : '' ?>>
                Contacted
            </option>

            <option value="enrolled"
                <?= (($old['status'] ?? $student['status']) === 'enrolled') ? 'selected' : '' ?>>
                Enrolled
            </option>
        </select>

        <div>
            <?= e($errors['status'] ?? '') ?>
        </div>
    </div>

    <br>

    <button type="submit">
        Update Student
    </button>

    <a href="/students">
        Cancel
    </a>

</form>

</main>

</body>
</html>