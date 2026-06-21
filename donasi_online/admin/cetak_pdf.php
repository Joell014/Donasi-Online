<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query($conn,"
SELECT
d.id,
u.nama,
c.judul,
d.nominal,
d.status,
d.tanggal
FROM donasi d
JOIN users u ON d.user_id=u.id
JOIN campaign c ON d.campaign_id=c.id
ORDER BY d.tanggal DESC
");

$total = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT SUM(nominal) AS total
FROM donasi
WHERE status='diterima'
")
);

$totalDana = $total['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Laporan Donasi</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>

@media print{

button{
display:none;
}

}

</style>

</head>

<body class="bg-gray-100 p-8">

<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-8">

<div class="flex justify-between items-center mb-6">

<div>

<h1 class="text-3xl font-bold">
LAPORAN DONASI ONLINE
</h1>

<p class="text-gray-500">
Tanggal Cetak :
<?= date("d-m-Y H:i:s") ?>
</p>

</div>

<div>

<button
onclick="window.print()"
class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-lg">

📄 Cetak / Save PDF

</button>

</div>

</div>

<div class="grid grid-cols-4 gap-4 mb-6">

<div class="bg-blue-100 rounded-lg p-4">

<h3 class="font-semibold">
Total Dana Diterima
</h3>

<p class="text-2xl font-bold text-blue-700">

Rp <?= number_format($totalDana,0,',','.') ?>

</p>

</div>

</div>

<div class="overflow-x-auto">

<table class="w-full border border-gray-300">

<thead class="bg-blue-800 text-white">

<tr>

<th class="p-3 border">No</th>

<th class="p-3 border">Donatur</th>

<th class="p-3 border">Campaign</th>

<th class="p-3 border">Nominal</th>

<th class="p-3 border">Status</th>

<th class="p-3 border">Tanggal</th>

</tr>

</thead>

<tbody>

<?php
$no=1;

while($row=mysqli_fetch_assoc($query)){
?>

<tr class="text-center hover:bg-gray-100">

<td class="border p-2">
<?= $no++ ?>
</td>

<td class="border p-2">
<?= $row['nama'] ?>
</td>

<td class="border p-2">
<?= $row['judul'] ?>
</td>

<td class="border p-2">

Rp <?= number_format($row['nominal'],0,',','.') ?>

</td>

<td class="border p-2">

<?= ucfirst($row['status']) ?>

</td>

<td class="border p-2">

<?= $row['tanggal'] ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div class="mt-12 text-right">

<p>Administrator</p>

<br><br><br>

<p><b><?= $_SESSION['nama'] ?? "Admin" ?></b></p>

</div>

</div>

<script>

window.onload=function(){

window.print();

}

</script>

</body>
</html>