<?php

use Calculator\TopsoilCalculator;

class CalculatorTest extends \PHPUnit\Framework\TestCase 
{
    // test Set Unit
    public function testSetUnit()
    {
        $calculator = new TopsoilCalculator();
        $calculator->setUnit("m");
        $this->assertEquals("m", $calculator->unit);
    }

    // test Set Depth Unit
    public function testSetDepthUnit()
    {
        $calculator = new TopsoilCalculator();
        $calculator->setDepthUnit("cm");
        $this->assertEquals("cm", $calculator->depthUnit);
    }

    // test Set Dimensions
    public function testSetDimensions()
    {
        $calculator = new TopsoilCalculator();
        $calculator->setUnit("m");
        $calculator->setDimensions(11, 10, 1);
        // width
        $this->assertEquals(11, $calculator->width);
        // length
        $this->assertEquals(10, $calculator->length);
        // depth
        $this->assertEquals(1, $calculator->depth);
    }

    // test calculate Bags with given example
    // Example: 110 * 0.025 = 2.75 * 1.4 = 3.85 = 4 Bags of Top Soil
    public function testCalculateBags(){
        $calculator = new TopsoilCalculator();
        $calculator->setUnit("m");
        $calculator->setDimensions(11, 10, 1);
        $this->assertEquals(4, $calculator->calculateBags());
    }

    // test unit in feet
    public function testUnitInFeet(){
        $calculator = new TopsoilCalculator();
        $calculator->setUnit("ft");
        $calculator->setDimensions(36.09, 32.8, 2);
        $this->assertEquals(4, $calculator->calculateBags());
    }

    // test unit in yards
    public function testUnitInYards()
    {
        $calculator = new TopsoilCalculator();
        $calculator->setUnit("yd");
        $calculator->setDimensions(12.03, 10.94, 1);
        $this->assertEquals(4, $calculator->calculateBags());
    }

    // test unit not match 
    public function testUnitNotMatch()
    {
        $calculator = new TopsoilCalculator();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Only 'metres',  'feet' or 'yards' are allowed");
        $calculator->setUnit("unknown");
    }

    // test unit not provided 
    public function testUnitNotProvided()
    {
        $calculator = new TopsoilCalculator();
        $calculator->setDimensions(11, 10, 1);
        
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Measurement unit is requried");
        $calculator->calculateBags();
    }
}