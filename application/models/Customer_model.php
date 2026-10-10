<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    // ── Lookup ───────────────────────────────────────────────────

    public function get_by_email($email) {
        return $this->db->where('email', $email)->get('customers')->row_array();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('customers')->row_array();
    }

    public function get_by_google_id($google_id) {
        return $this->db->where('google_id', $google_id)->get('customers')->row_array();
    }

    public function get_by_verify_token($token) {
        return $this->db->where('verify_token', $token)->get('customers')->row_array();
    }

    // ── Create / Update ──────────────────────────────────────────

    public function register($data) {
        $data['password']     = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['verify_token'] = bin2hex(random_bytes(16));
        $data['is_verified']  = 1; // set to 0 + send email if you want email verification
        $this->db->insert('customers', $data);
        return $this->db->insert_id();
    }

    public function create_google_customer($data) {
        // Google users are auto-verified, no password needed
        $data['is_verified'] = 1;
        $this->db->insert('customers', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update('customers', $data);
    }

    public function verify_email($token) {
        $customer = $this->get_by_verify_token($token);
        if ($customer) {
            $this->db->where('id', $customer['id'])
                     ->update('customers', ['is_verified' => 1, 'verify_token' => null]);
            return true;
        }
        return false;
    }

    // ── Auth ─────────────────────────────────────────────────────

    public function verify_password($plain, $hash) {
        return password_verify($plain, $hash);
    }

    public function email_exists($email) {
        return $this->db->where('email', $email)->count_all_results('customers') > 0;
    }
}
