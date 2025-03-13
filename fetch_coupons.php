<?php
require_once 'db/connection.php';

$coupon = $_POST['coupon'] ?? '';
$search = $_POST['search'] ?? '';


$query = "
    SELECT a.*,c.id AS cat_id, c.name AS category_name, MAX(r.rating) AS max_rating 
    FROM advertisments AS a 
    LEFT JOIN category AS c ON a.category_id = c.id 
    LEFT JOIN review AS r ON a.id = r.ads_id 
    WHERE a.status = 'active' AND not coupon='' AND not coupon='0' GROUP BY a.id ORDER BY a.id DESC ";


if (!empty($coupon)) 
{
    if($coupon !="all")
    {
        $query = "
    SELECT a.*,c.id AS cat_id, c.name AS category_name, MAX(r.rating) AS max_rating 
    FROM advertisments AS a 
    LEFT JOIN brands AS b ON a.brand_id = b.id 
    LEFT JOIN category AS c ON a.category_id = c.id 
    LEFT JOIN review AS r ON a.id = r.ads_id 
    WHERE a.status = 'active' AND not coupon='' AND not coupon='0' AND a.category_id = $coupon  GROUP BY a.id ORDER BY a.id DESC ";
    }
    else
    {
        $query = "
    SELECT a.*,c.id AS cat_id, c.name AS category_name, MAX(r.rating) AS max_rating 
    FROM advertisments AS a 
    LEFT JOIN brands AS b ON a.brand_id = b.id 
    LEFT JOIN category AS c ON a.category_id = c.id 
    LEFT JOIN review AS r ON a.id = r.ads_id 
    WHERE a.status = 'active' AND not coupon='' AND not coupon='0' GROUP BY a.id ORDER BY a.id DESC ";
    }
	
}



if (!empty($search)) {
	$query = "
    SELECT a.*,c.id AS cat_id, c.name AS category_name, MAX(r.rating) AS max_rating 
    FROM advertisments AS a 
    LEFT JOIN category AS c ON a.category_id = c.id 
    LEFT JOIN review AS r ON a.id = r.ads_id 
    WHERE a.status = 'active' AND (a.title LIKE '%$search%' OR c.name LIKE '%$search%') AND not coupon='' AND not coupon='0' GROUP BY a.id ORDER BY a.id DESC ";
}


$result = mysqli_query($con, $query);
$ads = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row['image'] = str_replace('../', './', $row['image']); // Adjust image path
    $netprice=$row['price']-$row['sale_price'];
    $row['netprice']=$netprice;
    $ads[] = $row;
}

echo json_encode($ads);
?>
