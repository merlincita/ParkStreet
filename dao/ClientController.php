<?php

require_once __DIR__ . '/../db/DBConnection.php';

/**
 * Class with functions related to the clients.
 * This class must have some methods such as
 * insert_client(params), modify_client(params), delete_client(id), select_client(condition), etc.
 *
 * @author merlin
 */
class ClientController {
    
    /**
     * @return all clients in the table
     */
    public static function getClients() {
        return DBConnection::getConnection()-> performQuery('select * from clients', TRUE);
    }
    
}