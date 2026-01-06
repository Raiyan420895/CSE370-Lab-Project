<?php 
include('DBconnect.php'); 

// Security Check
if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin'){
    header('Location: index.php');
    exit();
}

$res_total = $conn->query("SELECT COUNT(*) as count FROM users WHERE user_type = 'member'");
$total_members = ($res_total) ? $res_total->fetch_assoc()['count'] : 0;

$res_pending = $conn->query("SELECT COUNT(*) as count FROM payments WHERE status = 'Pending'");
$pending_payments = ($res_pending) ? $res_pending->fetch_assoc()['count'] : 0;


include('header.php'); 
?>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card p-3">
            <h6 class="text-muted">Total Members</h6>
            <h2 class="fw-bold"><?php echo $total_members; ?></h2>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card p-3 border-warning">
            <h6 class="text-muted">Pending Payments</h6>
            <h2 class="fw-bold text-warning"><?php echo $pending_payments; ?></h2>
        </div>
    </div>
</div>

<div class="card p-4 mb-4">
    <h4 class="fw-bold mb-3">Feature Management</h4>
    <div class="d-flex flex-wrap gap-2">
        <a href="admin_payments.php" class="btn btn-primary">Payment Management</a>
        <a href="admin_complaints.php" class="btn btn-secondary">Complaints</a>
        <a href="admin_equipment.php" class="btn btn-dark">Equipment</a>
        <a href="admin_alerts.php" class="btn btn-info text-white">Broadcast Alerts</a>
    </div>
</div>


<div class="row g-4">
    <!-- Active Trainers Table -->
    <div class="col-lg-6">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-3">Active Trainers</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr><th>Name</th><th>Contact</th><th>Specializations</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_trainers = "SELECT u.user_id, u.full_name, u.contact FROM users u 
                                         JOIN trainers_details td ON u.user_id = td.user_id 
                                         WHERE u.user_type = 'trainer'";
                        $result = $conn->query($sql_trainers);
                        while($row = $result->fetch_assoc()) {
                            $tid = $row['user_id'];
                            $spec_res = $conn->query("SELECT specialization FROM trainer_specialization WHERE user_id = $tid");
                            $specs = [];
                            while($s = $spec_res->fetch_assoc()) { $specs[] = $s['specialization']; }
                            $spec_list = empty($specs) ? "None" : implode(", ", $specs);

                            echo "<tr>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['contact']}</td>
                                    <td><small class='text-muted'>$spec_list</small></td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Active Members Table -->
    <div class="col-lg-6">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-3">Active Members</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr><th>Name</th><th>BMI</th><th>Trainer</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_members = "SELECT u.full_name, md.bmi, trainer.full_name as t_name
                                        FROM users u 
                                        JOIN members_details md ON u.user_id = md.user_id
                                        LEFT JOIN users trainer ON md.assigned_trainer_id = trainer.user_id
                                        WHERE u.user_type = 'member'";
                        $result_members = $conn->query($sql_members);
                        while($row = $result_members->fetch_assoc()) {
                            $t_name = $row['t_name'] ? $row['t_name'] : "None";
                            echo "<tr>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['bmi']}</td>
                                    <td><span class='badge bg-light text-dark'>$t_name</span></td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>