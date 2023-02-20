<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #chk{
            display: none;
        }
        .cart_images{
            height: 6rem;
            width: 6rem;
            border-radius: 0.5rem;
        }
        .item button{
            border-radius: 0.2rem;
            height: 2.5rem;
        }
        .counter h3{
            background-color: white;
            color: black;
            margin: 0.5rem;
        }

        .plus ,.minus{
            width: 3rem;
            text-align: center;
            background-color: black;
            color: white;
        }
        .list_items{
            display: flex;
            justify-content: space-between;
        }
        .items{
            position: relative;
            /* background-color: blue; */
            width: 75%;
            display: grid;
            justify-content: space-between;
            

        }
        .item{
            padding: 1rem;
            width: 55rem;
           
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 12rem;
            background-color: #f9f9f9;
            /* background-color: blue; */
            margin-bottom: 1rem;
        }
        .oneside .remove{
            width: 6rem;

        }
        .theside{
            display: flex;
            /* justify-content: space-between; */
            /* padding: rem; */
            /* background-color: aqua; */
        }
        .counter{
            display: flex;
            margin-left: 5rem;
        }
        .h3_in_theside{
            color: #eb4055;
        }
        .cart{
            margin-left: 1rem;
        }
        /* .theside .count{
            display: flex;
        } */
        .checkout{
            position: sticky;
            top: 7rem;
            right: 1rem;
            background-color:  #eb4055;
            border-radius: 0.3rem;
            margin: 1rem;
            margin-top: 1.5rem;
            color: white;
            display: grid;
            width: 25%;
            height: 10rem;
            align-items: center;
            justify-content: center;

        }
        .subtotal button{
            text-decoration: none;
            background-color: white;
            border-radius: 0.1rem;
            height: 2.5rem;
            width: 13rem;
        }
        .subtotal{
            /* background-color: blue;
            height: 10rem;
            width: 15rem; */
        }

    </style>
</head>
<body>
    
    <!-- <form action="<?php echo base_url('index.php/Habit/cart'); ?>" method="POST" class="list_items"> -->
    <div class="list_items">
    
        <div class="items">
            <h3 class="cart">Cart(<?=$product['count'] ?>)</h3>
            <?php if($product['count'] > 0 ):?>
                <?php foreach($product as $item):?>
                    <?php if( $item != $product['count']):?>
                        <form class="item" 
                        action="<?php echo base_url('index.php/Habit/cart/'.$item['product']['name']); ?>"  method="POST">

                            <input type="text" name="subtle" value="<?=$item['product']['name']?>" id="chk">
                            <div class="oneside">
                                <img src="<?php echo base_url('resources/images/'.$item['product']['image']); ?>" alt="" class="cart_images">
                                <div>
                                    <p><?=$item['product']['name']?></p>
                                    <span>Seller:<?=$item['product']['brand']?></span>
                                </div>
                                <button class="remove" name="remove" type="submit"><h3>REMOVE</h3></button>
                            </div>
                            <div class="theside">
                                <h3 class="h3_in_theside">Price: &#8358 <?=$item['formatted']?></h3>
                                <div class="counter">
                                    <button class="minus" name="minus" type="submit" value="<?=$item['product']['quantity']?>"><h1>-</h1></button>
                                    <h3> Qty: <?=$item['quantity']?> </h3>
                                    <button class="plus" name="plus" type="submit" value="<?=$item['product']['quantity']?>"><h1>+</h1></button>
                                </div>
                            </div>
                        </form>
                    <?php endif;?>
                <?php endforeach;?>
            <?php else:?>
                <h2>No item in cart 😢</h2>
            <?php endif;?>
        </div>

        <div class="checkout">
                <h3>Cart Summary</h3>
                <div class="subtotal">
                    <h3>Subtotal</h3>
                    <h3>&#8358 <?=$subtotal ?></h3>
                    <a href="<?php echo base_url('index.php/Habit/check_out/'); ?>" id="chkchk"><button>CHECKOUT</button></a>
                </div>
        </div>
    
    </div>    
    <script>
        let chkchk = document.querySelector('#chkchk');
        if (<?php echo $product['count']?> == 0){
            chkchk.style.display = 'none';

        }

    </script>
    
</body>
</html>