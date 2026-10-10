<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function get_by_email($email) {
        return $this->db->where('email', $email)->get('admin_users')->row_array();
    }

    public function verify_password($plain, $hash) {
        return password_verify($plain, $hash);
    }
}
