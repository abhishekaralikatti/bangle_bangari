<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_require_login();
        $this->load->model(['User_model', 'Horoscope_model']);
    }

    private function _require_login() {
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    private function _get_user() {
        return $this->User_model->get_by_id($this->session->userdata('user_id'));
    }

    // ── Dashboard Home ─────────────────────────────────────────────────
    public function index() {
        $user      = $this->_get_user();
        $horoscope = $this->Horoscope_model->get_todays_horoscope($user->id, $user->zodiac_sign);
        // pr($this->db->last_query());exit;
        $data = [
            'user'      => $user,
            'horoscope' => $horoscope,
            'page'      => 'dashboard'
        ];
        $this->load->view('dashboard/index', $data);
    }

    // ── History Page ───────────────────────────────────────────────────
    public function history() {
        $user   = $this->_get_user();
        $page   = (int)($this->input->get('page') ?? 1);
        $limit  = 7;
        $offset = ($page - 1) * $limit;

        $history     = $this->Horoscope_model->get_history($user->id, $limit, $offset);
        $total       = $this->Horoscope_model->count_history($user->id);
        $total_pages = ceil($total / $limit);

        $data = [
            'user'        => $user,
            'history'     => $history,
            'current_page'=> $page,
            'total_pages' => $total_pages,
            'page'        => 'history'
        ];
        $this->load->view('dashboard/history', $data);
    }

    // ── Profile Update ─────────────────────────────────────────────────
    public function profile() {
        $user = $this->_get_user();

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'required');

            if ($this->form_validation->run()) {
                $update = [
                    'full_name' => $this->input->post('full_name', TRUE),
                    'dob'       => $this->input->post('dob'),
                    'gender'    => $this->input->post('gender'),
                ];
                $this->User_model->update_profile($user->id, $update);

                // Refresh session
                $updated = $this->User_model->get_by_id($user->id);
                $this->session->set_userdata([
                    'full_name'   => $updated->full_name,
                    'zodiac_sign' => $updated->zodiac_sign,
                ]);

                $this->session->set_flashdata('success', 'Profile updated successfully!');
                redirect('dashboard/profile');
            }
        }

        $this->load->view('dashboard/profile', ['user' => $user, 'page' => 'profile']);
    }

    // ── Toggle email subscription ──────────────────────────────────────
    public function unsubscribe() {
        $user = $this->_get_user();
        $new_status = $user->email_subscribed ? 0 : 1;
        $this->User_model->toggle_subscription($user->id, $new_status);
        $msg = $new_status ? 'You have subscribed to daily horoscope emails.' : 'You have unsubscribed from daily emails.';
        $this->session->set_flashdata('success', $msg);
        redirect('dashboard/profile');
    }
}
