<?php  ?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            /* body{
                position: relative;
            } */
            #navdiv{
                
                display:flex;
                justify-content:space-evenly;
               
            }
            #navdiv a{
                text-decoration: none;
                /* background-color: red; */
                width: 10rem;
                /* height: 3rem; */
                text-align: center;
                padding: 2rem;
            }
            hr{
                height: 5rem;
            }
            #navdiv a:hover{
                background-color: #8c2473 ;
                color: white;
            }

        </style>
    </head>
    <body>
        <div id="navdiv">
            <a href="http://localhost/test/dianas_shopping_habit/index.php/habit/">Home</a><hr>
            <a href="http://localhost/test/mans_not_hot/index.php/habit/shoppers_page.php">Ur items</a><hr>
            <a href="http://localhost/test/mans_not_hot/index.php/habit/cart_page.php">Ur cart</a>
        </div>                           
    </body>
    </html>
