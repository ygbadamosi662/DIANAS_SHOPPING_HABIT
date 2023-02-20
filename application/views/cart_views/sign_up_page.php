<?php  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .register form{
            display: grid;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .register form div{
            display: flex;
            align-items: center;
            justify-content: center;

        }
    </style>
</head>
<body>
    <div class="register">
        <?php echo validation_errors(); ?>
        <h1>Sign Up with us</h1>
        <?php echo form_open('habit/register'); ?>
            <div>
                <label for="fname">Ur first name</label>
                <?php echo form_error('fname'); ?>
                <input type="text" name="fname" value="<?php echo set_value('fname'); ?>">
            </div>

            <div>
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
                <?php echo form_error('phone'); ?>
                <input type="text" name="phone" value="<?php echo set_value('phone'); ?>" size="50">
            </div>

            <div>
                <label for="email">Ur email</label>
                <?php echo form_error('email'); ?>
                <input type="text" name="email" value="<?php echo isset($email)?$email: set_value('email'); ?>" size="50">
            </div>

            <div>
                <label for="password">Password</label>
                <?php echo form_error('password'); ?>
                <input type="text" name="password" value="<?php echo set_value('password'); ?>" size="50">
            </div>

            <div>
                <label for="password_confam">Password Confirmation</label>
                <?php echo form_error('password'); ?>
                <input type="text" name="password_confam" value="<?php echo set_value('password_confam'); ?>" size="50">
            </div>

            <div>
                <label for="dob">Ur DOB</label>
                <?php echo form_error('dob'); ?>
                <input type="date" name="dob" value="<?php echo isset($_POST['dob'])?$_POST['dob'] : "" ;?>" size="50">
            </div>

            <div>
                <label for="username">Create a username</label>
                <?php echo form_error('username'); ?>
                <input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50">
            </div>

            <div>
                <label for="gender">Ur gender</label>
                <?php echo form_error('gender'); ?>
                <select name="gender" id="gender">
                    <option value="female">FEMALE</option>
                    <option value="male">MALE</option>
                    <option value="other">OTHER</option>
                </select>
            </div>

            <div><input type="submit" name="Submit" /></div>




        </form>
    </div>
</body>
</html>