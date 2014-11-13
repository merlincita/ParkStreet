<?php

require_once '../dao/Middleware.php';

$type = filter_input(INPUT_POST, 'type');
$table = Middleware::getData($type);

$content = '';
foreach ($table as $row) {
    $content .= "<tr>";
    $content .= "<td>".$row['invoice_num']."</td>";
    $content .= "<td>".$row['invoice_date']."</td>";
    $content .= "<td>".$row['product_description']."</td>";
    $content .= "<td>".$row['qty']."</td>";
    $content .= "<td>".$row['price']."</td>";
    $content .= "<td>".$row['qty'] * $row['price']."</td>";
    $content .= "</tr>";
}
echo $content;