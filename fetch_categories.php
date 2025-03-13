<?php
require_once 'db/connection.php'; 

$sql = "SELECT c.id AS cat_id,c.name AS cat_name,c.image,c.status,a.id,a.category_id,a.status FROM category AS c INNER JOIN advertisments AS a ON c.id=a.category_id WHERE c.status ='1' AND a.status='Active' GROUP BY a.category_id ORDER BY a.id DESC";
$result = $con->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    // Fetch all rows as associative array
    while ($row = $result->fetch_assoc()) {
        $row['image'] = str_replace('../', './', $row['image']);
        $categories[] = $row;
    }
}

$con->close();


header('Content-Type: application/json');
echo json_encode($categories);
?>
