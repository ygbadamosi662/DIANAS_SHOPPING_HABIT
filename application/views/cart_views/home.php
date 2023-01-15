<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php foreach ($product as  $key => $info): ?>
        <div class="items">
            <a href="<?php echo 'Habit/shop/'.$product['id']; ?>">
                <img src="<?php echo $product['path']; ?>" alt="" id="">
                <p><?php echo $product['summary']; ?></p>
                <span><?php echo $product['price']; ?></span>
            </a>
        </div>
    <?php endforeach; ?>
</body>
</html>