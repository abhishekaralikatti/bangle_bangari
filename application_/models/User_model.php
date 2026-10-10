<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // ── Register new user ──────────────────────────────────────────────
    public function register($data) {
        $data['password']     = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['verify_token'] = bin2hex(random_bytes(32));
        $data['zodiac_sign']  = $this->get_zodiac($data['dob']);
        $this->db->insert('users', $data);
        $id = $this->db->insert_id();
        return $id ? $this->get_by_id($id) : FALSE;
    }

    // ── Get user by email ──────────────────────────────────────────────
    public function get_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    // ── Get user by ID ─────────────────────────────────────────────────
    public function get_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    // ── Get user by token ──────────────────────────────────────────────
    public function get_by_token($token) {
        return $this->db->get_where('users', ['verify_token' => $token])->row();
    }

    // ── Verify email ───────────────────────────────────────────────────
    public function verify_email($token) {
        $this->db->where('verify_token', $token);
        $this->db->update('users', [
            'is_verified'  => 1,
            'verify_token' => NULL
        ]);
        return $this->db->affected_rows() > 0;
    }

    // ── Validate login ─────────────────────────────────────────────────
    public function validate_login($email, $password) {
        $user = $this->get_by_email($email);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return FALSE;
    }

    // ── Set reset token ────────────────────────────────────────────────
    public function set_reset_token($email) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->db->where('email', $email);
        $this->db->update('users', [
            'reset_token'   => $token,
            'reset_expires' => $expires
        ]);
        return $token;
    }

    // ── Get by reset token ─────────────────────────────────────────────
    public function get_by_reset_token($token) {
        $this->db->where('reset_token', $token);
        $this->db->where('reset_expires >=', date('Y-m-d H:i:s'));
        return $this->db->get('users')->row();
    }

    // ── Update password ────────────────────────────────────────────────
    public function update_password($id, $password) {
        $this->db->where('id', $id);
        $this->db->update('users', [
            'password'    => password_hash($password, PASSWORD_BCRYPT),
            'reset_token' => NULL,
            'reset_expires' => NULL
        ]);
        return $this->db->affected_rows() > 0;
    }

    // ── Update profile ─────────────────────────────────────────────────
    public function update_profile($id, $data) {
        if (isset($data['dob'])) {
            $data['zodiac_sign'] = $this->get_zodiac($data['dob']);
        }
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows() > 0;
    }

    // ── Toggle email subscription ──────────────────────────────────────
    public function toggle_subscription($id, $status) {
        $this->db->where('id', $id);
        $this->db->update('users', ['email_subscribed' => $status]);
    }

    // ── Get all subscribed verified users ──────────────────────────────
    public function get_subscribed_users() {
        $this->db->where('is_verified', 1);
        $this->db->where('email_subscribed', 1);
        return $this->db->get('users')->result();
    }

    // ── Zodiac Sign Calculator ─────────────────────────────────────────
    public function get_zodiac($dob) {
        $month = (int) date('n', strtotime($dob));
        $day   = (int) date('j', strtotime($dob));

        $signs = [
            ['Capricorn',  1,  1,  1, 19],
            ['Aquarius',   1, 20,  2, 18],
            ['Pisces',     2, 19,  3, 20],
            ['Aries',      3, 21,  4, 19],
            ['Taurus',     4, 20,  5, 20],
            ['Gemini',     5, 21,  6, 20],
            ['Cancer',     6, 21,  7, 22],
            ['Leo',        7, 23,  8, 22],
            ['Virgo',      8, 23,  9, 22],
            ['Libra',      9, 23, 10, 22],
            ['Scorpio',   10, 23, 11, 21],
            ['Sagittarius',11, 22, 12, 21],
            ['Capricorn', 12, 22, 12, 31],
        ];

        foreach ($signs as $s) {
            if (($month == $s[1] && $day >= $s[2]) || ($month == $s[3] && $day <= $s[4])) {
                return $s[0];
            }
        }
        return 'Unknown';
    }
}
