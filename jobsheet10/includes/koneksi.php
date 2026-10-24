<?php
// Sesuaikan dengan environment lokal kamu
$host = "localhost";
$port = "5433";
$db   = "db_glowtrack";
$user = "postgres";
$pass = "12345678";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
