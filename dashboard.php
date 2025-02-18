<?php
include_once 'utils/layout.php';
include_once 'utils/db.php';

$stmtActive = $pdo->prepare("SELECT COUNT(*) FROM ukm WHERE status = 'aktif'");
$stmtActive->execute();
$activeCount = $stmtActive->fetchColumn();

$stmtInactive = $pdo->prepare("SELECT COUNT(*) FROM ukm WHERE status = 'non-aktif'");
$stmtInactive->execute();
$inactiveCount = $stmtInactive->fetchColumn();

$stmtRecentUKM = $pdo->prepare("SELECT nama, tanggal_berdiri FROM ukm ORDER BY tanggal_berdiri DESC LIMIT 5");
$stmtRecentUKM->execute();
$recentUKMs = $stmtRecentUKM->fetchAll(PDO::FETCH_ASSOC);

$stmtAdmin = $pdo->prepare("SELECT nama, email FROM admin WHERE id = :id");
$stmtAdmin->bindParam(':id', $_SESSION['admin_id']);
$stmtAdmin->execute();
$admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

?>

<div class="max-w-7xl mx-auto mt-6">
    <h2 class="text-4xl font-semibold mb-4">Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?></h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Statistik UKM</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center">
                    <p class="text-2xl font-bold"><?= $activeCount ?></p>
                    <p class="text-gray-500">UKM Aktif</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold"><?= $inactiveCount ?></p>
                    <p class="text-gray-500">UKM Non-Aktif</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">UKM Terbaru</h3>
            <ul>
                <?php foreach ($recentUKMs as $ukm): ?>
                    <li class="mb-2">
                        <p class="text-gray-800 font-semibold"><?= htmlspecialchars($ukm['nama']) ?></p>
                        <p class="text-gray-500 text-sm"><?= date('d M Y', strtotime($ukm['tanggal_berdiri'])) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Informasi Admin</h3>
            <p class="text-gray-800 font-semibold"><?= htmlspecialchars($admin['nama']) ?></p>
            <p class="text-gray-500"><?= htmlspecialchars($admin['email']) ?></p>
        </div>
        <div class="bg-white p-6 mt-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Statistik Status UKM</h3>
            <canvas id="statusChart"></canvas>
        </div>
    </div>    

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>    
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Aktif', 'Non-Aktif'],
            datasets: [{
                label: 'Status UKM',
                data: [<?= $activeCount ?>, <?= $inactiveCount ?>],
                backgroundColor: ['#4CAF50', '#FF5722'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>

</main>
</body>

</html>