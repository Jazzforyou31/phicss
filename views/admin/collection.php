<?php
session_start();
require '../../classes/cashInOutClass.php';

$cashInOut = new CashInOutClass();

// Handle form submissions for adding Cash In or Cash Out
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actionType = $_POST['action_type'] ?? null;

    if ($actionType === 'add_cash_in') {
        $collectionDate = $_POST['collection_date'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $schoolYearId = $_POST['school_year_id'] ?? null;
        $createdBy = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session

        if ($collectionDate && $amount && $schoolYearId && $createdBy) {
            $cashInOut->addCashIn($collectionDate, $amount, $schoolYearId, $createdBy);
            header("Location: collection.php"); // Redirect to avoid form resubmission
            exit;
        }
    } elseif ($actionType === 'add_cash_out') {
        $cashOutDate = $_POST['cashout_date'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $details = $_POST['expense_details'] ?? null;
        $category = $_POST['expense_category'] ?? null;
        $schoolYearId = $_POST['school_year_id'] ?? null;
        $createdBy = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session

        if ($cashOutDate && $amount && $details && $category && $schoolYearId && $createdBy) {
            $cashInOut->addCashOut($cashOutDate, $amount, $details, $category, $schoolYearId, $createdBy);
            header("Location: collection.php"); // Redirect to avoid form resubmission
            exit;
        }
    }
}

// Get the selected school year from the GET parameter
$selectedYear = $_GET['school_year_id'] ?? null;

// Fetch records based on the selected school year
if ($selectedYear) {
    $cashInRecords = $cashInOut->fetchCashInByYear($selectedYear);
    $cashOutRecords = $cashInOut->fetchCashOutByYear($selectedYear);
} else {
    $cashInRecords = $cashInOut->fetchCashIn();
    $cashOutRecords = $cashInOut->fetchCashOut();
}

// Calculate totals
$totalCashIn = array_sum(array_column($cashInRecords, 'amount'));
$totalCashOut = array_sum(array_column($cashOutRecords, 'amount'));
$netIncome = $totalCashIn - $totalCashOut;

// Fetch all school years for the dropdown
$schoolYears = $cashInOut->fetchSchoolYears();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings | PhiCCS Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../../css/admin_sidebar.css">
  <style>
    body { background-color: #f3f4f6; }
    .content { padding: 20px; }
    .header-title { font-weight: 600; color: #1f2937; }
    .header-subtitle { color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; }
    .summary-buttons { display: flex; gap: 1rem; margin-bottom: 2rem; }
    .button { flex: 1; background-color: white; border: 1px solid #d1d5db; border-radius: 0.5rem; padding: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
    .button:hover { box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); }
    .amount-green { color: #10b981; font-size: 1.25rem; font-weight: bold; }
    .amount-red { color: #ef4444; font-size: 1.25rem; font-weight: bold; }
    .table-section { background-color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 2rem; }
    .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
    .table th, .table td { vertical-align: middle; text-align: center; font-size: 0.875rem; }
    .total-row { background-color: #f9fafb; font-weight: 600; }
    .add-button { background-color: #4f46e5; color: white; border: none; border-radius: 0.375rem; padding: 6px 12px; }
    .add-button.btn-danger { background-color: #ef4444; }
    .amount-purple {
      color: #6b21a8; /* Purple */
      font-size: 1.25rem;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="content">
    <header class="mb-4">
      <h1 class="header-title">Cash In/Out Management</h1>
      <p class="header-subtitle">Admin Panel</p>
    </header>


    <div class="mb-4">
      <label for="schoolYearFilter" class="form-label">Filter by School Year:</label>
      <select id="schoolYearFilter" class="form-select" onchange="applyYearFilter()">
        <option value="">All</option>
        <?php foreach ($schoolYears as $year): ?>
          <option value="<?= $year['school_year_id']; ?>" <?= $selectedYear == $year['school_year_id'] ? 'selected' : ''; ?>>
            <?= $year['school_year']; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Summary Section -->
    <div class="summary-buttons">
      <div class="button">
        <p>Total Cash In</p>
        <p class="amount-green">₱<?= number_format($totalCashIn, 2); ?></p>
      </div>
      <div class="button">
        <p>Total Cash Out</p>
        <p class="amount-red">₱<?= number_format($totalCashOut, 2); ?></p>
      </div>
      <div class="button">
        <p>Net Income</p>
        <p class="amount-purple">₱<?= number_format($netIncome, 2); ?></p>
      </div>
    </div>

    

    <!-- Cash In Table -->
    <div class="table-section">
      <div class="table-header">
        <h2>Cash In</h2>
        <button class="add-button" data-bs-toggle="modal" data-bs-target="#addCashInModal">
          <i class="fas fa-plus"></i> Add Cash In
        </button>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Action</th>
            <th>Created By</th>
            <th>Date</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cashInRecords as $cashIn): ?>
            <tr>
              <td class="action-icons">
                <i class="fas fa-edit text-warning" title="Edit"></i>
                <i class="fas fa-trash text-danger" title="Delete"></i>
              </td>
              <td><?= htmlspecialchars($cashIn['created_by_name']); ?></td>
              <td><?= htmlspecialchars($cashIn['collection_date']); ?></td>
              <td>₱<?= number_format($cashIn['amount'], 2); ?></td>
            </tr>
          <?php endforeach; ?>
          <tr class="total-row">
            <td colspan="2"></td>
            <td>Total:</td>
            <td class="amount-green">₱<?= number_format(array_sum(array_column($cashInRecords, 'amount')), 2); ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Cash Out Table -->
    <div class="table-section">
      <div class="table-header">
        <h2>Cash Out</h2>
        <button class="add-button btn btn-danger" data-bs-toggle="modal" data-bs-target="#addCashOutModal">
          <i class="fas fa-plus"></i> Add Cash Out
        </button>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Action</th>
            <th>Created By</th>
            <th>Date</th>
            <th>Details</th>
            <th>Category</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cashOutRecords as $cashOut): ?>
            <tr>
              <td class="action-icons">
                <i class="fas fa-edit text-warning" title="Edit"></i>
                <i class="fas fa-trash text-danger" title="Delete"></i>
              </td>
              <td><?= htmlspecialchars($cashOut['created_by_name']); ?></td>
              <td><?= htmlspecialchars($cashOut['cashout_date']); ?></td>
              <td><?= htmlspecialchars($cashOut['expense_details']); ?></td>
              <td><?= htmlspecialchars($cashOut['expense_category']); ?></td>
              <td>₱<?= number_format($cashOut['amount'], 2); ?></td>
            </tr>
          <?php endforeach; ?>
          <tr class="total-row">
            <td colspan="4"></td>
            <td>Total:</td>
            <td class="amount-red">₱<?= number_format(array_sum(array_column($cashOutRecords, 'amount')), 2); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Add Cash In Modal -->
  <div class="modal fade" id="addCashInModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="collection.php">
        <div class="modal-header">
          <h5 class="modal-title">Add Cash In</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action_type" value="add_cash_in">
          <label for="collection_date" class="form-label">Date</label>
          <input type="date" name="collection_date" class="form-control mb-3" required>
          <label for="amount" class="form-label">Amount</label>
          <input type="number" name="amount" class="form-control mb-3" placeholder="Enter Amount" required>
          <label for="school_year_id" class="form-label">School Year</label>
          <select name="school_year_id" class="form-select mb-3" required>
            <option value="">Select School Year</option>
            <?php foreach ($schoolYears as $year): ?>
              <option value="<?= $year['school_year_id']; ?>"><?= $year['school_year']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Add Cash Out Modal -->
  <div class="modal fade" id="addCashOutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="collection.php">
        <div class="modal-header">
          <h5 class="modal-title">Add Cash Out</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action_type" value="add_cash_out">
          <label for="cashout_date" class="form-label">Date</label>
          <input type="date" name="cashout_date" class="form-control mb-3" required>
          <label for="amount" class="form-label">Amount</label>
          <input type="number" name="amount" class="form-control mb-3" placeholder="Enter Amount" required>
          <label for="expense_details" class="form-label">Details</label>
          <input type="text" name="expense_details" class="form-control mb-3" placeholder="Enter Details" required>
          <label for="expense_category" class="form-label">Category</label>
          <input type="text" name="expense_category" class="form-control mb-3" placeholder="Enter Category" required>
          <label for="school_year_id" class="form-label">School Year</label>
          <select name="school_year_id" class="form-select mb-3" required>
            <option value="">Select School Year</option>
            <?php foreach ($schoolYears as $year): ?>
              <option value="<?= $year['school_year_id']; ?>"><?= $year['school_year']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>

  <script>

    function applyYearFilter() {
      const selectedYear = document.getElementById('schoolYearFilter').value;
      window.location.href = `?school_year_id=${selectedYear}`;
    }

    
  </script>
</body>
</html>