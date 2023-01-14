<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Magic extends CI_Controller {

    public $fields = [
        'name' => 'string',
        'email' => 'email',
        'age' => 'int',
        'weight' => 'float',
        'github' => 'url',
        'hobbies' => 'string[]'
    ];

    const FILTERS = [
        'string' => FILTER_SANITIZE_STRING,
        'string[]' => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'email' => FILTER_SANITIZE_EMAIL,
        'int' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_SCALAR
        ],
        'int[]' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'float' => [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'float[]' => [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'url' => FILTER_SANITIZE_URL,
    ];

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

    

    private function sanitize(array $inputs, array $fields = [], int $default_filter = FILTER_SANITIZE_STRING, array $filters = FILTERS,$trim = TRUE): array
    {
        // this fucntion sanitizes ur $inputs (array) based on the rules specified by values in the associative array $fields
        // it trims the strings only the strings by default,if you dont want that set $trim to FALSE
        // it can also apply one particular filter to all ur inputs,set $default_filter to ur preffered filter to do that
        // it returns an array of sanitized and trim $inputs or just sanitized $inputs if $trim is set to FALSE

        function keying($field){
            $filters[$field];
        }

        if ($fields) {
            $options = array_map('keying', $fields);
            $data = filter_var_array($inputs, $options);
        }
        else
        {
            $data = filter_var_array($inputs, $default_filter);
        }
        
        return $trim ? array_trim($data) : $data;
        
    }
	
	public function index()
	{
		$this->load->view('welcome_message');
	}


}
