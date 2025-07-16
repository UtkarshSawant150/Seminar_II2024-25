<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../user/login.php");
  exit();
}
include '../config/db.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: view_books.php");
exit();
?>