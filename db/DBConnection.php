<?php

require_once 'config.php';

/**
 * This class is implemented using the singleton desing pattern.
 * It represents the connection with the database.
 *
 * @author merlin
 */
class DBConnection {
    
    protected $connection; //variable to hold connection object.
    private static $myself;


    /**
    * private construct - class cannot be instatiated externally.
     */
    private function __construct() {
        if (DEV_ENV === "Win") {
            // connection for windows
            $this->connection = new PDO('mysql:host='.DB_HOST.':'.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        }
        elseif (DEV_ENV === "Lin") {
        // connection for linux
            $this->connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;unix_socket=".DB_SOCKET, DB_USER, DB_PASSWORD);
        }
        else {
            //exit('Please, define your db connection. See file ParkStreet/db/config.php');
            throw new PDOException('Please, define your db connection.');
        }
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    }

    private function __clone() {
        triger_error('Clone is not allowed');
    }


    public function __destruct()
    {
        $Instance = self::$myself;
	unset($Instance);
    }


    /**
     * Get connection function. Static method - accessible without instantiation.
     * Guarantees single instance, if no connection object exists then create one.
     */
    public static function getConnection() {
        if(empty(self::$myself))
	{
            try
            {
               self::$myself = new DBConnection();
            }
            catch (PDOException $e)
            {
               echo '<h2 style="color:red">Connection failed: ' . $e->getMessage() . '</h2>';
               die();
            }
	}
	return self::$myself;
    }


    public function performQuery($query, $return, $params = NULL){
        try
        {
            $sth = $this->connection->prepare($query);
            if ($params != NULL) {
                $done = $sth->execute($params);
            }
            else {
                $done = $sth->execute();
            }
            return $return ? $sth->fetchAll(PDO::FETCH_BOTH) : $done;
        } catch (Exception $e)
        {
            echo $query . "<br>";
            echo 'ex: ' . $e->getMessage();
            die();
        }
    }

/*
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    public function commit() {
        return $this->connection->commit();
    }

     public function rollBack() {
        return $this->connection->rollBack();
    }
 

    public function getLastInsertedID(){
        return $this->connection->lastInsertId();
    }*/
    
}