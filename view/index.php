<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Price Calculator Login</title>
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
            <input type="text" name="customerName" id="" <?php echo alertMessage(); ?>>
            <input type="submit" value="Login" name="login">
            <input type="submit" value="Create Account" name="createAccount">
        </form>
    </div>
</body>

</html>