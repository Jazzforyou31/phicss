<?php
require '../../classes/collectionClass.php';

$collectionObj = new CollectionClass();
$schoolYears = $collectionObj->fetchSchoolYears();
$schoolYearId = isset($_GET['schoolYear']) ? $_GET['schoolYear'] : null;
$collections = $collectionObj->fetchAllCollections($schoolYearId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Total Collection</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <style>
        .collection-container {
            padding: 40px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .collection-box {
            width: 30%;
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
            text-align: center;
            transition: transform 0.3s;
        }

        .collection-box:hover {
            transform: scale(1.05);
        }

        .collection-box h5 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .collection-box p {
            font-size: 16px;
        }

        .plus-icon {
            font-size: 22px;
            color: #28a745;
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
        }

        .total-box {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .btn-primary {
            margin-top: 20px;
        }

        .header {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container collection-container">
    <div class="header d-flex justify-content-between align-items-center mb-4">
        <h2>Total Collection Records</h2>
        <div class="d-flex align-items-center gap-2">
            <form action="" method="GET">
                <select name="schoolYear" id="schoolYearFilter" class="form-select" style="width: 200px;" onchange="this.form.submit()">
                    <option value="">All School Years</option>
                    <?php foreach ($schoolYears as $year): ?>
                        <option value="<?= $year['school_year_id'] ?>" <?= isset($schoolYearId) && $schoolYearId == $year['school_year_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($year['school_year']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
    </div>

    <div class="row">
        <?php if (!empty($collections)): ?>
            <?php foreach ($collections as $row): ?>
                <div class="collection-box">
                    <i class="fas fa-plus-circle plus-icon" data-type="membership" title="Add Payment"></i>
                    <h5>Membership Fee</h5>
                    <p>₱<?= number_format($row['total_membership_fee'], 2) ?></p>
                    <button class="btn btn-sm btn-outline-primary mt-2 edit-btn"
                        onclick='openEditModal({
                            id: <?= $row["id"] ?? 0 ?>,
                            amount: <?= $row["total_membership_fee"] ?? 0 ?>,
                            multiply: 1
                        })'>Edit</button>
                </div>
                <div class="collection-box">
                    <i class="fas fa-plus-circle plus-icon" data-type="loyalty" title="Add Payment"></i>
                    <h5>Loyalty Fee</h5>
                    <p>₱<?= number_format($row['total_loyalty_fee'], 2) ?></p>
                    <button class="btn btn-sm btn-outline-primary mt-2 edit-btn"
                        onclick='openEditModal({
                            id: <?= $row["id"] ?? 0 ?>,
                            amount: <?= $row["total_loyalty_fee"] ?? 0 ?>,
                            multiply: 1
                        })'>Edit</button>
                </div>
                <div class="collection-box">
                    <i class="fas fa-plus-circle plus-icon" data-type="tech_fair" title="Add Payment"></i>
                    <h5>Tech Fair Fee</h5>
                    <p>₱<?= number_format($row['total_tech_fair_fee'], 2) ?></p>
                    <button class="btn btn-sm btn-outline-primary mt-2 edit-btn"
                        onclick='openEditModal({
                            id: <?= $row["id"] ?? 0 ?>,
                            amount: <?= $row["total_loyalty_fee"] ?? 0 ?>,
                            multiply: 1
                        })'>Edit</button>
                </div>
                <div class="collection-box">
                    <i class="fas fa-plus-circle plus-icon" data-type="project" title="Add Payment"></i>
                    <h5>Project Fee</h5>
                    <p>₱<?= number_format($row['total_project_fee'], 2) ?></p>
                    <button class="btn btn-sm btn-outline-primary mt-2 edit-btn"
                        onclick='openEditModal({
                            id: <?= $row["id"] ?? 0 ?>,
                            amount: <?= $row["total_loyalty_fee"] ?? 0 ?>,
                            multiply: 1
                        })'>Edit</button>
                </div>
                <div class="collection-box">
                    <i class="fas fa-plus-circle plus-icon" data-type="assembly" title="Add Payment"></i>
                    <h5>Faculty-Student Assembly</h5>
                    <p>₱<?= number_format($row['total_faculty_student_assembly'], 2) ?></p>
                    <button class="btn btn-sm btn-outline-primary mt-2 edit-btn"
                        onclick='openEditModal({
                            id: <?= $row["id"] ?? 0 ?>,
                            amount: <?= $row["total_loyalty_fee"] ?? 0 ?>,
                            multiply: 1
                        })'>Edit</button>
                </div>
                <div class="collection-box total-box">
                    <h5>Grand Total</h5>
                    <p>₱<?= number_format($row['grand_total'], 2) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="collection-box">
                <p>No collection data available.</p>
            </div>
        <?php endif; ?>
    </div>
</div>



<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Add Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="paymentTypeHidden" name="payment_type">
                    
                    <div class="form-group mb-3">
                        <label for="paymentAmount">Amount</label>
                        <input type="number" class="form-control" id="paymentAmount" name="payment_amount" placeholder="Enter Amount" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="multiplyBy">Multiply By</label>
                        <input type="number" class="form-control" id="multiplyBy" name="multiply_by" placeholder="e.g. 10" value="1" min="1" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Total Amount</label>
                        <input type="text" class="form-control" id="totalAmount" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Collection</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Collection Modal -->
<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="POST" id="editPaymentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentModalLabel">Edit Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Hidden ID for updating the correct record -->
                    <input type="hidden" id="editPaymentId" name="payment_id">

                    <div class="form-group mb-3">
                        <label for="editPaymentAmount">Amount</label>
                        <input type="number" class="form-control" id="editPaymentAmount" name="payment_amount" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="editMultiplyBy">Multiply By</label>
                        <input type="number" class="form-control" id="editMultiplyBy" name="multiply_by" min="1" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Total Amount</label>
                        <input type="text" class="form-control" id="editTotalAmount" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Collection</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    // Open modal when plus icon is clicked
    document.querySelectorAll('.plus-icon').forEach(icon => {
        icon.addEventListener('click', function () {
            const type = this.getAttribute('data-type');
            document.getElementById('paymentTypeHidden').value = type;
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        });
    });


    // Handle form submission
    const amountInput = document.getElementById('paymentAmount');
    const multiplyInput = document.getElementById('multiplyBy');
    const totalField = document.getElementById('totalAmount');

    function updateTotal() {
        const amount = parseFloat(amountInput.value) || 0;
        const multiplier = parseInt(multiplyInput.value) || 1;
        const total = amount * multiplier;
        totalField.value = `₱${total.toFixed(2)}`;
    }

    amountInput.addEventListener('input', updateTotal);
    multiplyInput.addEventListener('input', updateTotal);

    // Handle form submission for edit collection
    const editAmountInput = document.getElementById('editPaymentAmount');
    const editMultiplyInput = document.getElementById('editMultiplyBy');
    const editTotalField = document.getElementById('editTotalAmount');

    function updateEditTotal() {
        const amount = parseFloat(editAmountInput.value) || 0;
        const multiplier = parseInt(editMultiplyInput.value) || 1;
        const total = amount * multiplier;
        editTotalField.value = `₱${total.toFixed(2)}`;
    }

    editAmountInput.addEventListener('input', updateEditTotal);
    editMultiplyInput.addEventListener('input', updateEditTotal);

    // Optional: Populate edit modal with values
    function openEditModal(data) {
        document.getElementById('editPaymentId').value = data.id;
        editAmountInput.value = data.amount;
        editMultiplyInput.value = data.multiply;
        updateEditTotal();
        $('#editPaymentModal').modal('show');
    }


</script>
</body>
</html>
