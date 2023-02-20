<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="cart">
        <?php foreach($product as $item):?>
            <?php if( $item != $product['count']):?>
                <div class="items">
                    <img src="<?php echo base_url('resources/images/'.$item['product']['image']); ?>" alt="">
                    <span><?=$item['product']['name']?></span>
                    <span>&#8358 <?=$item['formatted']?></span>
                    <span>Quantity: <?=$item['quantity']?></span>
                </div>
            <?php endif;?>
        <?php endforeach;?>
        <hr>
        <h2>TOTAL = <?=$subtotal?></h2>
    </div>

    <form action="<?php echo base_url('index.php/Habit/check_out'); ?>" method="POST">
        <button name="multi" type="submit"><?php echo isset($_POST['multi'])? $dont_click['if']:$dont_click['or']  ;?></button>
    </form>
</body>
</html>