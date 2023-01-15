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
        <a href="">
            <div class="items">
                <img src="<?php echo $product['path']; ?>" alt="" id="">
                <p>description</p>
                <span>price</span>
            </div>
        </a>
    <?php endforeach; ?>
</body>
</html>