<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "website_donasi";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Membuat objek PDF
$dompdf = new Dompdf();

// Ambil data donasi
$query = mysqli_query($conn, "SELECT * FROM donasi ORDER BY id_donasi DESC");

// Membuat HTML
$html = '
<!DOCTYPE html>
<html>
<head>
<style>
body{
    font-family: Arial, sans-serif;
    font-size:12px;
}
h2{
    text-align:center;
}
table{
    width:100%;
    border-collapse:collapse;
}
table th, table td{
    border:1px solid black;
    padding:8px;
    text-align:center;
}
th{
    background:#e5e5e5;
}
</style>
</head>
<body>

<h2>LAPORAN DONASI ONLINE</h2>

<table>
<tr>
<th>No</th>
<th>ID Donasi</th>
<th>Nama Donatur</th>
<th>Nominal</th>
<th>Status</th>
<th>Tanggal</th>
</tr>
';

$no = 1;
$total = 0;

while($row = mysqli_fetch_assoc($query)){

    $total += $row['nominal'];

    $html .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.$row['id_donasi'].'</td>
        <td>'.$row['nama'].'</td>
        <td>Rp '.number_format($row['nominal'],0,",",".").'</td>
        <td>'.$row['status'].'</td>
        <td>'.$row['tanggal'].'</td>
    </tr>
    ';
}

$html .= '
<tr>
<td colspan="3"><b>Total Donasi</b></td>
<td colspan="3"><b>Rp '.number_format($total,0,",",".").'</b></td>
</tr>
</table>

<br><br>

<div style="text-align:right;">
Dicetak pada: '.date("d-m-Y H:i:s").'
</div>

</body>
</html>
';

// Generate PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Tampilkan di browser
$dompdf->stream("Laporan_Donasi.pdf", ["Attachment" => false]);
?>