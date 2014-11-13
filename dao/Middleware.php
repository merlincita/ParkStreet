<?php

require_once '../db/DBConnection.php';

/**
 * This class has functions with the db queries.
 * Because I am not using any MVC framework and there are just 3 entities in the db, I created this class with 
 * the following queries, BUT, it could be better to have for example a ClientController class that has all
 * functions related to the clients (get, set, update, delete).
 * Idem for the other entities.
 *
 * @author merlin
 */
class Middleware {
    
    /**
     * We could include the colum 'invline.qty * invline.price as total' in the select, 
     * BUT it is much better to do the multiplication in the client side.
     */
    public static function getData($condition = NULL) {
        $query = "select inv.invoice_num, inv.invoice_date, pro.product_description, invline.qty, invline.price
                from invoices inv, products pro, invoicelineitems invline
                where inv.invoice_num = invline.invoice_num and invline.product_id = pro.product_id";
        if ($condition != NULL) {
            switch ($condition) {
                case 1: // last month to date
                    $query .= " and inv.invoice_date >= DATE_FORMAT(NOW(),'%Y-%m-01') - INTERVAL 1 MONTH
                                and inv.invoice_date <= DATE_FORMAT(NOW(),'%Y-%m-%d')";
                    break;
                case 2: // this month
                     $query .= " and inv.invoice_date >= DATE_FORMAT(NOW(),'%Y-%m-01')
                                 and inv.invoice_date <= DATE_FORMAT(NOW(),'%Y-%m-%d')";
                    break;
                case 3: // this year
                    $query .= " and year(inv.invoice_date) = year(now())";
                    break;
                case 4: // last year
                    $query .= " and year(inv.invoice_date) + 1 = year(now())";
                    break;
            }
        }
        $query .= " order by inv.invoice_date asc";
        return DBConnection::getConnection()-> performQuery($query, TRUE);
    }
    
    
    /**
     * This query can be written in other ways, for example, using PDO/bindParam or bindValue or,
     * $query = 'select ... from ... where cl.client = "?" and ...' return DBConnection::getConnection()-> performQuery($query, TRUE, array($client)); 
     * 
     * @param varchar $client id
     * @return transactions associated to the client
     */
    public static function getTransactions($client) {
        $query = 'select inv.invoice_num, inv.invoice_date, pro.product_description, invline.qty, invline.price
                from invoices inv, products pro, invoicelineitems invline, clients cl
                where cl.client_id = "'. $client . '" and cl.client_id = pro.client_id and pro.product_id = invline.product_id and invline.invoice_num = inv.invoice_num
                order by inv.invoice_date asc';
        return DBConnection::getConnection()-> performQuery($query, TRUE);                
    }
    
}