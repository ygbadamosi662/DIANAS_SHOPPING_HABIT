<?php  ?>
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

    <?php echo form_open('habit/register'); ?>
    
        <h1>Sign Up with us</h1>

        <div >

        </div>

        <label for="fname">Ur first name</label>
        <input type="text" name="fname" value="<?php echo set_value('fname'); ?>">

        <label for="lname">Ur last name</label>
        <input type="text" name="lname" value="<?php echo set_value('lname'); ?>">

        <label for="phone">Ur phone no.</label>
        <select name="country_code" id="zip">
            <option value="">country code</option>
            <option value="+234">+234 Nigeria</option>
            <option value="+254">+254 Kenya</option>
            <option value="+233">+233 Ghana</option>
            <option value="+27">+27 South Africa</option>
            <option value="+228">+228 Togo</option>
        </select>
        <input type="text" name="phone" value="<?php echo set_value('phone'); ?>" size="50">

        <label for="email">Ur email</label>
        <input type="text" name="email" value="<?php echo set_value('email'); ?>" size="50">
        
        <label for="password">Password</label>
        <input type="text" name="password" value="<?php echo set_value('password'); ?>" size="50">

        <label for="password">Password Confirmation</label>
        <input type="text" name="password_confam" value="<?php echo set_value('password_confam'); ?>" size="50">

        <label for="dob">Ur DOB</label>
        <input type="date" name="dob" value="<?php echo isset($_POST['dob'])?$_POST['dob'] : "" ;?>" size="50">

        <label for="username">Create a username</label>
        <input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50">

        <label for="gender">Ur gender</label>
        <select name="gender" id="gender">
            <option value="female">FEMALE</option>
            <option value="male">MALE</option>
            <option value="other">OTHER</option>
        </select>

        <div><input type="submit" name="Submit" /></div>




    </form>
</body>
</html>