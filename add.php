<?php
include_once 'utils/layout.php';
include_once 'utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $slug = strtolower(preg_replace('/\s+/', '-', $nama));
    $deskripsi = $_POST['deskripsi'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $tanggal_berdiri = $_POST['tanggal_berdiri'];
    $status = $_POST['status'];
    $logo = $_FILES['logo']['name'] ? $_FILES['logo']['name'] : null;

    if ($logo) {
        move_uploaded_file($_FILES['logo']['tmp_name'], "public/images/" . $logo);
    }

    $stmt = $pdo->prepare("INSERT INTO ukm (nama, slug, deskripsi, penanggung_jawab, tanggal_berdiri, status, logo) 
                           VALUES (:nama, :slug, :deskripsi, :penanggung_jawab, :tanggal_berdiri, :status, :logo)");
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':penanggung_jawab', $penanggung_jawab);
    $stmt->bindParam(':tanggal_berdiri', $tanggal_berdiri);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':logo', $logo);
    $stmt->execute();

    header("Location: ukm.php");
    exit;
}
?>

<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Tambah Data UKM</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama" class="block">Nama UKM</label>
            <input type="text" name="nama" id="nama" class="w-full p-2 border rounded-md" required onChange="updateSlug()" placeholder="Masukkan nama UKM">
        </div>
        <div class="mb-4">
            <label for="slug" class="block">Slug</label>
            <input type="text" name="slug" id="slug" class="w-full p-2 border rounded-md" disabled>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="w-full p-2 border rounded-md"></textarea>
        </div>
        <div class="mb-4">
            <label for="penanggung_jawab" class="block">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" id="penanggung_jawab" class="w-full p-2 border rounded-md">
        </div>
        <div class="mb-4">
            <label for="tanggal_berdiri" class="block">Tanggal Berdiri</label>
            <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="w-full p-2 border rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="status" class="block">Status</label>
            <select name="status" id="status" class="w-full p-2 border rounded-md" required>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Non-Aktif</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="logo" class="block">Logo UKM</label>
            <input type="file" name="logo" id="logo" class="w-full p-2 border rounded-md" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded-md">Simpan</button>
    </form>
</div>

<script>
    function updateSlug() {
        const nama = document.getElementById('nama').value;
        const slug = nama.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '');
        document.getElementById('slug').value = slug;
    }
</script>