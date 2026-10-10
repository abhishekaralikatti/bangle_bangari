<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horoscope_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // ── Fetch from Aztro RapidAPI ──────────────────────────────────────
    public function fetch_from_api($sign) {
        // pr($sign); exit;
        $sign = strtolower($sign);
        $url  = "https://aztro.p.rapidapi.com/?sign={$sign}&day=today";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST           => TRUE,
            CURLOPT_HTTPHEADER     => [
                'X-RapidAPI-Key: '  . $this->config->item('rapidapi_key'),
                'X-RapidAPI-Host: ' . $this->config->item('rapidapi_host'),
                'Content-Length: 0'
            ],
            CURLOPT_TIMEOUT        => 15,
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200 && $response) {
            return json_decode($response, TRUE);
        }
        return FALSE;
    }

    // ── Get today's horoscope for a user (with DB cache) ──────────────
    public function get_todays_horoscope($user_id, $zodiac_sign) {
        $today = date('Y-m-d');

        // Check cache first
        $cached = $this->db->get_where('horoscope_history', [
            'user_id'        => $user_id,
            'horoscope_date' => $today
        ])->row();

        if ($cached) return $cached;

        // Fetch fresh from API
        $data = $this->fetch_from_api($zodiac_sign);
        // pr($data); exit;
        if (!$data) return FALSE;

        $record = [
            'user_id'        => $user_id,
            'zodiac_sign'    => $zodiac_sign,
            'horoscope_date' => $today,
            'description'    => $data['description']    ?? '',
            'compatibility'  => $data['compatibility']  ?? '',
            'mood'           => $data['mood']           ?? '',
            'color'          => $data['color']          ?? '',
            'lucky_number'   => $data['lucky_number']   ?? '',
            'lucky_time'     => $data['lucky_time']     ?? '',
        ];

        $this->db->insert('horoscope_history', $record);
        return (object) $record;
    }

    // ── Get past history for a user ────────────────────────────────────
    public function get_history($user_id, $limit = 10, $offset = 0) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('horoscope_date', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('horoscope_history')->result();
    }

    // ── Count total history records ────────────────────────────────────
    public function count_history($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('horoscope_history');
    }

    // ── Mark horoscope email as sent ───────────────────────────────────
    public function mark_email_sent($user_id, $date) {
        $this->db->where('user_id', $user_id);
        $this->db->where('horoscope_date', $date);
        $this->db->update('horoscope_history', ['email_sent' => 1]);
    }

    // ── Log email ──────────────────────────────────────────────────────
    public function log_email($user_id, $email, $subject, $status) {
        $this->db->insert('email_logs', [
            'user_id' => $user_id,
            'email'   => $email,
            'subject' => $subject,
            'status'  => $status,
        ]);
    }
}
