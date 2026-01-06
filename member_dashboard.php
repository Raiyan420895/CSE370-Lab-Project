<?php 
include('DBconnect.php'); 

if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'member') {
    header("Location: index.php"); 
    exit(); 
}

$m_id = $_SESSION['user_id'];

$sql_me = "SELECT md.bmi, u.full_name as t_name 
           FROM members_details md 
           LEFT JOIN users u ON md.assigned_trainer_id = u.user_id 
           WHERE md.user_id = '$m_id'";
$res_me = $conn->query($sql_me);
$my_data = ($res_me) ? $res_me->fetch_assoc() : null;


$res_work = $conn->query("SELECT COUNT(*) as count FROM workout_plans WHERE member_id = '$m_id' AND status = 'Pending'");
$pending_workouts = ($res_work) ? $res_work->fetch_assoc()['count'] : 0;

include('header.php'); 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Member Dashboard</h2>
        <p class="text-muted">Welcome back to your fitness journey, <?php echo $_SESSION['name']; ?>!</p>
    </div>
    <span class="badge bg-primary p-2">Member Account</span>
</div>


<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card stat-card p-3 border-primary shadow-sm h-100">
            <h6 class="text-muted small text-uppercase fw-bold">Current BMI</h6>
            <h2 class="fw-bold mb-0"><?php echo isset($my_data['bmi']) ? $my_data['bmi'] : 'N/A'; ?></h2>
            <small class="text-primary">Keep tracking your progress!</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-3 border-success shadow-sm h-100">
            <h6 class="text-muted small text-uppercase fw-bold">Assigned Trainer</h6>
            <h2 class="fw-bold mb-0" style="font-size: 1.5rem;">
                <?php echo isset($my_data['t_name']) ? $my_data['t_name'] : 'Unassigned'; ?>
            </h2>
            <small class="text-success">Your dedicated coach</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-3 border-warning shadow-sm h-100">
            <h6 class="text-muted small text-uppercase fw-bold">Pending Exercises</h6>
            <h2 class="fw-bold mb-0 text-warning"><?php echo $pending_workouts; ?></h2>
            <small class="text-muted">Finish your daily routine</small>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- COLUMN 1: FITNESS TOOLS -->
    <div class="col-lg-8">
        <h5 class="fw-bold mb-3">My Fitness Tools</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <a href="member_payments.php" class="text-decoration-none">
                    <div class="card p-4 h-100 text-center border-0 shadow-sm bg-white">
                        <div class="h1 mb-2">💰</div>
                        <h6 class="fw-bold text-dark">My Payments</h6>
                        <p class="small text-muted mb-0">Report fees & view history</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="member_workouts.php" class="text-decoration-none">
                    <div class="card p-4 h-100 text-center border-0 shadow-sm bg-white">
                        <div class="h1 mb-2">🏋️</div>
                        <h6 class="fw-bold text-dark">Workout Routine</h6>
                        <p class="small text-muted mb-0">View & complete exercises</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="member_reviews.php" class="text-decoration-none">
                    <div class="card p-4 h-100 text-center border-0 shadow-sm bg-white">
                        <div class="h1 mb-2">⭐</div>
                        <h6 class="fw-bold text-dark">Rate & Review</h6>
                        <p class="small text-muted mb-0">Feedback for staff & gear</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="member_complaints.php" class="text-decoration-none">
                    <div class="card p-4 h-100 text-center border-0 shadow-sm bg-white">
                        <div class="h1 mb-2">⚠️</div>
                        <h6 class="fw-bold text-dark">Helpdesk</h6>
                        <p class="small text-muted mb-0">Report facility issues</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- COLUMN 2: NOTIFICATIONS -->
    <div class="col-lg-4">
        <div class="card p-4 shadow-sm border-0 h-100">
            <h5 class="fw-bold mb-3">Notifications</h5>
            <div class="list-group list-group-flush">
                <?php
                
                $alert_sql = "SELECT * FROM alerts_system WHERE target_id = '$m_id' OR target_id IS NULL ORDER BY created_at DESC LIMIT 4";
                $alerts = $conn->query($alert_sql);
                
                if($alerts && $alerts->num_rows > 0){
                    while($row = $alerts->fetch_assoc()){
                        $type_class = ($row['alert_type'] == 'Payment') ? 'text-danger' : 'text-primary';
                        echo "<div class='list-group-item px-0 border-0 mb-3'>
                                <div class='d-flex justify-content-between align-items-center'>
                                    <small class='fw-bold $type_class'>{$row['alert_type']}</small>
                                    <small class='text-muted' style='font-size: 0.7rem;'>".date('M d', strtotime($row['created_at']))."</small>
                                </div>
                                <div class='fw-bold' style='font-size: 0.9rem;'>{$row['title']}</div>
                                <div class='text-muted small'>{$row['message']}</div>
                              </div>";
                    }
                } else {
                    echo "<p class='text-muted small py-4 text-center'>No new notifications.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>