<?php
include_once 'utils/layout.php';
include_once 'utils/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM ukm WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $ukm = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ukm) {
        echo "Data tidak ditemukan!";
        header("Location: ukm.php");
        exit;
    }
}else{
    header("Location: ukm.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $nama = $_POST['nama'];
    $slug = strtolower(preg_replace('/\s+/', '-', $nama));
    $deskripsi = $_POST['deskripsi'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $tanggal_berdiri = $_POST['tanggal_berdiri'];
    $status = $_POST['status'];
    $logo = $_FILES['logo']['name'] ? $_FILES['logo']['name'] : $ukm['logo'];

    if ($_FILES['logo']['name']) {
        move_uploaded_file($_FILES['logo']['tmp_name'], "public/images/" . $logo);
    }

    $stmt = $pdo->prepare("UPDATE ukm SET nama = :nama, slug = :slug, deskripsi = :deskripsi, penanggung_jawab = :penanggung_jawab, tanggal_berdiri = :tanggal_berdiri, status = :status, logo = :logo WHERE id = :id");
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':penanggung_jawab', $penanggung_jawab);
    $stmt->bindParam(':tanggal_berdiri', $tanggal_berdiri);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':logo', $logo);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: ukm.php");
    exit;
}

?>

<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Edit Data UKM</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama" class="block">Nama UKM</label>
            <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($ukm['nama']) ?>" class="w-full p-2 border rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="slug" class="block">Slug</label>
            <input type="text" name="slug" id="slug" value="<?= htmlspecialchars($ukm['slug']) ?>" class="w-full p-2 border rounded-md" disabled>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="w-full p-2 border rounded-md"><?= htmlspecialchars($ukm['deskripsi']) ?></textarea>
        </div>
        <div class="mb-4">
            <label for="penanggung_jawab" class="block">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" id="penanggung_jawab" value="<?= htmlspecialchars($ukm['penanggung_jawab']) ?>" class="w-full p-2 border rounded-md">
        </div>
        <div class="mb-4">
            <label for="tanggal_berdiri" class="block">Tanggal Berdiri</label>
            <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" value="<?= $ukm['tanggal_berdiri'] ?>" class="w-full p-2 border rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="status" class="block">Status</label>
            <select name="status" id="status" class="w-full p-2 border rounded-md" required>
                <option value="Aktif" <?= $ukm['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="Tidak Aktif" <?= $ukm['status'] == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="logo" class="block">Logo UKM</label>
            <input type="file" name="logo" id="logo" class="w-full p-2 border rounded-md">
            <img src="<?= $ukm['logo'] ? './public/images/' . $ukm['logo'] : './static/images/placeholder.jpeg' ?>" alt="Logo" class="w-20 mt-2">
            
        </div>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded-md">Simpan</button>
    </form>
</div>

</main>
</body>

</html>