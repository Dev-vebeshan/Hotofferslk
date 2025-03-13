<?php
header('Content-Type: application/json');
require_once 'db/connection.php'; 

// Fetch filters from POST request
$filter = $_POST['filter'] ?? '';
$category = $_POST['category'] ?? '';
$brand = $_POST['brand'] ?? '';
$location = $_POST['location'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';
$search = $_POST['search'] ?? '';
$price = $_POST['price'] ?? '';
$rating = $_POST['rating'] ?? '';

// Get current page number from AJAX, default is 1
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

// Number of records per page
$recordsPerPage = 6;

// Calculate offset
$offset = ($page - 1) * $recordsPerPage;

// Current date to check for expired ads
$currentDate = date('Y-m-d');

// Base query: Always exclude expired ads
$query = $con->query("
    SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
    FROM advertisments AS a 
    LEFT JOIN brands AS b ON a.brand_id = b.id 
    LEFT JOIN category AS c ON a.category_id = c.id 
    LEFT JOIN review AS r ON a.id = r.ads_id 
    WHERE a.status = 'active' AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
    GROUP BY a.id 
    ORDER BY a.id DESC 
    LIMIT $offset, $recordsPerPage
");

// Modify query based on filters
if (!empty($filter)) {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' AND a.type = '$filter' 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.id DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

if (!empty($category)) {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' AND a.category_id = $category 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.id DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

if (!empty($location)) {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' AND a.location = '$location' 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.id DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

if (!empty($brand)) {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' AND a.brand_id = $brand 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.id DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

if (!empty($start_date)) {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' AND a.start_date >= '$start_date' 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.id DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

if (!empty($end_date)) {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' AND a.end_date <= '$end_date' 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.id DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

if (!empty($search)) {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' 
        AND (a.title LIKE '%$search%' OR b.name LIKE '%$search%' OR c.name LIKE '%$search%') 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.id DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

// Sorting by price
if ($price == "low") {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.sale_price ASC 
        LIMIT $offset, $recordsPerPage
    ");
}

if ($price == "high") {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY a.sale_price DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

// Sorting by rating
if ($rating == "low") {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY avg_rating ASC 
        LIMIT $offset, $recordsPerPage
    ");
}

if ($rating == "high") {
    $query = $con->query("
        SELECT a.*, b.name AS brand_name, c.name AS category_name, AVG(r.rating) AS avg_rating 
        FROM advertisments AS a 
        LEFT JOIN brands AS b ON a.brand_id = b.id 
        LEFT JOIN category AS c ON a.category_id = c.id 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.status = 'active' 
        AND (a.end_date IS NULL OR a.end_date >= '$currentDate') 
        GROUP BY a.id 
        ORDER BY avg_rating DESC 
        LIMIT $offset, $recordsPerPage
    ");
}

// Prepare data for response
$data = [];
while ($row = $query->fetch_assoc()) {
    $row['image'] = str_replace('../', './', $row['image']); // Adjust image path
    $data[] = $row;
}

// Calculate total pages
$totalRecordsQuery = $con->query("SELECT COUNT(*) AS total FROM advertisments WHERE status='active' AND (end_date IS NULL OR end_date >= '$currentDate')");
$totalRecords = $totalRecordsQuery->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Return JSON response
echo json_encode([
    'data' => $data,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);
?>
