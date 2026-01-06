<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .navbar { background-color: #1a1a1a !important; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); transition: 0.3s; }
        .card:hover { transform: translateY(-5px); }
        .stat-card { border-left: 5px solid #0d6efd; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">GYM MANAGER</a>
        <div class="navbar-nav ms-auto">
            <span class="nav-link text-white me-3">Welcome, <?php echo $_SESSION['name']; ?></span>
            <a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a>
        </div>
    </div>
</nav>
<div class="container">