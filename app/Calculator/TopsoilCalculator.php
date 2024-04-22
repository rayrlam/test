<?php

namespace Calculator;

use Database\Database;
use Exception;

class TopsoilCalculator
{
    private $validUnits = ['m', 'ft', 'yd'];
    private $validDepthUnits = ['cm', 'in'];
    public $unit;
    public $depthUnit;
    public $width;
    public $length;
    public $depth;

    // A method to set the measurement unit (metres, feet, or yards)
    public function setUnit(string $unit)
    {
        // Validate the input of measurement unit is valid
        if(!$this->isValidUnit($unit))
        {
            throw new Exception("Only 'metres',  'feet' or 'yards' are allowed");
        }
        $this->unit = strtolower($unit);
    }

    // A method to set the depth measurement unit (centimetres or inches)
    public function setDepthUnit(string $depthUnit)
    {
        // Validate the input of depth unit is valid
        if(!$this->isValidDepthUnit($depthUnit))
        {
            throw new Exception("Only 'centimetres' or 'inches' are allowed");
        }
        $this->depthUnit = strtolower($depthUnit);
    }

    // A method to set the dimensions (width, length, and depth)
    public function setDimensions(float $width, float $length, float $depth)
    {
        $this->width = $width;
        $this->length = $length;
        $this->depth = $depth;
    }

    // A method to calculate the number of bags needed to cover the dimensions
    public function calculateBags(): int
    {
        // Validate measurement unit is set 
        if($this->unit === null)
        {
            throw new Exception("Measurement unit is requried");
        }

        /*
            Given:
            Bag quantity calculation: metres squared * 0.025 = X
            X * 1.4 = Y
            Round Y up to the nearest 1 = your number of bags
            Example: 110 * 0.025 = 2.75 * 1.4 = 3.85 = 4 Bags of Top Soil
        */

        $width = $this->width;
        $length = $this->length;

        // if measurement unit is not in metres, then convert to meters
        if($this->unit !== 'm')
        {
            $width = $this->convertToMeters($width, $this->unit);
            $length = $this->convertToMeters($length, $this->unit);
        }
        
        //  0.025 * 1.4 = 0.035
        return ceil($width * $length * 0.035);  
    }

    // A method to save the object into a MySQL Database (MariaDb 10.1)
    public function saveToDatabase()
    {
        // Some dummy data for database
        $db = new Database('HOST', 'DBNAME', 'USERNAME', 'PASSWORD');
       
        try 
        {
            return $db->storeTopsoil($this);
        } catch (Exception $e) 
        {
            // Handle the error if needed e.g.: log the error, display a message, etc, now just keep it simply to return false.
            return false; 
        }
    }

    // private functions below

    // check unit is valid
    private function isValidUnit(string $unit): bool 
    {
        return $this->unitIsValid(strtolower($unit), $this->validUnits);
    }

    // check depth unit is valid 
    private function isValidDepthUnit(string $depthUnit): bool 
    {
        return $this->unitIsValid(strtolower($depthUnit), $this->validDepthUnits);
    }

    // handle checking for unit & depth unit
    private function unitIsValid(string $unit, array $validator): bool
    {
        return in_array($unit, $validator);
    }

    private function convertToMeters(float $value, string $unit): float 
    {
        switch ($unit) 
        {
            case 'ft':
                // 1 foot = 0.3048 meters
                return $value * 0.3048; 
            case 'yd':
                // 1 yard = 0.9144 meters
                return $value * 0.9144; 
            default:
                throw new Exception("Invalid unit. Only 'feet' and 'yards' are allowed.");
        }
    }
}