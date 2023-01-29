<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        // if only a single input is passed instead of array then a filter is required not an array of filters and it returns the sanitized data.
            
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

    public function index($logged = 0)
	{
        
        // echo ('PHP version: ' . phpversion());

		$this->load->view('cart_views/home');
	}
    
    public function admins()
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
        $this->form_validation->set_rules('image','Image path','required|max_length[15]|min_length[2]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
        ));
        $this->form_validation->set_rules('summary','description','required|max_length[250]|min_length[3]',array(
            'required' => '{field} is required',
            'max_length' => '{field} can not be more than {param} characters.',
            'min_length' => '{field} must be atleast {param} characters',
        ));
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('cart_views/adminpage');
        }
        else
        {
            if(isset($_POST['name'])){
            }
            $in = [
               'name_string' => $_POST['name'],
               'brand_string' => $_POST['brand'],
               'price_string' => $_POST['price'],
               'quantity_string' => $_POST['quantity'],
               'image_url' => $_POST['image'],
               'summary_string' => $_POST['summary']
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
            // var_dump($this->sanitize($in,$filters,'_'));
            $data['product'] = $this->sanitize($in,$filters,'_');
            echo $data['product']['summary'];
            
            $data['header'] = "PRODUCT INFORMATION";
            $query = $this->db->insert('products',$data['product']);
            if($query){
                $this->load->view('cart_views/review',$data);
            }
            else{
                echo "Something went wrong";
            }
           
        }
        
    }
}
