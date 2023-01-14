<?php?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo validation_errors(); ?>
    <?php echo form_open('habit/admin'); ?>
        <h1>Product Registration</h1>

        <h5>Name of product</h5>
        <input type="text" name="name" value="<?php echo set_value('name'); ?>">

        <h5>Brand of product</h5>
        <input type="text" name="brand" value="<?php echo set_value('brand'); ?>">

        <h5>Price of product</h5>
        <input type="text" name="price" value="<?php echo set_value('price'); ?>">

        <h5>Quantity of product</h5>
        <input type="text" name="quantity" value="<?php echo set_value('quantity'); ?>">

        <h5>Image path</h5>
        <input type="text" name="path" value="<?php echo set_value('path'); ?>">

        <div><input type="submit" name="Submit"></div>



    </form>

</body>
</html>