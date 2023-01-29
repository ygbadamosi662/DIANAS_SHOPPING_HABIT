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
    <form action="" method="POST">
        <img src="<?php echo base_url('resources/images/'.$product['image']); ?>" alt="">
        <div class="moneySide">
            <h4>Brand:</h4>
            <h3><?php echo $product['name']; ?></h3>
            <div class="price">
                <h4>&#8358</h4>
                <span><?php echo $product['price']; ?></span>
            </div>

            <p><?php echo $product['summary']?></p>
            
            <button name="submit" type="submit">ADD TO CART</button>
        </div>  
    </form>
</body>
</html>