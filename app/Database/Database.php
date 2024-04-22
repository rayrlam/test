<?php

namespace Database;

use PDO;
use PDOException;
use Calculator\TopsoilCalculator;

class Database 
{
    // Database connection settings
    private $host;
    private $dbname;
    private $username;
    private $password;

    public function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function storeTopsoil(TopsoilCalculator $topsoil)
    {
        // Object data
        $unit = $topsoil->unit;
        $depthUnit = $topsoil->depthUnit;
        $width = $topsoil->width;
        $length = $topsoil->length;
        $depth = $topsoil->depth;

        try {
            // Connect to the database
            $pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            
            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO garden_dimensions (id, unit, depth_unit, width, length, depth) VALUES (NULL, ?, ?, ?, ?, ?)");

            // Bind parameters and execute the statement
            $stmt->bindParam(1, $unit);
            $stmt->bindParam(2, $depthUnit);
            $stmt->bindParam(3, $width);
            $stmt->bindParam(4, $length);
            $stmt->bindParam(5, $depth);
            $stmt->execute();

            // Close the database connection
            $pdo = null;

            // Return true on successful insertion
            return true; 
        } catch (PDOException $e) 
        {
            // Return false if an error occurs
            return false;
        }
    }
}