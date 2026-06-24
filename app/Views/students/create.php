<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Student</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<main class="container">

<h1>Create Student</h1>

<form method="post" action="/students">
    <div>
        <label>Student Code</label>
        <input
            name="student_code"
            value="<?= e($old['student_code'] ?? '') ?>"
            placeholder="ST001"
        >
        <div><?= e($errors['student_code'] ?? '') ?></div>
    </div>

    <br>

    <div>
        <label>Name</label>
        <input
            name="full_name"
            value="<?= e($old['full_name'] ?? '') ?>"
        >
        <div><?= $errors['full_name'] ?? '' ?></div>
    </div>

    <br>

    <div>
        <label>Email</label>
        <input
            name="email"
            value="<?= e($old['email'] ?? '') ?>"
        >
        <div><?= $errors['email'] ?? '' ?></div>
    </div>

    <br>

    <div>
        <label>Phone</label>
        <input
            name="phone"
            value="<?= e($old['phone'] ?? '') ?>"
        >
    </div>

    <br>

    <div>
        <label>Course</label>
        <input
            name="course"
            value="<?= e($old['course'] ?? '') ?>"
        >
        <div><?= $errors['course'] ?? '' ?></div>
    </div>

    <br>

    <div>
        <label>Status</label>

        <select name="status">
            <option value="">Choose</option>
            <option value="new" <?= (($old['status'] ?? '') === 'new') ? 'selected' : '' ?>>New</option>
            <option value="contacted" <?= (($old['status'] ?? '') === 'contacted') ? 'selected' : '' ?>>Contacted</option>
            <option value="enrolled" <?= (($old['status'] ?? '') === 'enrolled') ? 'selected' : '' ?>>Enrolled</option>
        </select>

        <div><?= $errors['status'] ?? '' ?></div>
    </div>

    <br>

    <button>Create Student</button>

</form>

</main>

</body>
</html>