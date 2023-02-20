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
                cursor: pointer;
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
                cursor: pointer;
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
            #logout{
                /* display: none;
                margin-bottom: 0.2rem;
                border: 1px solid ;
                cursor: pointer; */

            }
            
        </style>
    </head>
    <body>
        <nav class="navi">
            <div class="logo">
                <a href="<?php echo base_url('index.php/Habit/'); ?>"><img src="<?php echo base_url('resources/images/dlogo.jpg'); ?>" alt=""></a>
            </div>
            <form action="<?php echo base_url('index.php/Habit/catalog/'.$_POST['search_for']) ; ?>" method="POST">
                <input type="text" name="search_for" value="<?php echo isset($_POST['search_for'])? $_POST['search_for'] : '' ; ?>">
                <button name="search" type="submit">SEARCH</button>
                <!-- <a href="">search  </a> -->
            </form>
            <form action="<?php echo base_url('index.php/Habit/catalog/'.$_POST['search_for']) ; ?>"></form>
            <div class="theRest">
                <div class="account">
                    <span>Account</span>
                    <img src="<?php echo base_url('resources/images/drop_down.png'); ?>" alt="" class="drop_down" id="drop">
                </div>
                <div class="gen_z">
                    <a href="<?php echo base_url('index.php/Habit/register'); ?>">Sign Up</a>
                    <a href="<?php echo base_url('index.php/Habit/loginHandler'); ?>">Sign In</a>
                </div>

                <div class="help">
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
                    <?php if(($product['count'] != 0)):?>
                        <h3><?=$product['count']?></h3>
                    <?php endif;?>
                </a>
                <?php if(isset($customer)):?>
                    <form action="<?php echo base_url('index.php/Habit/'); ?>" method="POST" id="logout">
                            <button name="logout" type="submit" id="logged" value="<?php  echo isset($customer)? 'logged': 'unknown';?>" > Sign Out </button>
                            <?php if($customer['user']['stockpiller'] == 'piller'):?>
                                <a href="<?php echo base_url('index.php/Habit/stock_piller'); ?>" id="for_stockpiller">Your Stock pile</a>
                            <?php elseif($customer['user']['stockpiller'] == 'non-piller'):?>
                                <a href="<?php echo base_url('index.php/Habit/stock_piller/from_nav'); ?>" id="for_non_stockpiller">You want to stockpile?</a>
                            <?php endif;?>
                    </form>
                <?php endif;?> 
            </div>
        </nav>
        <script>

            let genZ = document.querySelector(".gen_z");
            let drop = document.querySelector("#drop");
            drop.addEventListener("click",dropDown);

            let logged = document.querySelector("#logged");
            let logout = document.querySelector("#logout");
            

            let dropHelp = document.querySelector("#drop_help");
            let helpers = document.querySelector(".helpers");
            dropHelp.addEventListener("click",dropHelpers);

            
            if(logged.value == 'unknown')
            {
                logout.style.display = 'none' 
            }
            // else if(logged.value == 'logged')
            // {
            //     logout.style.display = 'block'
            // }

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
