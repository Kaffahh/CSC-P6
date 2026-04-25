<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: ../login.php');
    exit();
}

$nama = trim($_POST['fullName'] ?? '');
$nim = trim($_POST['nim'] ?? '');
$prodiId = (int) ($_POST['prodi_id'] ?? 0);
$avatar = $nama;

if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
    $uploadDirectory = __DIR__ . '/../public/images/uploads/';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileExtension = strtolower(pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($fileExtension, $allowedExtensions, true)) {
        $fileName = uniqid('student_', true) . '.' . $fileExtension;
        $targetPath = $uploadDirectory . $fileName;

        if (move_uploaded_file($_FILES['fileUpload']['tmp_name'], $targetPath)) {
            $avatar = 'public/images/uploads/' . $fileName;
        }
    }
}

if ($nama !== '' && $nim !== '' && $prodiId > 0) {
    dbExecute(
        'INSERT INTO mahasiswa (nama, nim, prodi_id, avatar) VALUES (:nama, :nim, :prodi_id, :avatar)',
        [
            ':nama' => $nama,
            ':nim' => $nim,
            ':prodi_id' => $prodiId,
            ':avatar' => $avatar,
        ]
    );
}

header('Location: ../index.php');
exit();
