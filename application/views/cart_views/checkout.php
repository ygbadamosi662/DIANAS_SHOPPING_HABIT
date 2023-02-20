<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .chk_form{
            width: 100%;
            background-color: #f9f9f9;
            height: 20rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .chk_form input{
            margin-right: 2rem;
            width: 15rem;
            height: 2.5rem;
        }
        .center button {
            width: 10rem;
            height: 2.5rem;
        }
        .center a div{
            width: 10rem;
            height: 3rem;
            margin-top: 1rem;
            background-color:  #eb4055;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 0.5rem;
        }
        .center a{
            text-decoration: none;
        }

    </style>
</head>
<body>
    <form action="<?php echo base_url('index.php/Habit/check_out'); ?>" method="POST" class="chk_form">
        <div class="center">
            
            <?php if(!(isset($_POST['go_to']))):?>
                <input type="text" name="email" placeholder="Enter your email">
                <button name="go_to" type="submit">SUBMIT</button>
            <?php endif;?>
            <?php if(isset($_POST['go_to']) && ($go_to == 'login')):?>
                <a href="<?php echo base_url('index.php/Habit/loginHandler/'.$id); ?>"><div>LOG IN</div></a>
            <?php elseif(isset($_POST['go_to']) && ($go_to != 'login')):?>
                <a href="<?php echo base_url('index.php/Habit/register/'.$go_to); ?>"><h2>SIGN UP</h2></a>
            <?php endif;?>
        </div>
         
    </form>
    <script>
        let chkchk = document.querySelector('#chkchk');
        if (<?php echo $product['count']?> == 0){
            chkchk.style.display = 'none';

        }

    </script>
</body>
</html>