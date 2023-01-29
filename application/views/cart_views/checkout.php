<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo base_url('index.php/Habit/sign_in'); ?>" method="POST">
        <input type="text" name="email" placeholder="Enter your email">
        <a href="<?php echo base_url('index.php/Habit/'); ?>">Submit</a>
    </form>
</body>
</html>