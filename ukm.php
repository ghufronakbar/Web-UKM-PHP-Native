<?php
include_once 'utils/layout.php';
include_once 'utils/db.php'; 

$stmt = $pdo->query("SELECT * FROM ukm ORDER BY id DESC");
$ukmData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="max-w-7xl mx-auto">
    <div class="w-full flex flex-row justify-between items-center mb-8">
        <h2 class="text-4xl font-semibold mb-4">Daftar UKM</h2>
        <a href="add.php" class="bg-green-600 text-white p-2 rounded-md">Tambah UKM</a>
    </div>
    
    <table class="min-w-full table-auto border-collapse">
        <thead>
            <tr>
                <th class="px-4 py-2 border text-left">No.</th>
                <th class="px-4 py-2 border text-left"></th>
                <th class="px-4 py-2 border text-left">Nama</th>
                <th class="px-4 py-2 border text-left">Penanggung Jawab</th>
                <th class="px-4 py-2 border text-left">Tanggal Berdiri</th>
                <th class="px-4 py-2 border text-left">Status</th>
                <th class="px-4 py-2 border text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($ukmData as $ukm) :                
                $logoPath = $ukm['logo'] ? './public/images/' . $ukm['logo'] : './static/images/placeholder.jpeg';
            ?>
            <tr>
                <td class="px-4 py-2 border text-center"><?= $no++ ?></td>
                <td class="px-4 py-2 border text-center">
                    <div class="w-12 h-12 mx-auto">
                        <img src="<?= $logoPath ?>" alt="Logo" class="min-w-12 min-h-12 w-12 h-12 object-cover rounded-full">
                    </div>
                </td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($ukm['nama']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($ukm['penanggung_jawab']) ?></td>
                <td class="px-4 py-2 border"><?= date('d-m-Y', strtotime($ukm['tanggal_berdiri'])) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($ukm['status']) ?></td>
                <td class="px-4 py-2 border text-center">                    
                    <a href="edit.php?id=<?= $ukm['id'] ?>" class="bg-blue-500 text-white px-3 py-1 rounded-md">Edit</a>
                    <a href="delete.php?id=<?= $ukm['id'] ?>" class="bg-red-500 text-white px-3 py-1 rounded-md ml-2" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main>
</body>
</html>
