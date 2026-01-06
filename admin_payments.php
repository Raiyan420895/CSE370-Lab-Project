<?php 
include('DBconnect.php'); 

if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: index.php');
    exit();
}


if(isset($_GET['approve'])){
    $pid = $_GET['approve'];
    $update_query = "UPDATE payments SET status = 'Paid' WHERE payment_id = '$pid'";
    
    if($conn->query($update_query)){
        $success_msg = "Payment Approved Successfully!";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}


include('header.php'); 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Payment Management</h2>
    <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm">← Back to Dashboard</a>
</div>


<?php if(isset($success_msg)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $success_msg; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- COLUMN 1: PENDING APPROVALS -->
    <div class="col-lg-8">
        <div class="card p-4 shadow-sm">
            <h5 class="fw-bold mb-3">Pending Approvals</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Member Name</th>
                            <th>Amount</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT p.payment_id, u.full_name, p.amount 
                                  FROM payments p 
                                  JOIN users u ON p.user_id = u.user_id 
                                  WHERE p.status = 'Pending'";
                        $res = $conn->query($query);

                        if($res && $res->num_rows > 0){
                            while($row = $res->fetch_assoc()){
                                echo "<tr>
                                        <td>
                                            <div class='fw-bold'>{$row['full_name']}</div>
                                            <small class='text-muted'>ID: #{$row['payment_id']}</small>
                                        </td>
                                        <td><span class='badge bg-light text-dark'>$".number_format($row['amount'], 2)."</span></td>
                                        <td class='text-end'>
                                            <a href='?approve={$row['payment_id']}' class='btn btn-success btn-sm'>Approve Payment</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center py-4 text-muted'>No pending approvals found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- COLUMN 2: DEFAULTER LIST -->
    <div class="col-lg-4">
        <div class="card p-4 border-danger shadow-sm">
            <h5 class="fw-bold text-danger mb-1">Defaulter List</h5>
            <p class="small text-muted mb-3">Members with no 'Paid' records this month.</p>
            
            <ul class="list-group list-group-flush">
            <?php
            $month = date('m');
            $year = date('Y');
            $defaulter_query = "SELECT full_name FROM users 
                                WHERE user_type='member' 
                                AND user_id NOT IN (
                                    SELECT user_id FROM payments 
                                    WHERE status='Paid' 
                                    AND MONTH(payment_date)='$month' 
                                    AND YEAR(payment_date)='$year'
                                )";
            
            $def_res = $conn->query($defaulter_query);
            if($def_res && $def_res->num_rows > 0){
                while($row = $def_res->fetch_assoc()){
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                            {$row['full_name']}
                            <span class='badge bg-danger rounded-pill'>Unpaid</span>
                          </li>";
                }
            } else {
                echo "<li class='list-group-item text-muted px-0'>Everyone has paid!</li>";
            }
            ?>
            </ul>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>