<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM auctions WHERE status = 'active'");
$auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($auctions);
?>
