<?php 
include('DBconnect.php'); 

$msg = "";
$error = "";

if(isset($_POST['register'])){
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $type = $_POST['user_type'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql_user = "INSERT INTO users (user_type, full_name, email, contact, address, password_hash, gender) 
                 VALUES ('$type', '$name', '$email', '$contact', '$address', '$password', '$gender')";

    if ($conn->query($sql_user) === TRUE) {
        $new_user_id = $conn->insert_id;
        $sql_details = "";

        if($type == 'member'){
            $bmi = $_POST['bmi'];
            $sql_details = "INSERT INTO members_details (user_id, bmi, join_date) 
                            VALUES ('$new_user_id', '$bmi', CURDATE())";
        } else if($type == 'trainer'){
            $availability = $_POST['availability'];
            $sql_details = "INSERT INTO trainers_details (user_id, availability_status) 
                            VALUES ('$new_user_id', '$availability')";
        }

        if($conn->query($sql_details)){
            $msg = "Registration Successful! <a href='index.php' class='alert-link'>Login here</a>";
        }
    } else {
        $error = "Registration failed: " . $conn->error;
    }
}

if(isset($_POST['login_redirect'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join the Gym | Gym Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }
        .signup-card {
            width: 100%;
            max-width: 550px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .brand-logo { font-weight: 700; font-size: 1.5rem; color: #0d6efd; }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #444; }
        .section-title { border-left: 4px solid #0d6efd; padding-left: 10px; margin-bottom: 20px; font-weight: 700; font-size: 1rem; }
    </style>
    <script>
        function toggleFields() {
            var type = document.getElementById("user_type").value;
            document.getElementById("member_fields").style.display = (type == "member") ? "block" : "none";
            document.getElementById("trainer_fields").style.display = (type == "trainer") ? "block" : "none";
        }
    </script>
</head>
<body onload="toggleFields()">

<div class="signup-card card p-4">
    <div class="text-center mb-4">
        <div class="brand-logo mb-1">GYM PRO</div>
        <p class="text-muted small">Create your account</p>
    </div>

    <?php if($msg != "") echo "<div class='alert alert-success small text-center'>$msg</div>"; ?>
    <?php if($error != "") echo "<div class='alert alert-danger small text-center'>$error</div>"; ?>

    <form method="POST">
        <div class="mb-4">
            <label class="form-label">I am registering as a:</label>
            <select name="user_type" id="user_type" class="form-select" onchange="toggleFields()" required>
                <option value="member">Gym Member</option>
                <option value="trainer">Fitness Trainer</option>
            </select>
        </div>

        <div class="section-title">Personal Information</div>
        
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Will Smith" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="will@example.com" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact" class="form-control" placeholder="01XXX-XXXXXX" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Home Address</label>
            <input type="text" name="address" class="form-control" placeholder="Street, City, Zip" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Secure Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <!-- Member Specific -->
        <div id="member_fields" class="mb-4 p-3 bg-light rounded shadow-sm">
            <div class="section-title mb-2">Health Details</div>
            <label class="form-label">Current BMI</label>
            <input type="number" step="0.01" name="bmi" class="form-control" placeholder="e.g. 22.5">
        </div>

        <!-- Trainer Specific -->
        <div id="trainer_fields" class="mb-4 p-3 bg-light rounded shadow-sm">
            <div class="section-title mb-2">Professional Details</div>
            <label class="form-label">Work Availability</label>
            <input type="text" name="availability" class="form-control" placeholder="e.g. 9am-5pm Mon-Fri">
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" name="register" class="btn btn-primary fw-bold p-2">Register Now</button>
        </div>

        <div class="text-center">
            <span class="text-muted small">Already a member?</span>
            <button type="submit" name="login_redirect" class="btn btn-link btn-sm fw-bold p-0 text-decoration-none" formnovalidate>Log In</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>