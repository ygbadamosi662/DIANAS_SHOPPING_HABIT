<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* form_one */
        .pile img{
            height: 6rem;
            width: 6rem;
            border-radius: 0.5rem;
        }
        .pile{
            padding: 1rem;
            width: 55rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 12rem;
            background-color: #f9f9f9;
            /* background-color: blue; */
            margin-bottom: 1rem;
        }
        /* form_one ends */
        
        /* form_two */
        .form_two{
            display: grid;
            /* grid-template-columns: repeat(3,1fr); */
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .on_shipping{
            display: grid;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .on_shipping div{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* form_two ends */

        /* fomr_four */
        .shipment{
            display: flex;
            /* align-items: center; */
            justify-content: space-between;
        }

        .shipped_pile{
            padding: 1rem;
            width: 55rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 12rem;
            background-color: #f9f9f9;
            margin-bottom: 1rem;

        }

        /* form_four ends */

    </style>
</head>
<body>
    
    <div class="allStock">
        <h1>Hi  able stockpiler </h1>
        <?php if( ( (isset($_POST['ship']) == FALSE) && (isset($_POST['shipping_details']) == FALSE) && (isset($_POST['the_selected']) == FALSE) )  || ( isset($_POST['get_out']) )):?>
                    
            <form action="<?php echo base_url('index.php/Habit/stock_piller'); ?>" method="POST" class="form_one">
                <?php foreach($stockpile as $pile):?>
                    <?php if($pile != $stockpile['count']):?>
                        <?=$pile['product']['id']?>
                        <div class="pile">
                            <input type="checkbox" name="<?=$pile['product']['id']?>" value="<?=$pile['product']['id']?>">
                             <img src="<?php echo base_url('resources/images/'.$pile['product']['image']); ?>" alt="">
                            <div class="others">
                                <div class="box">
                                    <?=$pile['product']['name']?> 
                                    <?=$pile['product']['brand']?>
                                    <?=$pile['product']['quantity']?>
                                </div>
                                <div class="another_box">
                                    <span><?=$pile['product']['pay_date']?></span>
                                    <div class="and_another_box" >
                                        <?=$pile['formatted'][0]?>
                                    </div>
                                </div>
                            </div>
                            <div class="item_count">
                                <button name="plus" type="submit" value="<?=$pile['product']['id']?>">
                                    <h3>+</h3>
                                </button>
                                <h3><?=$pile['product']['quantity']?></h3>
                                <button name="minus" type="submit" value="<?=$pile['product']['id']?>">
                                    <h3>-</h3>
                                </button>
                            </div>
                            <div class="btn">
                                <button type="submit" name="ship" value="<?=$pile['product']['id']?>"><h3><?php echo isset($_POST['get_out'])? 'SHIPPED': 'SHIP' ;?></h3></button>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
                    
                <button name="the_selected" type="submit">SHIP SELECTED</button>
            </form>
        <?php endif;?>

        <?php if( isset($_POST['ship'])  || ( isset($_POST['the_selected']) && ($select_pass == TRUE) ) || ($form_manager == 'not_validated') ):?>
            <?php echo validation_errors(); ?>
            <?php echo form_open('habit/stock_piller/'.$_POST['ship'].'/'.$form_manager,'class="form_two"'); ?>
                <h3>Your shipping address</h3>
                <div class="on_shipping">
                    
                    <div>
                        <label for="street_address">Street address:</label>
                        <?php echo form_error('street_address'); ?>
                        <input type="text" name="street_address" value="<?php echo set_value('street_address'); ?>">
                    </div>
                    <div>
                        <label for="closest_bustop">Closest bustop:</label>
                        <?php echo form_error('closest_bustop'); ?>
                        <input type="text" name="closest_bustop" value="<?php echo set_value('closest_bustop'); ?>">
                    </div>
                    <div>
                        <label for="city">City/Town:</label>
                        <?php echo form_error('city'); ?>
                        <input type="text" name="city" value="<?php echo set_value('city'); ?>">
                    </div>
                    <div>
                        <label for="state">State:</label>
                        <?php echo form_error('state'); ?>
                        <input type="text" name="state" value="<?php echo set_value('state'); ?>">
                    </div>
                    <div>
                        <label for="country">Country:</label>
                        <?php echo form_error('country'); ?>
                        <input type="text" name="country" value="<?php echo set_value('country'); ?>">
                    </div>
                    <div>
                        <label for="state_code">State code:</label>
                        <?php echo form_error('state_code'); ?>
                        <input type="text" name="state_code" value="<?php echo set_value('state_code'); ?>">
                    </div>
                </div>
                <button type="submit" name="shipping_details" value=""><h3>Submit</h3></button>
                <!-- <div><input type="submit" name="Submit" /></div> -->
        
            </form>
        <?php elseif( ( isset($_POST['shipping_details']) && ($form_manager == 'form_validated')  && (isset($_POST['get_out']) == FALSE) ) ):?>
            <form action="<?php echo base_url('index.php/Habit/stock_piller/'); ?>" method="POST" class="form_three">
                <div class="shipment">
                    <div class="shipped_pile_s">
                        <?php foreach($shipment['shipped_piles'] as $pile):?>
                            <div class="shipped_pile">
                                <img src="<?php echo base_url('resources/images/'.$pile['product']['image']); ?>" alt="">
                                <div class="shipped_others">
                                    <div class="shipped_box">
                                        <?=$pile['product']['name']?> 
                                        <?=$pile['product']['brand']?>
                                        <?=$pile['product']['quantity']?>
                                    </div>
                                    <div class="shipped_another_box">
                                        <span><?=$pile['product']['pay_date']?></span>
                                        <div class="shipped_and_another_box" >
                                            <?=$pile['formatted'][0]?>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        <?php endforeach;?>
                    </div>
                    <div class="addy">
                        <div class="param">
                            <p>Street address: <?=$shipment['addy']['street_address']?></p>    
                            <p>Closest bustop: <?=$shipment['addy']['closest_bustop']?></p>
                            <p>City:           <?=$shipment['addy']['city']?></p>
                            <p>State:          <?=$shipment['addy']['state']?></p>
                            <p>Country:        <?=$shipment['addy']['country']?></p>
                            <p>State-code:     <?=$shipment['addy']['state_code']?></p>
                            <p>Shipping fee: This part of the program have not been implemented,so we are not really shipping shit.</p>
                            <p>Your tracking details will be sent to your email: <?=$customer['user']['email']?> shortly.</p>
                        </div>
                        <h3>Thank you for stocking with us.</h3>
                    </div>
                </div>
                <button name="get_out" type="submit" class="to_pile"><h3>X</h3></button>
            </form>
        <?php endif;?>
                        
    </div>
    <?=$script?> 
        <?=$script_content?>
        <?=$script_content0?>
        <?=$price_now?>
        <?=$price_on_pay?>
        <?=$function?>
        <?=$function_close?>
    <?=$closing_tag?>
</body>
</html>