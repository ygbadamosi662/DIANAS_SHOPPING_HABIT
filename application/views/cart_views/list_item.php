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
        .item img{
            height: 5rem;
            width: 5rem;
        }
        .item button{
            width: 3rem;
            height: 2rem;
        }
    </style>
</head>
<body>
    
    <form action="<?php echo base_url('index.php/Habit/cart'); ?>" method="POST" class="list_items">
    
        <h3>Cart(<?=$count ?>)</h3>
        <div class="items">
            <?php if($count != 0 ):?>
                <?php foreach($items as $item):?>
                    <div class="item">

                        <input type="text" name="subtle" value="<?=$item['product']['name']?>" id="chk">
                        <div class="oneside">
                            <img src="<?php echo base_url('resources/images/'.$item['product']['image']); ?>" alt="">
                            <div>
                                <p><?=$item['product']['name']?></p>
                                <span>Seller:<?=$item['product']['brand']?></span>
                            </div>
                            <button class="remove" name="remove" type="submit">REMOVE</button>
                        </div>
                        <div class="theside">
                            <span>&#8358 <?=$item['product']['formatted']?></span>
                            <div class="counter">
                                <button class="minus" name="minus" type="submit">-</button>
                                <h3><?=$item['quantity']?></h3>
                                <button class="plus" name="plus" type="submit">+</button>
                            </div>
                        </div>

                    </div>
                <?php endforeach;?>
            <?php else:?>
                <h2>No item in cart 😢</h2>
            <?php endif;?>
        </div>

        <div class="checkout">
                <h3>Cart Summary</h3>
                <div class="subtotal">
                    <span>Subtotal</span>
                    <h3>&#8358 <?=$subtotal ?></h3>
                    <button name='checkout' type="submit">Checkout</button>
                </div>
        </div>
    </form>
    
</body>
</html>