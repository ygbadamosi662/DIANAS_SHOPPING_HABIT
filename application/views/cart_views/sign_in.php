<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .login{
            
            width: 100%;
            
            display: flex;
            justify-content: center;
            align-items: center;
            height: 30rem;
        }
        .login form {
            height: 50%;
            display: grid;
        }
        .login form input{
            border-radius: 0.3rem;
            width: 15rem;
            height: 2.5rem;
        }
        .login form button{
            background-color:  #eb4055;
            color: white;
            border-radius: 0.3rem;
            margin-left: 4rem;
            width: 7rem;
            height: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="login">
        <?php echo validation_errors(); ?>

        <?php echo form_open('habit/loginHandler/'.$id); ?>
            <?php if(isset($error)):?>
                <div class="error"><h3><?=$error?></h3></div>
            <?php endif;?>
            <input type="text" name="email" value="<?php echo isset($_POST['email'])?$_POST['email']: ''; ?>" placeholder="Enter Your Email">
            <input type="password" name="password" placeholder="Enter Your Password">
            <div><button type="submit" name="submit_login">SIGN IN</button></div>
        </form>
    </div>
</body>
</html>