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

    

    <div >
        <?php foreach ($product as  $key => $info): ?>
            <?php echo '<h4>'.$key.': '.$info.'</h4>' ?>
        <?php endforeach; ?>
        
    </div>

    <p><?php echo anchor('habit/', 'click here to save this information'); ?></p>
    
    
</body>
</html>