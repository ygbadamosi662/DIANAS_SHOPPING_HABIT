<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Habit extends CI_Controller {
    

    
    public function __construct() {
        
        parent::__construct();
        $this->load->database();
        
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
            
        if (is_array($input)){
            $data = array();

            
            foreach ($input as $key => $val){
                

                if (is_array($filters)){
                    $array = str_split($key);
                    
                    $pos = strpos($key,$delimeter);

                    $matcher = implode('',array_slice($array,$pos+1));
                    
                
                    $filtersKeys = array_keys($filters);
                    $filtersSize = count($filters);


                    for ($i = 0; $i < $filtersSize; $i++){
                        if ($filtersKeys[$i] == $matcher) {
                            if(is_array($filters[$filtersKeys[$i]])){
                                $filter = $filters[$filtersKeys[$i]];
                                $data[$key] = filter_var($input[$key],$filter[0],$filter[1]);
                                break;
                            }
                            else{
                                $data[$key] = filter_var($input[$key],$filters[$filtersKeys[$i]]);
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
        
        

        if (!$fields){
            $fields = array(
                'name' => array(
                        'type'=> 'VARCHAR',
                        'constraint'=> '50',
                        'null'=> FALSE
                ),
                'brand' => array(
                    'type'=> 'VARCHAR',
                    'constraint'=> '50',
                    'null'=> FALSE
                ),
                'sku'=> array(
                    'type'=> 'VARCHAR',
                    'constraint'=> '50',
                    'null'=> FALSE,
                    'unique'=> TRUE
                ),
                'size'=> array(
                    'type'=> 'VARCHAR',
                    'constraint'=> '4',
                    'null'=> FALSE
                ),
                'quatity'=> array(
                    'type'=> 'INT',
                    'constraint'=> '4',
                    'null'=> FALSE
                ),
                'pay_date' => array(
                    'type'=> 'TIMESTAMP',
                    'default'=> 'CURRENT_TIMESTAMP',
                    'null'=> FALSE
                ),
                'inOrout' => array(
                    'type'=> 'ENUM',
                    'constraint'=> "'Atkeep','Shipped'",
                    'null'=> FALSE
                ),
                'price_on_pay' => array(
                    'type'=> 'INT',
                    'constraint'=> '20',
                    'null'=> FALSE
                ),
                'price_now' => array(
                    'type'=> 'INT',
                    'constraint'=> '20',
                    'null'=> FALSE
                ),
                'ship_date' => array(
                    'type'=> 'TIMESTAMP',
                    'default'=> 'CURRENT_TIMESTAMP',
                    'null'=> FALSE,
                    'attributes'=> 'on update CURRENT_TIMESTAMP'
                ),
                'stock_piller' => array(
                    'type'=> 'JSON',
                    'uniquel'=> TRUE,
                    'null'=> FALSE
                )
            
            );
        }

        $this->load->dbforge();

        $this->dbforge->add_field('id');
        $this->dbforge->add_field($fields);

        if ($this->dbforge->create_table($stockPiller,TRUE)){
            return TRUE;
        }
        else{
            return FALSE;
        }

    
    }

    private function houseKeeping($needed = 0,$crypt = array()){
        /** this function enccrypts and decrypts db id,i needed a name name for my stockpiller user table
         * so i thought why not write a function that encrypts d user id as a table name and make it also 
         * decrypt the encryted string bk to d db id
         * 
         * to encrypt pass the db id as a argument....this returns an associative array array('key'=>$key(string),
         * 'encrypted'=>$encrypted(string))
         * to decrypt pass 0 as d first argument and d associtive array returned on encryption👆 as a d second argument like this 👉 houseKeeping(0,$array)...this returns its decrypted $id(int)
         */

        //  encryption happens here
        if((gettype($needed) == 'integer') && $needed != 0){
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

            $this->db->select($array['field']);
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
    

	public function index($logged = 0)
	{
        
        echo ('PHP version: ' . phpversion());

		$this->load->view('cart_views/home');
	}

    // public $lol = 0;

    public function register(){
    
        // $arrayCode = array(
        //     '+234',
        //     '+254',
        //     '+233',
        //     '+228',
        //     '+27'
        // );
        // $arrayGender = array(
        //     'female',
        //     'male',
        //     'others'
        // );
        // $arrayEmail = array(
        //     'customers',
        //     'email'
        // );
        // $arrayPhone = array(
        //     'customers',
        //     'phone'
        // );
        // $arrayUsername = array(
        //     'customers',
        //     'username'
        // );

        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');

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
        // $this->form_validation->set_rules('country_code','Country code','',array());

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
        // $this->form_validation->set_rules('gender','Gender','',array(  
        // ));
        
        if( $this->form_validation->run() == FALSE ){
            
            $this->load->view('cart_views/sign_up_page');
        }
        else
        {
            // $array = array(
            //     'encrypted'=> 'none';
            //     'key' => 'not a stockpiller';
            // );
            // $jsonStockPiller = json_encode($array);
            // $data = array(
            //     'fname'=> $_POST['fname'],
            //     'lname'=> $_POST['lname'],
            //     'country_code'=> $_POST['zip'],
            //     'phone'=> $_POST['pNum'],
            //     'email'=> $_POST['email'],
            //     'password'=> $_POST['password'],
            //     'dob'=> $_POST['dob'],
            //     'username'=> $_POST['uName'],
            //     'gender'=> $_POST['gender'],
            //     'stockpiller'=> $jsonStockpiller
            // );
            $this->load->view('cart_views/formsuccess');
            
        }
    


        
    }
        
    public function shop ()
    {
        $query = $this->db->get('products');
        $data['product'] = $query->result_array();
    }
    // private function keying($fields,$filters) {
    //     $array = [];
    //     $i = 0;
    //     // echo is_array($fields)? 'true': 'false';
    //     if (is_array($filters)){
    //         foreach ($filters as $key => $val )
    //         {
            
    //             if ($fields[$i] == $key)
    //             {
    //                 $array[$fields[$i]] = $filters[$fields[$i]];
    //             }
    //             $i++;
    //         }
    //     }
    //     else{
    //         return 'not good';
    //     }
    // }

    public function admin()
    {
        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name','Product name','required|max_length[15]|min_length[2]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
        ));

        $this->form_validation->set_rules('brand','Product brand','required|max_length[15]|min_length[2]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
        ));

        $this->form_validation->set_rules('price','Product price','required|max_length[15]|min_length[2]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
        ));

        $this->form_validation->set_rules('quantity','Quantity of product','required|max_length[15]|min_length[2]|integer',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
            'integer' => '{field} must be a number'
        ));

        $this->form_validation->set_rules('path','Image path','required|max_length[15]|min_length[2]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
        ));

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('cart_views/admin');
        }
        else
        {
            

            $in = [
               'name_string' => $_POST['name'],
               'brand_string' => $_POST['brand'],
               'price_string' => $_POST['price'],
               'quantitity_int' => $_POST['quantity'],
               'path_url' => $_POST['path']
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
            
            var_dump($this->sanitize($in,$filters,'_'));
            // $data['product'] = $this->sanitize($in,$fields,0,$filters);
            // $data['header'] = "review your info";

            
            
            $this->load->view('cart_views/review',$data);
        }
        
    }
}