<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .price{
            display: flex;
            align-items: center;
            /* justify-content: center; */
        }
        form img{
            height: 5rem;
            width: 5rem;
        }
        .alert{
            width: 100%;
            height: 1.5rem;
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>
    <form action="<?php echo base_url('index.php/Habit/shop/'.$product[$name]['product']['product_id']); ?>" method="POST">
        <img src="<?php echo base_url('resources/images/'.$product[$name]['product']['image']); ?>" alt="">
        <div class="moneySide">
            <h4>Product:</h4>
            <h3><?php echo $product[$name]['product']['name']; ?></h3>
            <div class="price">
                <h4>&#8358</h4>
                <span><?php echo $product[$name]['formatted']; ?></span>
            </div>

            <p><?php echo $product[$name]['product']['summary']?></p>
            
            <button name="submit" type="submit">ADD TO CART</button>
        </div>  
    </form>
</body>
</html>