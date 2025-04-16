<?php
include_once '../../includes/header.php';
require_once '../../classes/TransparencyClass.php'; // Include the TransparencyClass
require_once '../../classes/CollectionClass.php';

$transparency = new TransparencyClass();
$sections = $transparency->fetchSections();


$collection = new CollectionClass();

$schoolYearId = isset($_GET['school_year_id']) ? $_GET['school_year_id'] : null;
$collectionSummary = $collection->fetchAllCollections($schoolYearId);


// Grand total and fee breakdown
$grandTotal = 0;
$fees = [
    'Membership Fee' => 0,
    'Loyalty Fee' => 0,
    'Tech Fair Fee' => 0,
    'Project Fee' => 0,
    'Assembly Fee' => 0,
];

if (!empty($collectionSummary)) {
    foreach ($collectionSummary as $record) {
        $grandTotal += $record['grand_total'];
        $fees['Membership Fee'] += $record['total_membership_fee'];
        $fees['Loyalty Fee'] += $record['total_loyalty_fee'];
        $fees['Tech Fair Fee'] += $record['total_tech_fair_fee'];
        $fees['Project Fee'] += $record['total_project_fee'];
        $fees['Assembly Fee'] += $record['total_faculty_student_assembly'];
    }
}
?>  
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>css/transparency.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>
    <h1>Transparency Page <span class="fy-year"><a href="#">| S.Y 2025-2026</a></span></h1>

    <div class="sidebar">
        <p><a href="#">See also:</a></p>
        <p>Transparency Page <br>
        <a href="#">2023-2024</a><br><a href="#">2024-2025</a><br><a href="#">2025-2026</a></p>
    </div>

   <!-- Include Chart.js from CDN -->


   <section class="collection-summary">
    <div class="container">
        <h2>Phicss Collection Summary</h2>

        <div class="collection-content">
            <!-- Chart Area -->
            <div class="chart-box">
                <canvas id="collectionChart"></canvas>
            </div>

            <!-- Grand Total Card -->
            <div class="total-summary">
                <h3>Grand Total</h3>
                <p class="grand-amount">₱<?php echo number_format($grandTotal, 2); ?></p>
                <ul class="fee-breakdown">
                    <?php foreach ($fees as $feeName => $amount): ?>
                        <li><span><?php echo $feeName; ?>:</span> ₱<?php echo number_format($amount, 2); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>


    <hr>

    <div class="content">
        <?php if (!empty($sections)) : ?>
            <?php 
            $sectionNumber = 1; // Initialize section number
            foreach ($sections as $section) : ?>
                <div class="section">
                    <p class="section-title"><?php echo $sectionNumber . ". " . htmlspecialchars($section['section_title']); ?></p>
                    <ul>
                        <?php 
                        $links = $transparency->fetchLinksBySection($section['id']); 
                        if (!empty($links)) :
                            foreach ($links as $link) : ?>
                                <li><a href="<?php echo htmlspecialchars($link['document_link']); ?>" target="_blank">
                                    <?php echo htmlspecialchars($link['document_title']); ?>
                                </a></li>
                            <?php endforeach;
                        else: ?>
                            <li>No documents available.</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php $sectionNumber++; // Increment section number ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No transparency data available.</p>
        <?php endif; ?>
    </div>
</body>

<?php include_once '../../includes/footer.php'; ?>

<script>
  const ctx = document.getElementById('collectionChart').getContext('2d');
  const collectionChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Membership Fee', 'Loyalty Fee', 'Tech Fair Fee', 'Project Fee', 'Assembly Fee'],
      datasets: [{
        label: 'Fees',
        data: <?php echo json_encode(array_values($fees)); ?>,
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
        borderColor: '#fff',
        borderWidth: 2
      }]
    },
    options: {
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });
</script>