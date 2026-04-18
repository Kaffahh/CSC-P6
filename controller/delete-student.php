<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
	header('Location: ../login.php');
	exit();
}

if (!isset($_SESSION['mahasiswa'])) {
	$_SESSION['mahasiswa'] = [];
}

$studentId = isset($_GET['id']) ? (int) $_GET['id'] : -1;

if (isset($_SESSION['mahasiswa'][$studentId])) {
	unset($_SESSION['mahasiswa'][$studentId]);
	$_SESSION['mahasiswa'] = array_values($_SESSION['mahasiswa']);
}

header('Location: ../index.php');
exit();
