<?php include('DBconnect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Login | Gym Pro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .brand-logo {
            font-weight: 700;
            font-size: 1.5rem;
            color: #0d6efd;
            letter-spacing: -1px;
        }
    </style>
</head>
<body>

<div class="login-card card p-4">
    <div class="text-center mb-4">
        <div class="brand-logo mb-1">GYM PRO</div>
        <p class="text-muted small">Management System Login</p>
    </div>

    <!-- Error Messaging -->
    <?php
    $error = "";
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if($result && $result->num_rows > 0){
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password_hash'])){ 
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['name'] = $user['full_name'];

                if($user['user_type'] == 'admin') header("Location: admin_dashboard.php");
                elseif($user['user_type'] == 'trainer') header("Location: trainer_dashboard.php");
                else header("Location: member_dashboard.php");
                exit();
            } else { $error = "Invalid Password"; }
        } else { $error = "User not found"; }
    }

    if(isset($_POST['signup'])){
        header("Location: signup.php");
        exit();
    }

    if($error != "") {
        echo '<div class="alert alert-danger p-2 small text-center" role="alert">'.$error.'</div>';
    }
    ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label small fw-bold">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-bold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        
        <div class="d-grid gap-2">
            <button type="submit" name="login" class="btn btn-primary fw-bold">Login</button>
            <button type="submit" name="signup" class="btn btn-outline-secondary btn-sm" formnovalidate>Don't have an account? Register</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>