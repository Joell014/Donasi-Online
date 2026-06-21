<?php
include "config/koneksi.php";

$campaign = mysqli_query($conn,"
SELECT * FROM campaign
ORDER BY id DESC
LIMIT 6
");
?><!DOCTYPE html><html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"><title>PeduliSesama - Donasi Online</title><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-gray-50"><!-- NAVBAR --><nav class="bg-white shadow sticky top-0 z-50"><div class="container mx-auto px-6 py-4 flex justify-between items-center"><div class="flex items-center gap-3"><img src="assets/logo.png"
class="w-12 h-12 object-contain">

<h1 class="text-2xl font-bold text-blue-700">
PeduliSesama
</h1></div><div class="space-x-3"><a href="login.php"
class="px-5 py-2 text-blue-600 font-semibold">
Login
</a>

<a href="register.php"
class="bg-blue-600 text-white px-5 py-2 rounded-xl">
Daftar
</a>

</div></div></nav><!-- HERO --><section class="bg-gradient-to-r from-blue-700 to-cyan-500 text-white"><div class="container mx-auto px-6 py-20"><div class="grid md:grid-cols-2 gap-12 items-center"><div><span class="bg-white text-blue-700 px-4 py-2 rounded-full font-bold">
#MariBerbagi
</span><h1 class="text-5xl font-bold mt-6 leading-tight">
Donasi Mudah Untuk Membantu Mereka Yang Membutuhkan
</h1><p class="mt-6 text-lg">
Platform donasi online yang aman, transparan, dan terpercaya.
</p><div class="mt-8 flex gap-4"><a href="register.php"
class="bg-white text-blue-700 px-6 py-3 rounded-xl font-bold">
Mulai Berdonasi
</a>

<a href="#campaign"
class="border border-white px-6 py-3 rounded-xl">
Lihat Campaign
</a>

</div></div><div><img
src="assets/hero-donasi.jpg"
class="w-full h-[500px] object-cover rounded-3xl shadow-2xl">

</div></div></div></section><!-- STATISTIK --><section class="py-16 bg-white"><div class="container mx-auto px-6"><div class="grid md:grid-cols-4 gap-6"><div class="bg-blue-50 p-6 rounded-xl text-center"><h2 class="text-4xl font-bold text-blue-600">
1000+
</h2><p>Donatur Aktif</p></div><div class="bg-green-50 p-6 rounded-xl text-center"><h2 class="text-4xl font-bold text-green-600">
250JT+
</h2><p>Total Donasi</p></div><div class="bg-yellow-50 p-6 rounded-xl text-center"><h2 class="text-4xl font-bold text-yellow-600">
150+
</h2><p>Campaign</p></div><div class="bg-red-50 p-6 rounded-xl text-center"><h2 class="text-4xl font-bold text-red-600">
98%
</h2><p>Campaign Sukses</p></div></div></div></section><!-- KATEGORI --><section class="py-16 bg-gray-100"><div class="container mx-auto px-6"><h2 class="text-4xl font-bold text-center mb-10">
Kategori Donasi
</h2><div class="grid md:grid-cols-6 gap-4"><div class="bg-white p-6 rounded-xl shadow text-center">
🌊
<p class="mt-2">Bencana</p>
</div><div class="bg-white p-6 rounded-xl shadow text-center">
🎓
<p class="mt-2">Pendidikan</p>
</div><div class="bg-white p-6 rounded-xl shadow text-center">
🏥
<p class="mt-2">Kesehatan</p>
</div><div class="bg-white p-6 rounded-xl shadow text-center">
🏠
<p class="mt-2">Panti</p>
</div><div class="bg-white p-6 rounded-xl shadow text-center">
🕌
<p class="mt-2">Ibadah</p>
</div><div class="bg-white p-6 rounded-xl shadow text-center">
🌳
<p class="mt-2">Lingkungan</p>
</div></div></div></section><!-- CAMPAIGN --><section id="campaign" class="py-20"><div class="container mx-auto px-6"><h2 class="text-4xl font-bold text-center mb-12">
Campaign Populer
</h2><div class="grid md:grid-cols-3 gap-8"><?php while($c=mysqli_fetch_assoc($campaign)){ ?><div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition"><img
src="uploads/<?= $c['gambar']; ?>"
class="w-full h-56 object-cover">

<div class="p-5"><h3 class="text-xl font-bold">
<?= $c['judul']; ?>
</h3><p class="mt-3 text-gray-600">
<?= substr($c['deskripsi'],0,100); ?>...
</p><div class="mt-4"><div class="w-full bg-gray-200 h-3 rounded-full"><div
class="bg-green-500 h-3 rounded-full"
style="width:<?= min(($c['terkumpul']/$c['target'])*100,100); ?>%">
</div></div><p class="mt-2 text-sm">Terkumpul:
<b>
Rp <?= number_format($c['terkumpul'],0,',','.'); ?>
</b>

</p></div><a
href="login.php"
class="block text-center bg-blue-600 text-white py-3 mt-4 rounded-xl">

Donasi Sekarang

</a></div></div><?php } ?></div></div></section><!-- CARA DONASI --><section class="bg-white py-20"><div class="container mx-auto px-6"><h2 class="text-center text-4xl font-bold mb-12">
Cara Berdonasi
</h2><div class="grid md:grid-cols-3 gap-8"><div class="bg-gray-50 p-8 rounded-xl shadow text-center"><div class="text-5xl">
1️⃣
</div><h3 class="mt-4 text-xl font-bold">
Pilih Campaign
</h3></div><div class="bg-gray-50 p-8 rounded-xl shadow text-center"><div class="text-5xl">
2️⃣
</div><h3 class="mt-4 text-xl font-bold">
Transfer Donasi
</h3></div><div class="bg-gray-50 p-8 rounded-xl shadow text-center"><div class="text-5xl">
3️⃣
</div><h3 class="mt-4 text-xl font-bold">
Verifikasi Admin
</h3></div></div></div></section><!-- TESTIMONI --><section class="bg-gray-100 py-20"><div class="container mx-auto px-6"><h2 class="text-4xl font-bold text-center mb-12">
Apa Kata Mereka?
</h2><div class="grid md:grid-cols-3 gap-8"><div class="bg-white p-6 rounded-xl shadow">⭐⭐⭐⭐⭐

<p class="mt-4">
Sangat membantu dan mudah digunakan.
</p></div><div class="bg-white p-6 rounded-xl shadow">⭐⭐⭐⭐⭐

<p class="mt-4">
Donasi lebih transparan dan aman.
</p></div><div class="bg-white p-6 rounded-xl shadow">⭐⭐⭐⭐⭐

<p class="mt-4">
Campaign yang tersedia sangat beragam.
</p></div></div></div></section><!-- FOOTER --><footer class="bg-slate-900 text-white py-12"><div class="container mx-auto px-6"><div class="grid md:grid-cols-3 gap-8"><div><h3 class="text-2xl font-bold">
PeduliSesama
</h3><p class="mt-3">
Platform donasi online terpercaya.
</p></div><div><h3 class="font-bold mb-4">
Menu
</h3><ul class="space-y-2"><li>Beranda</li>
<li>Campaign</li>
<li>Login</li>
<li>Register</li></ul></div><div><h3 class="font-bold mb-4">
Kontak
</h3><p>Email : info@pedulisesama.com</p>
<p>Telp : 08123456789</p></div></div><hr class="my-8 border-gray-700"><p class="text-center">
© 2026 PeduliSesama. All Rights Reserved.
</p></div></footer></body>
</html>