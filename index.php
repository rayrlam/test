<?php
// Front-end interface to use the calculator
require "vendor/autoload.php";

use Calculator\TopsoilCalculator;

$test  = new TopsoilCalculator();

 // Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Get form data
    $unit = $_POST["unit"];
    $width = $_POST["width"];
    $length = $_POST["length"];
    $depth = $_POST["depth"];

    // Create calculator object
    $calculator = new TopsoilCalculator();

    // Set calculator dimensions
    $calculator->setDimensions($width, $length, $depth);

    // Set calculator unit
    $calculator->setUnit($unit);

    try 
    {
        // Calculate bags
        $bags = $calculator->calculateBags();
         
    } catch (Exception $e) 
    {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topsoil Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        select,
        input[type="number"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            margin-top:10px;
            padding: 10px 20px;
            background-color: blue;
            color: #fff;
            border: none;
            cursor: pointer;
        }
 
        .bags{
            background-color: green;
            color: #fff;
            padding:10px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Topsoil Calculator</h2>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="unit">Unit:</label>
            <select name="unit" id="unit">
                <option value="m">Metres</option>
                <option value="ft">Feet</option>
                <option value="yd">Yards</option>
            </select>
            <label for="width">Width:</label>
            <input type="number" name="width" id="width" step="any" required>
            <label for="length">Length:</label>
            <input type="number" name="length" id="length" step="any" required>
            <label for="depth">Depth:</label>
            <input type="number" name="depth" id="depth" step="any" required>
            <button type="submit">Calculate</button>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <?php if (isset($bags)): ?>
                    <p class="bags">Number of bags needed: <?php echo $bags; ?></p>
                <?php else: ?>
                    <p class="error">Error: <?php echo $error; ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>