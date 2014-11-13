<?php

require_once '../dao/Middleware.php';

$clientid = filter_input(INPUT_POST, 'client');
$client_table = Middleware::getTransactions($clientid);

$content = '';
foreach ($client_table as $row) {
    $content .= "<tr>";
    $content .= "<td>".$row['invoice_num']."</td>";
    $content .= "<td>".$row['invoice_date']."</td>";
    $content .= "<td id='description'>".$row['product_description']."</td>";
    $content .= "<td>".$row['qty']."</td>";
    $content .= "<td>".$row['price']."</td>";
    $content .= "<td>".$row['qty'] * $row['price']."</td>";
    $content .= "</tr>";
}
echo $content;
