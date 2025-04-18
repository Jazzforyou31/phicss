<?php
require '../../classes/collectionClass.php';
$collection = new CollectionClass();
$cashInRecords = $collection->fetchCashIn();
$cashOutRecords = $collection->fetchCashOut();
$totalCashIn = $collection->getTotalCashIn();
$totalCashOut = $collection->getTotalCashOut();
$netIncome = $totalCashIn - $totalCashOut;

$collections = $collection->fetchCollections(); // Fetch all
$filtered = $collection->fetchCollections(1); // Fetch only school year ID 3


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
<link rel="stylesheet" href="../../css/admin_collection.css">
<body>

  <div class="content">
    <header class="mb-4">
      <h1 class="header-title">Cash In/Out Management</h1>
      <p class="header-subtitle">Admin Panel</p>
    </header>


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
        <p class="amount-purple">
          ₱<?= number_format($netIncome, 2); ?>
        </p>
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
              <td><?= $cashIn['created_by_name']; ?></td>
              <td><?= $cashIn['collection_date']; ?></td>
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
              <td><?= $cashOut['created_by_name']; ?></td>
              <td><?= $cashOut['cashout_date']; ?></td>
              <td><?= $cashOut['expense_details']; ?></td>
              <td><?= $cashOut['expense_category']; ?></td>
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

 

  <script>
$(document).ready(function () {
  // Fetch school years for dropdown
  $.ajax({
    url: '../../ajax/getSchoolYears.php',
    method: 'GET',
    success: function (res) {
      if (res.success) {
        $('#schoolYearFilter').append(`<option value="">All</option>`);
        res.data.forEach(year => {
          $('#schoolYearFilter').append(`<option value="${year.school_year_id}">${year.school_year}</option>`);
        });
      }
    }
  });

  $('#applyFilter').on('click', function () {
    const selectedYear = $('#schoolYearFilter').val();

    // Redirect with filter as a GET parameter (for now, PHP will handle filtering)
    window.location.href = `?school_year_id=${selectedYear}`;
  });
});

</script>

</body>
</html>
