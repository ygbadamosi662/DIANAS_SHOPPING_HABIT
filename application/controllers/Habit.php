<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Habit extends CI_Controller {
    

    public function __construct() {
        
        parent::__construct();

        $this->load->database();
        $this->load->helper(array('form','url','date'));
        $this->load->library('form_validation');
        // $this->load->helper('url');
        $this->load->library('session');
        // $this->load->helper('date');

        
        // $this->load->helper('url', 'form');
        // $this->load->library('form_validation');
    }

    

    

    private function array_trim(array $items): array
    {
        return array_map(function ($item) {
            if (is_string($item)) {
                return trim($item);
            } elseif (is_array($item)) {
                return array_trim($item);
            } else
                return $item;
        }, $items);
    }

    private function sanitize($input,$filters,$delimeter,$trim = TRUE)
    {
        // sanitize(): it sanitizes ur input according to the associative array of $filters provided
        // @$input can be an associative array of inputs or just one inputs
        // @$filters can be an associative array of filters with the key being what data d filter sanitizes
        // the @$input array keys is has a required format,which is name_of_field + delimeter(special characters) + 
        // kind of data u want to sanitize e.g firstname/string:
        // 'firstname' being the name_of_field
        // '/' being d delimeter and 
        // 'string' being the type of data u are sanitizing
        // you can use whatever u want as a delimeter
        // this function returns an associative array of ur sanitized data with name_of_field as its key when both the $input and the $filters are associative array
        // you can use one filter for all ur inputs if you pass a filter as ur parameter instead of an array of filters
        // if only a single input is passed instead of array then a filter is required not an array of fileter and it returns the sanitized data.
            
        if (is_array($input)){
            $data = array();

            
            foreach ($input as $key => $val){
                
                if (is_array($filters)){
                    
                    $pos = strpos($key,$delimeter);
                    $matcher = substr($key,$pos+1);
                    $newKey = substr($key,0,$pos);
                    
                    $filtersKeys = array_keys($filters);
                    $filtersSize = count($filters);

                    for ($i = 0; $i < $filtersSize; $i++){
                        if ($filtersKeys[$i] == $matcher) {
                            if(is_array($filters[$filtersKeys[$i]])){
                                $filter = $filters[$filtersKeys[$i]];
                                $data[$newKey] = filter_var($input[$key],$filter['filter'],$filter['flags']);
                                break;
                            }
                            else{
                                $data[$newKey] = filter_var($input[$key],$filters[$filtersKeys[$i]]);
                                break;
                            }
                            
                        }
                    }
                }
                elseif (is_int($filters)){
                    $data[$key] = filter_var($input[$key],$filters);
                }
            }
            return $trim ? $this->array_trim($data) : $data;

        }
        else if (!is_array($input)){
            
            if (is_int($filters) || $filters['filter']){
                $filtersKey = array_keys($filters);
                if ($filters['filter']){
                    $input = filter_var($input,$filter['filter'],$filter[$filtersKey[1]]);

                    return $trim ? $this->array_trim($input) : $input;

                }
                else{
                    $input = filter_var($input,$filters);
                    return $trim ? $this->array_trim($input) : $input;
                }
                
            }
            else {
                echo 'chk ur shit';
            }
        }
        
    }   

    private function createsTable ($stockPiller,$fields = []){
        // this funtions create our stockPiller users table,when passed a (string) $stockPiller as table name
        //it will also create any table if an appropriate array is passed as a second parameter.
        // Returns True if succesful and False on failure
        

        // if (!$fields){
        //     $fields = array(
                
        //         'name' => array(
        //                 'type'=> 'VARCHAR',
        //                 'constraint'=> '50',
        //                 'null'=> FALSE
        //         ),
        //         'brand' => array(
        //             'type'=> 'VARCHAR',
        //             'constraint'=> '50',
        //             'null'=> FALSE
        //         ),
        //         'quantity'=> array(
        //             'type'=> 'VARCHAR',
        //             'constraint'=> '50',
        //             'null'=> FALSE
        //         ),
        //         'pay_date' => array(
        //             'type'=> 'TIMESTAMP',
        //             'default'=> 'CURRENT_TIMESTAMP',
        //             'null'=> FALSE
        //         ),
        //         'update_on' => array(
        //             'type'=> 'TIMESTAMP',
        //             'default'=> 'CURRENT_TIMESTAMP',
        //             'ON UPDATE' => 'CURRENT_TIMESTAMP',
        //             'null'=> FALSE
        //         ),
        //         'price_on_pay' => array(
        //             'type'=> 'INT',
        //             'constraint'=> '20',
        //             'null'=> FALSE
        //         ),
        //         'price_now' => array(
        //             'type'=> 'INT',
        //             'constraint'=> '20',
        //             'null'=> FALSE
        //         ),
        //         'image' => array(
        //             'type'=> 'VARCHAR',
        //             'constraint'=> '20',
        //             'null'=> FALSE
        //         )
            
        //     );
        // }

        $this->load->dbforge();
        // $this->dbforge->add_field('id');
        // $this->dbforge->add_field($fields);
        $this->dbforge->add_field("`id` INT(9) NOT NULL AUTO_INCREMENT, `name` VARCHAR(50) NOT NULL, `quantity` VARCHAR(50) NOT NULL, `brand` VARCHAR(50) NOT NULL, `pay_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `update_on` TIMESTAMP NOT NULL  ON UPDATE CURRENT_TIMESTAMP, `price_on_pay` INT(20) NOT NULL, `price_now` INT(20) NOT NULL, `image` VARCHAR(20) NOT NULL, CONSTRAINT `pk_` PRIMARY KEY(`id`) ");
        
        
        $queryFunc = $this->dbforge->create_table($stockPiller,TRUE);
        
        if ($queryFunc){
           if(isset($_SESSION['customer']) && ($_SESSION['customer']['user']['stockpiller'] != 'piller')){
                $array_one = array( 'stockpiller' => 'piller');
                $this->db->where('id', $_SESSION['customer']['user']['id']);
                $query = $this->db->update('customers', $array_one);

                if($query == TRUE)
                {
                    return TRUE;
                }
                else
                {
                     return FALSE;
                }
           }
           
            
        }
        else{
            
            return FALSE;
        }

    
    }

    private function houseKeeping($needed = 0,$crypt = array()){
        /** this function enccrypts and decrypts db id,i needed a unique name for my stockpiller user table
         * so i thought why not write a function that encrypts d user id as a table name and make it also 
         * decrypt the encryted string bk to d db id
         * 
         * to encrypt pass the db id as d first argument....this returns an associative array array('key'=>$key(string),
         * 'encrypted'=>$encrypted(string))
         * to decrypt pass 0 as d first argument and d associtive array returned on encryption👆 as a d second argument like this 👉 houseKeeping(0,$array)...this returns its decrypted $id(int)
         */

        //  encryption happens here
        settype($needed,'int');
        if($needed != 0){

            // the 'l' encryption
            if($needed < 1000){
                $harry = array();
                $randi = rand(1,999);
                
                $harry[0] = (string) $randi;
                $harry[1] = '0';
                $harry[2] = '0';
                $harry[3] = '0';

                $key = implode("",$harry);
                $key = (integer) $key;

                $needed = $key + $needed;
                $aa = array();

                for ($i = 0;$i < 3; $i++){
                    $aa[$i] = rand(0,9);
                    $aa[$i] = (string) $aa[$i];
                }

                $bb = implode("",$aa);
                $needed = (string) $needed;

                $bb = $needed.$bb;

                $crypt['encrypted'] = $bb;
                $key = (string) $key;
                $crypt['key'] = $key.'l';
                
                return $crypt;
            }

            // the 'h' encryption
            elseif ($needed > 1000){
                $key = rand(1,999);
                $needed = $needed - $key;

                $aa = array();

                for($i = 0;$i < 3;$i++){
                    $aa[$i] = rand(0,9);
                    $aa[$i] = (string) $aa[$i];
                }

                $bb = implode('',$aa);
                $bb = $bb + $needed;

                $crypt['encrypted'] = $bb;
                $crypt['key'] = (string) $key.'h';

                return $crypt;
            }
        }
        // decryption happens here
        elseif ($needed == 0){
            
            $loopy = strlen($crypt['key']) - 1;
            $arrayEnc = str_split($crypt['encrypted']);
            $arrayKey = str_split($crypt['key']);
            
            // decrypts by opposing the exact logic in its 'l' encryption
            if($arrayKey[$loopy] == 'l'){
                
                unset($arrayKey[$loopy]);
                
                $loopy0 = count($arrayEnc);

                for ($i = 0; $i < $loopy0; $i++){
                    if(($loopy0 - $i) < 4){
                        unset($arrayEnc[$i]);
                    }
                }
                $crypt['encrypted'] = implode('',$arrayEnc);
                $crypt['encrypted'] = (integer) $crypt['encrypted'];

                $crypt['key'] = implode('',$arrayKey);
                $crypt['key'] = (integer) $crypt['key'];

                $id = $crypt['encrypted'] - $crypt['key'];
    
                return $id;
            }
            // decrypts by opposing the exact logic in its 'h' encryption
            elseif($arrayKey[$loopy] == 'h'){
                unset($arrayKey[$loopy]);

                for ($i = 0;$i < 3;$i++){
                        unset($arrayEnc[$i]);
                }

                $crypt['encrypted'] = implode('',$arrayEnc);
                $crypt['encrypted'] = (integer) $crypt['encrypted'];

                $crypt['key'] = implode('',$arrayKey);
                $crypt['key'] = (integer) $crypt['key'];

                $id = $crypt['encrypted'] +  $crypt['key'];
    
                return $id;
            }
            

        }
        

    }

    private function if_exist_in_table ($value,$ofWhat = array()){

        // this function checks if a particular $value (string) exists in a particular field $ofWhat[1] (string),
        //  in a particular table $ofWhat[0] (string),the field and table name are passed as an array $ofWhat
        // it returns true if $value exists,false if $value does not exist and returns nothing if an array $ofWhat is not passed.

        if ($ofWhat != []){
            $i = 0;
            
            $array = array(
                'table' => $ofWhat[0],
                'field' => $ofWhat[1]
            );
            
            $all = $this->db->count_all($array['table']);

            // $this->db->select($array['field']);
            $query = $this->db->get($array['table']);

            foreach ($query->result_array() as $row){
                $i++;
                if ($value == $row[$array['field']]){
                    return true;
                }
                elseif ($i == $all){
                    return false;
                }
                
            }

        }
        
    }

    public function select_validate($value,$array = []){
    // this function just cross-checks the $value with the elements in the $array array 
    // returns true if a match is found and false if a match is not found
    // returns nothing if $array is not passed.

        $i = 0;
        
        if ($array){
            $all = count($array);
            foreach ($array as $data){
                $i++;

                if ($value == $data){
                    return true;
                }
                elseif ($i == $all){
                    return false;
                }
            }
        }
    }

    private function moneyFormatter($moneyString)
    {
        $array = str_split($moneyString);
        $arraylast = count($array)-1;
        $holding = array();
        if ((count($array) > 3)){
            
            $mod = count($array)%3;
            if ($mod == 0){
                $chk = count($array)/3;
            }
            else{
                $chk = ((count($array) - $mod)/3) + 1;
            }
            

            for ($chk; $chk>0; $chk--){
                
                if($arraylast >= 3){
                    
                    $temparray= array_slice($array,$arraylast-2,3);

                    array_push($holding,$temparray);

                    $arraylast = $arraylast-3;
                }
                else 
                {
                    $kik = array();
                    for ($i=0; $i<=$arraylast; $i++){
                        array_push($kik,$array[$i]);
                    }
                    array_push($holding,$kik);
                }
            
            }
            
            $holding = array_reverse($holding);
            $shit = array();
            
            
            foreach($holding as $hold){
                $str = implode('',$hold);
                array_push($shit,$str);
            }
            $formattedString = implode(',',$shit);
            
            return $formattedString;

            
        }
        else{
           
            return $moneyString;
            
        }

       
    }

    private function cartCount($array = array())
    {
        // to count session cart
            $counter = 0;
            if($array){
                foreach($array as $ass){
                    if($array['count'] != $ass){
                        settype($ass['quantity'],'int');
                        $counter = $counter + $ass['quantity'];
                        settype($ass['quantity'],'string');
                        
                        
                    }

                }
                
                if((isset($_SESSION['cart'])) && !(isset($data['stockpile']))){
                    $_SESSION['cart']['count'] = $counter;
                    return TRUE;
                }
                else{
                    return $counter;
                }
            }
            else{
                echo 'array required';
            }

            
    }

    private function subtotal($session = array())
    {
        $total = 0;
        if($session){
        
            foreach($session as $ss) {
                if($ss != ($session['count']))
                {
                    
                    settype($ss['product']['price'],'int');
                    settype($ss['quantity'],'int');
                    $total = $total + ($ss['product']['price'] * $ss['quantity']);
                    settype($ss['product']['price'],'string');
                    settype($ss['quantity'],'string');
                }
            }
            settype($total,'string');

            return $total;
        }
        else{
            echo 'array required';
        }

    }

    private function logged_out()
    {
        unset($_SESSION['customer']);
        if(isset($_SESSION['stockpile']))
        {
            unset($_SESSION['stockpile']);
        }
        
    }

    private function pile_saver()
    {
        // this function inserts in batch into the stockpillers table
        // it returns True on success and array of errors on failure

        if(isset($_SESSION['cart'])){
            
            $array = array();
            $i = 0;
            
            foreach($_SESSION['cart'] as $item)
            {
                $kik = $i;
                
                if( $item != $_SESSION['cart']['count']){

                    $fields = array(
                        'name' => $item['product']['name'],
                        'brand' => $item['product']['brand'],
                        'quantity'=> $item['quantity'],
                        'price_on_pay' => $item['product']['price'],
                        'price_now' => $item['product']['price'],
                        'image' => $item['product']['image']
                    );
                    
                    if(isset($_SESSION['stockpile']))
                    {
            
                        foreach($_SESSION['stockpile'] as $pile)
                        {
                            
                            if($pile != $_SESSION['stockpile']['count'])
                            {
            
                                if( ($fields['brand'] == $pile['product']['brand']) && ($fields['name'] == $pile['product']['name']) && ($fields['price_now'] == $pile['product']['price_now']) )
                                {
                                   
                                    $new_val = (int) $fields['quantity'] + (int) $pile['product']['quantity'];
                                    
                                    echo $new_val;
                                    
                                    $up_date = array(
                                        'quantity' => (string) $new_val
                                    );
                                    $this->db->where('id', $pile['product']['id']);
                                    $query = $this->db->update($_SESSION['customer']['user']['username'], $up_date);
                                    if($query == TRUE){
                                        $i = $i + 1;
                                        
                                    }
                                    else
                                    {
                                        echo 'something wrong in update in pile_saver()';
                                    }
  
                                }
                                
                            }
                        }
                    
                        if($kik == $i)
                        {
                            $array[$i] = $fields;
                            $i = $i+1;
                        }
                        
                        
                    }
                    else
                    {
                        $array[$i] = $fields;
                        $i = $i+1;
                    }
                     
                }   
            }

            if(count($array) == 1)
            {
                
                $query = $this->db->insert($_SESSION['customer']['user']['username'],$array[0]);
                
                return $query;
            }
            elseif(count($array) > 1)
            {
                $query = $this->db->insert_batch($_SESSION['customer']['user']['username'],$array);
                
                return $query;
            }
            elseif(count($array) == 0)
            {   
                return;
            }
             
        }
    }

    private function cart_clear()
    {
        if(isset($_SESSION['cart'])){
            unset($_SESSION['cart']);
        }
    }

    private function pile_loader()
    {
        // loads the stockpiller's pile
        // only called if there is a pile to load

        echo 'pile_loader called';
        if(isset($_SESSION['customer']))
        {
            $query = $this->db->get($_SESSION['customer']['user']['username']);
            if($query->result_array())
            {
                $_SESSION['stockpile'] = array();
                $count = 0;
                foreach($query->result_array() as $product)
                {
                    
                    $str = (string) $product['id'];
                    
                    $product_pon = $this->moneyFormatter($product['price_on_pay']);
                    $product_pnow = $this->moneyFormatter($product['price_now']);
                    $_SESSION['stockpile'][$str] = array( 'product' => $product,
                    'formatted' => array($product_pon,$product_pnow)
                    );
                    $count = $count + (int) $product['quantity'];
                }
                
                $_SESSION['stockpile']['count'] = $count;
                
                return TRUE;
            }
            else
            {
                echo 'database call failed in pile_loader()';
            }
        }
        else{
            echo 'no customer logged in';
        }
    }

    private function pile_counter( $c = '',$b = '',$act = TRUE)
    {
        if($act == TRUE)
        {
            $compare = (int) $c;
            $b = (int) $b;
            
            if( $compare > $b)
            {
                $b = $b + 1;
                
            }

            return (string) $b;
        }
        elseif($act == FALSE)
        {
            // echo $b;
            $b = (int) $b;
            if( $b > 1)
            {
                $b = $b - 1;   
            }
           
            return (string) $b;
        }
        else{
            return 'nothing to count';
        }

        

    }

    private function stock_ship($quantity = '',$address = '')
    {
        $c = strlen($address);
        $keys = array(
            'street_address',
            'closest_bustop',
            'city',
            'state',
            'country',
            'state_code'
        );
        
        $array = array();

        $token = strtok($address, ",");
        $i = 0;
        while ($token !== false)
        {
            
           $array[$keys[$i]] = $token;

           ++$i;
           $token = strtok(",");
        }

        $array['quantity'] = $quantity;

        return $array;

    }

    private function pile_manager($update,$where = '')
    {
        if(!(is_array($update)) && (settype($update,'int') == TRUE))
        {
           
            $stock = (string) $where;
            
            $update = (int) $_SESSION['stockpile'][$stock]['product']['quantity'] - $update;
            if($update == 0)
            {
                $this->db->where('id', $where);
                $query = $this->db->delete($_SESSION['customer']['user']['username']);

                if($query == TRUE)
                {
                    unset($_SESSION['stockpile'][$stock]);
                    if($this->pile_loader() == TRUE)
                    {
                        return TRUE;
                    }
                    else
                    {
                        echo 'pile_loader() failed'; 
                    }
                    
                }
            }
            else
            {
                $array = array(
                    'quantity' => (string) $update
                );

                $this->db->where('id', $where);
                $query = $this->db->update($_SESSION['customer']['user']['username'],$array);
                if($query == TRUE)
                {
                    if($this->pile_loader() == TRUE)
                    {
                        return TRUE;
                    }
                    else
                    {
                        echo 'pile_loader() failed'; 
                    }
                }
                else
                {
                    return FALSE;
                }
            }
            
        }
        elseif(is_array($update))
        {
            
            $i = 0;
            $result = array();
            $keys = array_keys($update);
            foreach($update as $db_in)
            {
                $result[$i] = $this->pile_manager($db_in,(int) $keys[$i]);
                echo $result[$i];
                $i = $i + 1;
                
            }
            
            return $result;

        }
        else
        {
            echo 'sometthing is wrong in ur call pile_manager()';
        }

    }

    private function select_collector($data,$selected_piles = array())
    { 
        foreach($data as $pile)
        {
            if($pile != $data['count'])
            {  
                if(isset($_POST[$pile['product']['id']]))
                {
                    $selected_piles[$pile['product']['id']] = $pile;
                }
            }
        }

        return $selected_piles;
        
    }

    // endpoints // endpoints // endpoints // endpoints // endpoints // endpoints // endpoints // endpoints ///////
	public function index()
	{
        
        // echo ('PHP version: ' . phpversion());
        // $datestring = 'Year: %Y Month: %m Day: %d - %h:%i %a';
        // $datestring = '%h:%i %a';
        // $time = time();
        // echo mdate($datestring, $time);

        isset($_POST['logout']) ? $this->logged_out() : '' ;
        // unset($_SESSION['stockpile']);
        
        $query = $this->db->get('products');
        if($query->result_array()){
            $products = $query->result_array();
            
            $data['product'] = array();
            foreach($products as $product){
                
                $data['product'][$product['name']] = array('product' => $product, 'quantity' => '1', 'formatted' => $this->moneyFormatter($product['price']) );
            }
            if(isset($_SESSION['cart'])){
                $data['product']['count'] = $_SESSION['cart']['count'];
            }
            if(isset($_SESSION['customer'])){
                $data['customer'] = $_SESSION['customer'];
            }
            $this->load->view('cart_views/navi',$data);
		    $this->load->view('cart_views/home',$data);

        }

	}

    public function register($email = 0){

        if($email != 0){
            $_POST['email'] = $email;
        }

        if(isset($_SESSION['cart'])){
            $data['product'] = $_SESSION['cart'];
        }
        
        $this->form_validation->set_rules('fname','Firstname','required|trim|max_length[15]|min_length[2]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
        ));
        $this->form_validation->set_rules('lname','Lastname','required|max_length[15]|min_length[2]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters'
        ));
        $this->form_validation->set_rules('phone','Phone Number','required|max_length[15]|min_length[10]|is_unique[customers.phone]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters'
        ));
        $this->form_validation->set_rules('email','Email','required|max_length[100]|min_length[11]|is_unique[customers.email]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
            'is_unique' => '{field} already exist '
        ));
        $this->form_validation->set_rules('password','Password','required',array(
            'required' => '{field} is required'
        ));
        $this->form_validation->set_rules('password_confam','Password Confirmation','required|matches[password]',array(
            'required' => '{field} is required',
            'matches' => '{field} does not match'
        ));
        $this->form_validation->set_rules('dob','Date of birth','required',array(
            'required' => '{field} is required',
        ));
        $this->form_validation->set_rules('username','Username','required|max_length[15]|min_length[3]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters'
        ));

        if( $this->form_validation->run() == FALSE ){

            $this->load->view('cart_views/navi',$data);
            $this->load->view('cart_views/sign_up_page',$data);
        }
        else
        {
            $in = [
                'fname_string' => $_POST['fname'],
                'lname_string' => $_POST['lname'],
                'password_string' => $_POST['password'],
                'country_code_string' => $_POST['country_code'],
                'phone_string' => $_POST['phone'],
                'email_email' => $_POST['email'],
                'gender_string' => $_POST['gender'],
                'dob_string' => $_POST['dob'],
                'username_string' => $_POST['username']
             ];
             $filters = array(
                 'string' => FILTER_SANITIZE_STRING,
                 'string[]' => array(
                     'filter' => FILTER_SANITIZE_STRING,
                     'flags' => FILTER_REQUIRE_ARRAY
                 ),
                 'email' => FILTER_SANITIZE_EMAIL,
                 'int' => array(
                     'filter' => FILTER_SANITIZE_NUMBER_INT,
                     'flags' => FILTER_REQUIRE_SCALAR
                 ),
                 'int[]' => array(
                     'filter' => FILTER_SANITIZE_NUMBER_INT,
                     'flags' => FILTER_REQUIRE_ARRAY
                 ),
                 'float' => array(
                     'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
                     'flags' => FILTER_FLAG_ALLOW_FRACTION
                 ),
                 'float[]' => array(
                     'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
                     'flags' => FILTER_REQUIRE_ARRAY
                 ),
                 'url' => FILTER_SANITIZE_URL
            );
         
            $sanitized = $this->sanitize($in,$filters,'_');
            $sanitized['stockpiller'] = 'non-piller';
            $query = $this->db->insert('customers',$sanitized);
            
            if($query == TRUE){
                $query = $this->db->get_where('customers',array('email'=> $sanitized['email']));
                if($query->result_array()){
                    $oboy = $query->result_array();

                    // if ($oboy[0]['password'] == $sanitized['password']){
                    $maxi = 15; 
                    $datestring = '%h:%i %a';
                    $min_string ='%i';
                    $time = time();
                    // echo mdate($datestring, $time);
                    $min = mdate($min_string, $time);

                    settype($min,'int');
                    $min = $min + $maxi;
                    settype($min,'string');

                    $time_out_string = '%h:'.$min.' %a';
                    $time_out = mdate($time_out_string, $time);
                    $data['customer'] = array($oboy[0]['name'] => $oboy[0],
                    'logged_in' => mdate($datestring, $time),
                    'time_out' => $time_out);
                    $_SESSION['customer'] = $data['customer'];
                    
                }
                if($email != 0){
                    $this->load->view('cart_views/navi.php',$data);
                    $this->load->view('cart_views/chk_stock.php',$data);
                }
                else{
                    $data['success'] = 'Your Brand new Misola Shopping Habit account has been registered successfully';
                    $this->load->view('cart_views/navi.php',$data);
                    $this->load->view('cart_views/formsuccess.php',$data);
                }
            }
            else{
                echo 'db request not successful';
            }
               
        }  

        
    }
        
    public function shop ($id = 0)
    {
        isset($_POST['logout']) ? $this->logged_out() : '' ;

        
        $query = $this->db->get_where('products',array('product_id'=>$id));
        if ($query){
            
            $oBoy = $query->result_array();
            
            $data['product'] = array($oBoy[0]['name'] => array('product' => $oBoy[0]) );
            $data['product'][$oBoy[0]['name']]['formatted'] = $this->moneyFormatter($oBoy[0]['price']);
            $data['product'][$oBoy[0]['name']]['quantity'] = '1';
            $data['name'] = $oBoy[0]['name'];

            if(isset($_SESSION['cart'])){
                $data['product']['count'] = $_SESSION['cart']['count'];
            }
            
            if (isset($_POST['submit'])){
               
                if(isset($_SESSION['cart'])){
                    if (array_key_exists($oBoy[0]['name'],$_SESSION['cart'])){
                        settype($_SESSION['cart'][$oBoy[0]['name']]['quantity'],'int');
                        $_SESSION['cart'][$oBoy[0]['name']]['quantity']++;
                        
                        settype($_SESSION['cart'][$oBoy[0]['name']]['quantity'],'string');
                        
                        $this->cartCount($_SESSION['cart']);
                    }
                    else{
                        $_SESSION['cart'][$oBoy[0]['name']] = $data['product'][$oBoy[0]['name']];

                        $this->cartCount($_SESSION['cart']);
                        
                    }
                }
                else{
                    $_SESSION['cart'] = $data['product'];
                    
                    $this->cartCount($_SESSION['cart']);
                   
                }

                if($this->cartCount($_SESSION['cart']) == TRUE){
                    $data['product'] = $_SESSION['cart'];
                    
                }
                else{
                    $data['product']['count'] = $this->cartCount($data['product']);
                }
    
                echo '<div class="alert">'.'item added to cart succesfully'.'</div>';
            }

            if(isset($_SESSION['customer'])){
                $data['customer'] = $_SESSION['customer'];
            }

            $this->load->view('cart_views/navi.php',$data);
            $this->load->view('cart_views/cart_page.php',$data);
        }
        else{
            echo 'something went wrong';
        }
    }

    
    public function cart(){ 
        
        isset($_POST['logout']) ? $this->logged_out() : '';
        
        $data['subtotal'] = $this->moneyFormatter($this->subtotal($_SESSION['cart']));
        
        $data['product'] = $_SESSION['cart']; 
       
        if((count($_SESSION['cart']) > 0)){
           
            if(isset($_POST['plus'])) {
               settype($_SESSION['cart'][$_POST['subtle']]['quantity'],'int');
               if( !($_SESSION['cart'][$_POST['subtle']]['quantity'] >= $_SESSION['cart'][$_POST['subtle']]['product']['quantity']) ){
                    settype($_SESSION['cart'][$_POST['subtle']]['quantity'],'int');
                    ++$_SESSION['cart'][$_POST['subtle']]['quantity'];
                    settype($_SESSION['cart'][$_POST['subtle']]['quantity'],'string');
                    $this->cartCount($_SESSION['cart']);
                    $data['product'] = $_SESSION['cart'];
                    $data['subtotal'] = $this->moneyFormatter($this->subtotal($_SESSION['cart']));
                }
                else{
                    settype($_SESSION['cart'][$_POST['subtle']]['quantity'],'string'); 
                }
            }
            elseif(isset($_POST['minus'])){
                
                if($_SESSION['cart'][$_POST['subtle']]['quantity'] != '0'){
                   settype($_SESSION['cart'][$_POST['subtle']]['quantity'],'int');
                
                   --$_SESSION['cart'][$_POST['subtle']]['quantity'];
                   settype($_SESSION['cart'][$_POST['subtle']]['quantity'],'string');

                   $this->cartCount($_SESSION['cart']);
                   
                   $data['product'] = $_SESSION['cart'];
                   $data['subtotal'] = $this->moneyFormatter($this->subtotal($_SESSION['cart']));
                
                   if($_SESSION['cart'][$_POST['subtle']]['quantity'] == '0'){

                       unset($_SESSION['cart'][$_POST['subtle']]);
                       $this->cartCount($_SESSION['cart']);
                       $data['product'] = $_SESSION['cart'];
                       
                   }
                }
            }
            elseif(isset($_POST['remove']))
            {
                
                unset($_SESSION['cart'][$_POST['subtle']]);
                
                if(count($_SESSION['cart']) <= 1)
                {
                     unset($_SESSION['cart']);
                     $data['product'] = $_SESSION['cart'];
                }
                else
                {
                    $this->cartCount($_SESSION['cart']);
                    $data['product'] = $_SESSION['cart'];
                    $data['subtotal'] = $this->moneyFormatter($this->subtotal($_SESSION['cart']));
                }
            }
        }
        if(isset($_SESSION['cart'])){
            $this->cartCount($_SESSION['cart']);
        }

        if(isset($_SESSION['customer'])){
            $data['customer'] = $_SESSION['customer'];
        }
        
        $this->load->view('cart_views/navi.php',$data);
        $this->load->view('cart_views/list_item.php',$data);
       
    }

    public function loginHandler($id = 0){
        
        // isset($_POST['logout']) ? $this->logged_out() : '';

        if($id != 0){
            $query = $this->db->get_where('customers',array('customer_id'=> $id));
            $ogal = $query->result_array();
            $_POST['email'] = $ogal[0]['email'];
            $data['id'] = $id;
        }
        
        $this->form_validation->set_rules('email','Email','required|trim|max_length[50]|min_length[5]|valid_email',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
            'valid_email' => 'Not a valid email'
        ));

        $this->form_validation->set_rules('password','Password','required|trim|max_length[50]|min_length[6]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
        ));

        if($this->form_validation->run() == FALSE){
            if(isset($_SESSION['cart'])){
                $data['product'] = $_SESSION['cart'];
            }

            $this->load->view('cart_views/navi',$data);
            $this->load->view('cart_views/sign_in');
        }
        else{
            // if(isset($_POST['submit_login'])){
           
            if($id != 0){
                $oboy = $ogal;
            }
            else{
                $query = $this->db->get_where('customers',array('email'=> $_POST['email']));
                $oboy = $query->result_array();
            }
            if($query->result_array()){
                if ($oboy[0]['password'] == $_POST['password']){
                    $maxi = 15; 
                    $datestring = '%h:%i %a';
                    $min_string ='%i';
                    $time = time();
                    // echo mdate($datestring, $time);
                    $min = mdate($min_string, $time);
                    settype($min,'int');
                    $min = $min + $maxi;
                    settype($min,'string');
                    $time_out_string = '%h:'.$min.' %a';
                    $time_out = mdate($time_out_string, $time);
                    $data['customer'] = array('user' => $oboy[0],
                    'logged_in' => mdate($datestring, $time),
                    'time_out' => $time_out
                    );
                    $_SESSION['customer'] = $data['customer'];
                    if(isset($_SESSION['cart'])){
                        $data['product'] = $_SESSION['cart'];
                    }
                   
                    if($id != 0){
                        
                        $this->load->view('cart_views/navi.php',$data);
                        $this->load->view('cart_views/chk_stock',$data);
                    }
                    else{
                        
                        $data['success'] = 'Log in Successful....enjoy shopping 😎';
                        $this->load->view('cart_views/navi.php',$data);
                        $this->load->view('cart_views/formsuccess.php',$data);
                    }
                }
                else{
                    $data['error'] = 'Email or password not correct';
                    $this->load->view('cart_views/navi',$data);
                    $this->load->view('cart_views/sign_in',$data);
                }
            
            }
            else{
                $data['error'] = 'Email or password not correct';

                $this->load->view('cart_views/navi.php',$data);
                $this->load->view('cart_views/sign_in.php',$data);
            }
            
        }
        

    }

    public function check_out(){
        isset($_POST['logout']) ? $this->logged_out() : '';

        if(isset($_SESSION['customer'])){
            if(isset($_POST['pay_ship'])){
                if((isset($_SESSION['cart'])) && ($_SESSION['cart']['count'] != 0)){
                    $data['product'] = $_SESSION['cart'];
                    $data['subtotal'] = $this->moneyFormatter($this->subtotal($_SESSION['cart']));
                }
                $data['dont_click']['or'] = 'Payment not implemented yet,dont click';
                
                $this->load->view('cart_views/navi.php',$data);
                $this->load->view('cart_views/pay_page.php',$data);

            }
            if(isset($_POST['multi'])){
                if((isset($_SESSION['cart'])) && ($_SESSION['cart']['count'] != 0)){
                    $data['product'] = $_SESSION['cart'];
                    $data['subtotal'] = $this->moneyFormatter($this->subtotal($_SESSION['cart']));
                }
                $data['dont_click']['or'] = 'Payment not implemented yet,dont click';
                $data['dont_click']['if'] = 'You sturborn goat,i said dont click';

                $this->load->view('cart_views/navi.php',$data);
                $this->load->view('cart_views/pay_page.php',$data);
            }
            if(!(isset($_POST['pay_ship'])) && !(isset($_POST['multi']))){
                $this->load->view('cart_views/navi.php',$data);
                $this->load->view('cart_views/chk_stock.php',$data);
            }
            
        }
        else{
            if(isset($_POST['go_to'])){
                $query = $this->db->get_where('customers',array('email'=> $_POST['email']));
                
                if($query->result_array()){
                    $oboy = $query->result_array();
                    $data['id'] = $oboy[0]['customer_id'];
                    $data['go_to'] = 'login';
                }
                else{
                    $data['go_to'] = $_POST['email'];
                }
            }

            $this->load->view('cart_views/navi.php',$data);
            $this->load->view('cart_views/checkout.php',$data);
        }

        

    }

    public function stock_piller($from = '',$form_manager = '')
    {
        
        if(isset($_SESSION['customer']))
        {
            isset($_POST['logout']) ? $this->logged_out() : '';

            $data['customer'] = $_SESSION['customer'];

            $i = 'start';
            
            
            if( $_SESSION['customer']['user']['stockpiller']  == 'non-piller')
            {
                if($from == 'from_nav'){
                    echo $from;
                    $this->load->view('cart_views/navi.php',$data);
                    $this->load->view('cart_views/about_stockpilling.php',$data);
                }

                if(isset($_POST['submit_stock']) && ($_POST['terms_read'] == 'yes') ){
                    if($this->createsTable($_SESSION['customer']['user']['username'])){
                        // creates table and update the customer stockpiling status
                        $i = 'done';
                        $data['stock_info'] = 'Your stock have been successfully created';
                    }
                }
                else{
                    echo 'you have to chk the box mate';
                }

                if(($i  == 'start') && ($from != 'from_nav'))
                {
                    $this->load->view('cart_views/navi.php',$data);
                    $this->load->view('cart_views/terms_condition.php',$data);
                }
                elseif ($i  == 'done')
                {
                    // if(isset($_SESSION['stockpile']) == FALSE)
                    // {
                    //     $_SESSION['stockpile'] = $this->pile_loader(); 
                    // }
                    if(isset($_SESSION['cart']))
                    {
                        $data['pile_info'] = $this->pile_saver();
                        $this->cart_clear();
                        if($this->pile_loader() == TRUE)
                        {
                            echo 'pile_loader  worked';
                            
                            $data['stockpile'] = $_SESSION['stockpile'];
                        }
                        else
                        {
                            echo 'pile_loader didnt work';
                        } 
                    }
                    
        
        
                    $this->load->view('cart_views/navi.php',$data);
                    $this->load->view('cart_views/stockpile.php',$data);

                }
            }
            elseif( $_SESSION['customer']['user']['stockpiller']  == 'piller' )
            {

                if( ( isset($data['stockpile']) == FALSE) && ($this->pile_loader() == TRUE )  )
                {
                    $data['stockpile'] = $_SESSION['stockpile'];
                }
                else
                {
                    echo 'pile_loader didnt work';
                }
                
                // if(isset($_SESSION['stockpile']) == FALSE)
                // {
                     
                // }
                // else
                // {
                //     $data['stockpile'] = $_SESSION['stockpile']; 
                // }
                // var_dump($_SESSION['stockpile']);
                // pile_saver saves the whole pile.
                // cart_clear clears the cart
                if(isset($_SESSION['cart']) )
                {
                    // when payment is implemented,come bk to this
                    $data['pile_info'] = $this->pile_saver();
                    $this->cart_clear();
                    if($this->pile_loader() == TRUE)
                    {
                        $data['stockpile'] = $_SESSION['stockpile'];
                    }
                    else
                    {
                        echo 'pile_loader didnt work';
                    } 
                }
                
                $i = 'done';
                
                // javascript
                // $data['script'] = "<script type='text/JavaScript'>\n";
            
                // $data['script_content']  = "let and_another_box = document.querySelector('.and_another_box')\n";
                // $data['script_content0'] ="and_another_box.addEventListener('mouseover',changeShit)\n";
                // $data['price_now'] = "let var_one = ".$data['stockpile'][$product['name']]['product']['price_now']."\n";
                // $data['price_on_pay'] = "let var_two = ".$data['stockpile'][$product['name']]['product']['price_on_pay']."\n";
                // $data['function'] = "function changeShit(){\n
                //     if(and_another_box.textContent == var_one )
                //     {\n
                //         and_another_box.textContent = var_two 
                //         console.log(var_two)\n
                //     }\n
                //     else if(and_another_box.textContent == var_two )
                //     {\n
                //         and_another_box.textContent = var_one
                //     }\n";    
                // $data['function_close'] = "}\n";
                // $data['closing_tag'] = "</script>\n";
            }

            if($i  == 'done')
            {
                $data['id'] = $from;
                
                if(isset($_POST['plus']))
                {
                    $act = TRUE;
                    $data['id'] = $_POST['plus'];
                    
                    if(isset($_SESSION['math'][$_POST['plus']]))
                    {
                        $_SESSION['math'][$_POST['plus']] = $this->pile_counter($_SESSION['stockpile'][$_POST['plus']]['product']['quantity'], $_SESSION['math'][$_POST['plus']], $act);
                    }
                    else
                    {
                        $_SESSION['math'][$_POST['plus']] = $this->pile_counter($_SESSION['stockpile'][$_POST['plus']]['product']['quantity'], $data['stockpile'][$_POST['plus']]['product']['quantity'], $act);
                    }

                }

                elseif(isset($_POST['minus']))
                {
                    $act = FALSE;
                    $data['id'] = $_POST['minus'];

                    if(isset($_SESSION['math'][$_POST['minus']]))
                    {
                        $_SESSION['math'][$_POST['minus']] = $this->pile_counter($_SESSION['stockpile'][$_POST['minus']]['product']['quantity'], $_SESSION['math'][$_POST['minus']], $act);
                    }
                    else
                    {
                        $_SESSION['math'][$_POST['minus']] = $this->pile_counter($_SESSION['stockpile'][$_POST['minus']]['product']['quantity'], $data['stockpile'][$_POST['minus']]['product']['quantity'], $act);
                    }
                   
                }

                if(isset($_SESSION['math']))
                {
                    $keys = array_keys($_SESSION['math']);

                    foreach($keys as $key)
                    {
                        if(array_key_exists($key,$data['stockpile']))
                        {
                            $data['stockpile'][$key]['product']['quantity'] = $_SESSION['math'][$key];
                        }
                    }
                }

                if(isset($_POST['ship']))
                {
                    $data['id'] = $_POST['ship'];
                }

                if(isset($_POST['the_selected']))
                {
                    $data['selected_piles'] = $this->select_collector($data['stockpile'],$data['selected_piles']);

                    if(is_array($data['selected_piles']))
                    {
                       $_SESSION['selected_piles'] = $data['selected_piles'];
                       $data['select_pass'] = TRUE;
                    }
                    else
                    {
                        $data['select_pass'] = FALSE;
                    }
                }
                
                if(isset($_POST['shipping_details']))
                {
                    $this->form_validation->set_rules('street_address','Street Address','required|regex_match[/[a-zA-Z0-9 ]+/i]',array(
                        'required' => '{field} is required',
                        'regex_match' => 'your {field} does not look right'
                    ));
                    $this->form_validation->set_rules('closest_bustop','Closest bustop','required|regex_match[/[a-zA-Z]+/i]',array(
                        'required' => '{field} is required',
                        'regex_match' => 'Your {field} does not look right.'
                    ));
                    $this->form_validation->set_rules('city','City/Town','required|regex_match[/[a-zA-Z]+[0-9]{0}/i]',array(
                        'required' => '{field} is required',
                        'regex_match' => 'Your {field} dont look right'
                    ));
                    $this->form_validation->set_rules('state','State','required|regex_match[/[a-zA-Z]+[0-9]{0}/i]',array(
                        'required' => '{field} is required',
                        'regex_match' => 'Your {field} dont look right'
                    ));
                    $this->form_validation->set_rules('country','Country','required|regex_match[/[a-zA-Z]+[0-9]{0}/i]',array(
                        'required' => '{field} is required',
                        'regex_match' => 'Your {field} dont look right'
                    ));
                    $this->form_validation->set_rules('state_code','State code','required|regex_match[/[0-9]{5}/]',array(
                        'required' => '{field} is required',
                        'regex_match' => 'Your {field} dont look right'
                    ));

                    if( $this->form_validation->run() == FALSE)
                    {
                        $data['form_manager'] = 'not_validated';
                        $data['customer'] = $_SESSION['customer'];
                        if(isset($_SESSION['cart']))
                        {
                            $data['cart'] = $_SESSION['cart'];
                        }
                        $this->load->view('cart_views/navi.php',$data);
                        $this->load->view('cart_views/stockpile.php',$data);
                    }
                    else
                    {
                        
                        $data['form_manager'] = 'form_validated';

                        if($data['select_pass'] == TRUE)
                        {
                            $bully = $this->pile_manager($_SESSION['selected_piles']);
                            $i = 0;
                            foreach($bully as $bull)
                            {
                                if($bull == TRUE)
                                {
                                    $i = $i + 1;
                                }
                            }

                            if($i == count($bully))
                            {
                                $hole = array($_SESSION['selected_piles']);

                                var_dump($hole);
                            }
                            
                        }
                        else
                        {
                            $for_int_sake = (int) $data['id'];
                            $bully = $this->pile_manager($data['stockpile'][ $data['id']]['product']['quantity'],$for_int_sake);
                            if($bully == TRUE)
                            {
                                $hole = array($data['stockpile'][$data['id']]);
                                var_dump($hole);
                            }
                        }

                        $data['shipment'] = array(
                            'shipped_piles' => $hole,
                            'addy' => array(
                                'street_address' => $_POST['street_address'],
                                'closest_bustop' => $_POST['closest_bustop'],
                                'city' => $_POST['city'],
                                'state' => $_POST['state'],
                                'country' => $_POST['country'],
                                'state_code' => $_POST['state_code']
                            )
                        );

                        unset($_SESSION['math']);
                    }
                }

                
                
                if( isset($data['id']) && ( isset($_POST['plus']) || isset($_POST['minus']) ) )
                {
                    $data['stockpile'][$data['id']]['product']['quantity'] = $_SESSION['math'][$data['id']];

                    // var_dump($data['stockpile'][$data['id']]);
                }
                // unset($_SESSION['counter']);
                
                // echo $data['id'].'fmn';
                
                // var_dump($data['stockpile']);
                // $data['subtotal'] = $this->moneyFormatter($this->subtotal($data['stockpile']));
                // var_dump($data['shipment']);
                // echo $this->pile_manager($data['stockpile'][ $data['id']]['product']['quantity'],$for_int_sake);

                // var_dump($data['stockpile']);

                if( $data['form_manager'] == 'form_validated' || $data['form_manager'] == '' )
                {
                    $this->load->view('cart_views/navi.php',$data);
                    $this->load->view('cart_views/stockpile.php',$data);
                }
            }

        }
        
        
        
        

    }

    public function catalog ($search_for = '')
    {
        isset($_POST['logout']) ? $this->logged_out() : '';
        
        if(isset($_POST['search']))
        {
            echo $_POST['search_for'];
            if(isset($_POST['search_for']))
            {
                $this->db->where('name',$_POST['search_for']);
                $this->db->or_where('brand', $search_for);
                $query = $this->db->get('products');
                if($query->result_array())
                {
                    foreach($query->result_array() as $result)
                    {
                        $data['results'][$result['name']] = array('product' => $result,
                                                        'formatted' => $this->moneyFormatter($result['price']) );
                    }
                }
            }
        }

        if(isset($_SESSION['cart']))
        {
            $data['product'] = $_SESSION['cart'];
        }

        if(isset($_SESSION['customer']))
        {
            $data['customer'] = $_SESSION['customer'];
        }


        $this->load->view('cart_views/navi.php',$data);
        $this->load->view('cart_views/catalog.php',$data);
    }
    
}