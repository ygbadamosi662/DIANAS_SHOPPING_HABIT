<?php  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <label for="username">Enter ur email</label>
        <input type="text" name="username" value="<?php echo isset($_POST['username'])?$_POST['username'] : "" ;?>">

        <label for="username">Enter ur password</label>
        <input type="text" name="email" value="<?php echo isset($_POST['username'])?$_POST['username'] : "" ;?>">

        <input type="submit" name="Submit">



    </form>
</body>
</html>