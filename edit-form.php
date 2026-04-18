<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['mahasiswa'])) {
    $_SESSION['mahasiswa'] = [];
}

$studentId = isset($_GET['id']) ? (int) $_GET['id'] : (int) ($_POST['id'] ?? -1);

if (!isset($_SESSION['mahasiswa'][$studentId])) {
    header('Location: index.php');
    exit();
}

$currentStudent = $_SESSION['mahasiswa'][$studentId];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa - EduFlow</title>
    <link rel="stylesheet" href="./public/style/output.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus+Jakarta+Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col md:flex-row">
    <!-- Sidebar -->
    <aside class="w-full md:w-72 bg-white border-r border-slate-200 p-6 flex flex-col shrink-0">
        <div class="flex items-center gap-3 px-2 mb-10">
            <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
            </div>
            <span class="font-bold text-xl tracking-tight">Management Mahasiswa</span>
        </div>
        <nav class="flex-grow space-y-2 text-slate-600 font-semibold">
            <a href="index.php" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl hover:bg-slate-100 transition-all">Data Mahasiswa</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow p-6 md:p-10">
        <div class="max-w-3xl mx-auto">
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Mahasiswa</h2>
                <p class="text-slate-500 mt-1">Ubah informasi mahasiswa terpilih.</p>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                <form action="controller/update-student.php?id=<?= $studentId ?>" method="post" enctype="multipart/form-data" class="space-y-8">
                    <input type="hidden" name="id" value="<?= $studentId ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                            <input type="text" name="fullName" value="<?= htmlspecialchars($currentStudent['nama'], ENT_QUOTES, 'UTF-8') ?>" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-slate-500/10 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">NIM</label>
                            <input type="text" name="nim" value="<?= htmlspecialchars($currentStudent['nim'], ENT_QUOTES, 'UTF-8') ?>" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-slate-500/10 outline-none transition-all">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Jurusan</label>
                            <select name="jurusan" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-slate-500/10 outline-none transition-all appearance-none cursor-pointer">
                                <option <?= $currentStudent['jurusan'] === 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                                <option <?= $currentStudent['jurusan'] === 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-sm font-bold text-slate-700 ml-1">Foto Profil</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-[2rem] p-10 flex flex-col items-center justify-center text-center hover:bg-slate-100 transition-all cursor-pointer relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            <p class="font-bold text-slate-700 text-sm">Klik atau seret foto baru jika ingin mengganti</p>
                            <input type="file" name="fileUpload" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>
                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-grow bg-slate-900 hover:bg-slate-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-slate-300 transition-all">Simpan Perubahan</button>
                        <a href="index.php" class="px-8 py-4 bg-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-300 text-center">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>