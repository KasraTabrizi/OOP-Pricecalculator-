<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Price Calculator</title>
</head>

<?php 
    require '../model/model.php';
?>

<body>
    <form action="" method="POST">
        <!-- Customer Dropdown -->
        <select>
            <?php 
                foreach($customers as $customer){
                    echo "<option value='name'>".$customer->getName()."</option>";
                    //var_dump("<option value=/'$customer->name/'>$customer->name</option>");
                }
            ?>
        </select>
        <!-- Products Dropdown -->
        <select>
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="opel">Opel</option>
            <option value="audi">Audi</option>
        </select>
        <!-- Calculate Button -->
        <input type="submit" value="calculate" name="calculate">
    </form>
    <!-- Price Table -->
    <table></table>
</body>

</html>