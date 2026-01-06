<?php 
include('DBconnect.php'); 


if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'member') {
    header("Location: index.php");
    exit();
}

$m_id = $_SESSION['user_id'];
$msg = "";
$msg_class = "";

// 1. Payment report
if(isset($_POST['pay'])){
    $amount = $_POST['amount'];
    
    $insert_sql = "INSERT INTO payments (user_id, amount, status, payment_date) 
                   VALUES ('$m_id', '$amount', 'Pending', NOW())";
    
    if($conn->query($insert_sql)){
        $msg = "Payment report submitted! Please wait for Admin approval.";
        $msg_class = "alert-success";
    } else {
        $msg = "Error: " . $conn->error;
        $msg_class = "alert-danger";
    }
}

include('header.php'); 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">My Payments</h2>
        <p class="text-muted">Report your membership fees and track your history.</p>
    </div>
    <a href="member_dashboard.php" class="btn btn-outline-secondary btn-sm">← Back to Dashboard</a>
</div>

<?php if($msg != ""): ?>
    <div class="alert <?php echo $msg_class; ?> alert-dismissible fade show" role="alert">
        <?php echo $msg; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- COLUMN 1: REPORT FORM -->
    <div class="col-lg-4">
        <div class="card p-4 shadow-sm border-0">
            <h5 class="fw-bold mb-3">Report New Payment</h5>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Amount Paid</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="amount" class="form-control" placeholder="0.00" step="0.01" required>
                    </div>
                    <div class="form-text mt-2 small">Enter the exact amount you paid via Cash or Transfer.</div>
                </div>
                <div class="d-grid">
                    <button type="submit" name="pay" class="btn btn-primary fw-bold">Submit Payment Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- COLUMN 2: PAYMENT HISTORY -->
    <div class="col-lg-8">
        <div class="card p-4 shadow-sm border-0">
            <h5 class="fw-bold mb-3">Payment History</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM payments WHERE user_id = '$m_id' ORDER BY payment_date DESC";
                        $res = $conn->query($query);
                        
                        if($res && $res->num_rows > 0){
                            while($row = $res->fetch_assoc()){
                                $status_badge = ($row['status'] == 'Paid') ? 'bg-success' : 'bg-warning text-dark';
                                echo "<tr>
                                        <td>" . date('M d, Y', strtotime($row['payment_date'])) . "</td>
                                        <td class='fw-bold'>$" . number_format($row['amount'], 2) . "</td>
                                        <td class='text-center'>
                                            <span class='badge $status_badge' style='width: 80px;'>" . $row['status'] . "</span>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center py-4 text-muted'>No payment records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>