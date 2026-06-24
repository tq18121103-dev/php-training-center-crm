<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Payment</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<main class="container">

<h1>Create Payment</h1>

<form method="post" action="/payments">

    <div>
        <label>Payment Code</label>
        <input
            name="payment_code"
            value="<?= e($old['payment_code'] ?? '') ?>"
            placeholder="PAY001"
        >
        <div><?= e($errors['payment_code'] ?? '') ?></div>
    </div>

    <br>

    <div>
        <label>Student Email</label>
        <input
            name="student_email"
            value="<?= e($old['student_email'] ?? '') ?>"
            placeholder="student@example.com"
        >
        <div><?= e($errors['student_email'] ?? '') ?></div>
    </div>

    <br>

    <div>
        <label>Amount</label>
        <input
            name="amount"
            type="number"
            step="1000"
            value="<?= e($old['amount'] ?? '') ?>"
            placeholder="3000000"
        >
        <div><?= e($errors['amount'] ?? '') ?></div>
    </div>

    <br>

    <div>
        <label>Status</label>

        <select name="payment_status">
            <option value="">Choose</option>
            <option value="pending" <?= (($old['payment_status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
            <option value="paid" <?= (($old['payment_status'] ?? '') === 'paid') ? 'selected' : '' ?>>Paid</option>
            <option value="cancelled" <?= (($old['payment_status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
        </select>

        <div><?= e($errors['payment_status'] ?? '') ?></div>
    </div>

    <br>

    <button type="submit">
        Create Payment
    </button>

    <a href="/payments">
        Cancel
    </a>

</form>

</main>

</body>
</html>