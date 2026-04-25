<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
	header('Location: ../login.php');
	exit();
}

$studentId = isset($_GET['id']) ? (int) $_GET['id'] : -1;

if ($studentId > 0) {
	dbExecute('DELETE FROM mahasiswa WHERE id = :id', [':id' => $studentId]);
}

header('Location: ../index.php');
exit();
