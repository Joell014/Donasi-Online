<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$totalUser = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM users WHERE role='user'")
);

$totalCampaign = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM campaign")
);

$totalDonasi = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM donasi")
);

$dataDana = mysqli_fetch_assoc(
    mysqli_query($conn,"
    SELECT SUM(nominal) as total
    FROM donasi
    WHERE status='diterima'
")
);

$totalDana = $dataDana['total'] ?? 0;

$chart = mysqli_query($conn,"
SELECT
campaign.judul,
IFNULL(SUM(donasi.nominal),0) as total
FROM campaign
LEFT JOIN donasi
ON campaign.id = donasi.campaign_id
AND donasi.status='diterima'
GROUP BY campaign.id
");

$label = [];
$data = [];

while($row = mysqli_fetch_assoc($chart)){
    $label[] = $row['judul'];
    $data[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Dashboard Admin</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->
    <div class="w-64 bg-blue-900 min-h-screen text-white p-5">

        <h2 class="text-2xl font-bold mb-6">
            ADMIN PANEL
        </h2>

        <ul class="space-y-3">

            <li>
                <a href="dashboard.php" class="hover:text-yellow-300">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="campaign.php" class="hover:text-yellow-300">
                    Campaign
                </a>
            </li>

            <li>
                <a href="kategori.php" class="hover:text-yellow-300">
                    Kategori
                </a>
            </li>

            <li>
                <a href="user.php" class="hover:text-yellow-300">
                    User
                </a>
            </li>

            <li>
                <a href="donasi.php" class="hover:text-yellow-300">
                    Verifikasi Donasi
                </a>
            </li>

            <li>
                <a href="cetak_pdf.php" target="_blank" class="hover:text-yellow-300">
                    📄 Cetak PDF
                </a>
            </li>

            <li>
                <a href="../logout.php" class="hover:text-red-300">
                    Logout
                </a>
            </li>

        </ul>

    </div>

    <!-- Content -->
    <div class="flex-1 p-6">

        <div class="flex justify-between items-center mb-6">

            <h1 class="text-3xl font-bold">
                Dashboard Admin
            </h1>

            <a href="cetak_pdf.php"
               target="_blank"
               class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-3 rounded-lg shadow transition">

                📄 Cetak PDF

            </a>

        </div>

        <div class="grid md:grid-cols-4 gap-5 mb-8">

            <div class="bg-white p-5 rounded shadow">

                <h3 class="text-gray-600">
                    Total User
                </h3>

                <p class="text-3xl font-bold text-blue-600">
                    <?= $totalUser ?>
                </p>

            </div>

            <div class="bg-white p-5 rounded shadow">

                <h3 class="text-gray-600">
                    Total Campaign
                </h3>

                <p class="text-3xl font-bold text-green-600">
                    <?= $totalCampaign ?>
                </p>

            </div>

            <div class="bg-white p-5 rounded shadow">

                <h3 class="text-gray-600">
                    Total Donasi
                </h3>

                <p class="text-3xl font-bold text-yellow-500">
                    <?= $totalDonasi ?>
                </p>

            </div>

            <div class="bg-white p-5 rounded shadow">

                <h3 class="text-gray-600">
                    Dana Terkumpul
                </h3>

                <p class="text-xl font-bold text-green-700">
                    Rp <?= number_format($totalDana,0,',','.') ?>
                </p>

            </div>

        </div>

        <!-- Grafik -->

        <div class="bg-white p-5 rounded shadow">

            <h2 class="text-xl font-bold mb-5">
                Statistik Donasi per Campaign
            </h2>

            <canvas id="donasiChart"></canvas>

        </div>

    </div>

</div>

<script>

const ctx = document.getElementById('donasiChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: <?= json_encode($label); ?>,

        datasets: [{
            label: 'Dana Terkumpul',
            data: <?= json_encode($data); ?>
        }]

    },

    options: {

        responsive: true,

        scales: {
            y: {
                beginAtZero: true
            }
        }

    }

});

</script>

</body>
</html>