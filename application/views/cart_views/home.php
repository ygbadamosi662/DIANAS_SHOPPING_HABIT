<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img{
            height: 5rem;
            width: 5rem;
        }
        .price{
            display: flex;
        }
    </style>
</head>
<body>
    <?php foreach ($product as  $info): ?>
        <?php if( $info != $product['count']):?>
            <div class="items">
                <a href="<?php echo base_url('index.php/Habit/shop/'.$info['product']['product_id']); ?>">
                    <img src="<?php echo base_url('resources/images/'.$info['product']['image']); ?>" alt="" id="">
                    <p><?php echo $info['product']['name']; ?></p>
                    <div class="price">
                        <h4>&#8358</h4>
                        <span><?php echo $info['formatted']; ?></span>
                    </div>
                </a>
            </div>
        <?php endif;?>
    <?php endforeach; ?>
</body>
</html>