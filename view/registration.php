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
    <div id="wrapper">
        <form action="" method="POST">
            <input type="text" name="name" id="">
            <select class="dropdown" name="department_dropdown"> 
                <option value="1">Marketing</option>
                <option value="2">Customer Support</option>
                <option value="3">HR</option>
                <option value="4">Sales</option>
                <option value="5">Quality Assurance</option>
                <option value="7">Development</option>
                <option value="13">Communication</option>
                <option value="18">IT-Department</option>
            </select>
            <input type="submit" value="Register" name="register">
        </form>
    </div>
</body>

</html>