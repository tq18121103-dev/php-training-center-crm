<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Dashboard') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header class="topbar">
    <strong>Lab05 Training Center CRM</strong>
    <nav>
        <a href="/">Dashboard</a>
        <a href="/students">Students</a>
        <a href="/students/create">Create Student</a>
        <a href="/payments">Payments</a>
        <a href="/payments/create">Create Payment</a>
        <a href="/health">Health</a>
    </nav>
</header>

<main class="container">
    <h1>Lab05 - Training Center CRM DB App</h1>
    <p>PDO + Repository + CRUD + Search/Pagination + Unique & Index</p>

    <div class="cards">
        <div class="card">
            <h2>Database</h2>
            <p>users / students / payments</p>
            <p>utf8mb4 + constraints</p>
        </div>

        <div class="card">
            <h2>PDO Repository</h2>
            <p>Prepared statements</p>
            <p>No SQL string concat with input</p>
        </div>

        <div class="card">
            <h2>Student CRUD</h2>
            <p>List, create, edit, update, delete</p>
            <p>Duplicate email handling</p>
        </div>

        <div class="card">
            <h2>Payment CRUD</h2>
            <p>Payment code unique</p>
            <p>Search + pagination</p>
        </div>

        <div class="card">
            <h2>Performance</h2>
            <p>Index + EXPLAIN</p>
            <p>LIMIT / OFFSET safe</p>
        </div>
    </div>

    <div class="flow">
        <strong>Flow:</strong>
        Browser → public/index.php → Router → Controller → Repository → PDO → MySQL → View/Redirect
    </div>
</main>
</body>
</html>