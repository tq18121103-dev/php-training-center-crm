<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payments</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<header class="topbar">
    <strong>Payments</strong>
    <nav>
        <a href="/">Dashboard</a>
        <a href="/students">Students</a>
        <a href="/payments">Payments</a>
        <a href="/payments/create">Create Payment</a>
    </nav>
</header>

<main class="container">

    <h1>Payment List</h1>

    <?php if ($message = flash_get('success')): ?>
        <p style="color:green;">
            <?= e($message) ?>
        </p>
    <?php endif; ?>

    <a class="btn" href="/payments/create">
        Create Payment
    </a>

    <br><br>

    <br><br>

    <form method="get" action="/payments">
        <input
            type="text"
            name="keyword"
            value="<?= e($keyword ?? '') ?>"
            placeholder="Search by payment code, email, status"
        >

        <button type="submit">Search</button>

        <a href="/payments">Reset</a>
    </form>

    <br>

    <table border="1" cellpadding="10">
        <thead>
        <tr>
            <th>ID</th>
            <th>Payment Code</th>
            <th>Student Email</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>

        <?php if (empty($payments)): ?>
            <tr>
                <td colspan="7">No payments found.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= e((string) $payment['id']) ?></td>
                <td><?= e($payment['payment_code']) ?></td>
                <td><?= e($payment['student_email']) ?></td>
                <td><?= e(number_format((float) $payment['amount'])) ?> VND</td>
                <td><?= e($payment['payment_status']) ?></td>
                <td><?= e($payment['created_at']) ?></td>
                <td>
                    <a href="/payments/edit?id=<?= e((string) $payment['id']) ?>">
                        Edit
                    </a>

                    <form
                        method="post"
                        action="/payments/delete"
                        style="display:inline;"
                        onsubmit="return confirm('Delete this payment?');"
                    >
                        <input
                            type="hidden"
                            name="id"
                            value="<?= e((string) $payment['id']) ?>"
                        >

                        <button type="submit">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

    <br>

    <?php if (($totalPages ?? 1) > 1): ?>
        <div>
            Pages:

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a
                    href="/payments?keyword=<?= e($keyword ?? '') ?>&page=<?= $i ?>"
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