<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<?php
class My_Time extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->set_timezone();
    }

    public function set_timezone() {
        if ($this->session->userdata('user_id')) {
            $this->db->select('timezone');
            $this->db->from($this->db->dbprefix . 'user');
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                date_default_timezone_set($query->row()->timezone);
            } else {
                return false;
            }
        }
    }

    $timezones =  DateTimeZone::listIdentifiers(DateTimeZone::ALL);

    foreach ($timezones as $timezone) 
    {
       echo $timezone;
       echo "</br>";
    }

}
