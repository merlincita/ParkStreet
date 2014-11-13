<?php

require_once '../dao/Middleware.php';

$table = Middleware::getData();
$output = array();

foreach($table as $row) {
    $output[] = array('invoice_num' => $row['invoice_num'],
                    'invoice_date' => $row['invoice_date'],
                    'description' => $row['product_description'],
                    'qty' => $row['qty'],
                    'price' => $row['price'],
                    'total' => $row['qty'] * $row['price']);
}

echo json_encode($output);