<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Price Calculator</title>
    <style>
        <?php include '../styles/css/styles.css'; ?>
    </style>
</head>

<?php 
    require '../controller/controller.php'; 
?>

<body>
    <form action="" method="POST">
        <!-- Customer Dropdown -->
        <select name="customer_dropdown"> 
            <?php 
                foreach($customers as $customer){
                    echo "<option value=".$customer->getId().">".$customer->getName()."</option>";
                }
            ?>
        </select>
        <!-- Products Dropdown -->
        <select name="product_dropdown"> 
            <?php 
                foreach($products as $product){
                    echo "<option value=".$product->getId().">".$product->getName()."</option>";
                }
            ?>
        </select>
        <!-- INPUT TEXT FOR AMOUNT -->
        <input type="text" name="amount" id="" placeholder="amount">
        <!-- Calculate Button -->
        <input type="submit" value="calculate" name="calculate">
    </form>
    <!-- Price Table -->
    <table id="customers">
    <caption>Pricing Table</caption>
    <?php 
        createTable($retrievedData, $companies);
    ?>
    </table>
</body>

</html>