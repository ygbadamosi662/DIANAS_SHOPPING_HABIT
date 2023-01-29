<?php  ?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            /* body{
                position: relative;
            } */
            .navi{
                /* position: fixed; */
                display: flex;
                align-items: center;
                justify-content: space-between;
                height: 7rem;
                /* background-color: grey; */
                padding: 1rem;
                
                /* top: 0; */
            }
            .drop_down{
                height: 1rem;
                width: 1.5rem;
            }
            .theRest{
                display: flex;
                /* padding-right: 2rem; */
                justify-content: space-between;
                align-items: center;
                width: 20rem;
            }
            .logo img{
                height: 5rem;
                width: 5rem;
            }
            .cart img{
                height: 1.5rem;
                width: 2rem;
            }
            .cart{
                text-decoration: none;
            }
            .navi form{
                /* display: flex; */
                /* justify-content: space-between; */
                
            }
            .navi form input {
                width: 15rem;
                height: 2rem;
                margin-right: 2rem;
                
            }
            .navi form button{
                width: 5rem;
                height: 1.5rem;
            }
            .gen_z{
                position: absolute;
                display: none;
                top: 4.4rem;
                right: 15rem;
                width: 6rem;
            }
            .gen_z a{
                text-decoration: none;
                margin-bottom: 0.2rem;
                border: 1px solid ;
            }
            .helpers{
                position: absolute;
                display: none;
                top: 4.4rem;
                right: 7rem;
                width: 6rem;
            }
            .helpers a{
                text-decoration: none;
                margin-bottom: 0.2rem;
                border: 1px solid ;
            }
            
        </style>
    </head>
    <body>
        <nav class="navi">
            <div class="logo">
                <a href="<?php echo base_url('index.php/Habit'); ?>"><img src="<?php echo base_url('resources/images/dlogo.jpg'); ?>" alt=""></a>
            </div>
            <form action="Home" method="POST">
                <!-- <img src="" alt=""> -->
                <input type="text" name="search">
                <button name="search">SEARCH</button>
            </form>
            <div class="theRest">
                <div class="account">
                    <!-- <img src="" alt=""> -->
                    <span>Account</span>
                    <img src="<?php echo base_url('resources/images/drop_down.png'); ?>" alt="" class="drop_down" id="drop">
                </div>
                <div class="gen_z">
                    <a href="">Sign Up</a>
                    <a href="">Sign In</a>
                </div>
                <div class="help">
                    <!-- <img src="" alt=""> -->
                    <span>Help</span>
                    <img src="<?php echo base_url('resources/images/drop_down.png'); ?>" alt="" class="drop_down" id="drop_help">
                </div>
                <div class="helpers">
                    <a href="">Call Us</a>
                    <a href="">Email Us</a>
                </div>
                <a href="<?php echo base_url('index.php/Habit/cart'); ?>" class="cart">
                    <span>Cart</span>
                    <img src="<?php echo base_url('resources/images/cartlogo.jpg'); ?>" alt="">
                    <?php if($count != 0 ):?>
                        <h3><?=$count?></h3>
                    <?php endif;?>
                </a>
            </div>
        </nav>
        <script>
            let genZ = document.querySelector(".gen_z");
            let drop = document.querySelector("#drop");
            drop.addEventListener("click",dropDown);
            let dropHelp = document.querySelector("#drop_help");
            let helpers = document.querySelector(".helpers");
            dropHelp.addEventListener("click",dropHelpers);
            
            function dropDown(){
                if (genZ.style.display == 'none'){
                    genZ.style.display = 'grid';
                   
                }
                else{
                    genZ.style.display = 'none';
                }
            }
            function dropHelpers(){
                if (helpers.style.display == 'none'){
                    helpers.style.display = 'grid';
                }
                else{
                    helpers.style.display = 'none';
                }
            }
        </script>
    </body>

    </html>
