<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* div{
            background-color: black;
        } */
    </style>
</head>
<body>
    <h3><?php echo $header ?></h3>

    <p><?php echo anchor('habit/admin', 'Review your information'); ?></p>

    <div >
        <?php foreach ($product as $key => $info): ?>
            <h4><?php echo $info ?></h4>
        <?php endforeach; ?>
        
    </div>
    <!-- <a href=""></a> -->
    
</body>
</html>