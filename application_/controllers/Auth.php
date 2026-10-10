<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['email', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    // ── Redirect if already logged in ──────────────────────────────────
    private function redirect_if_logged_in() {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
    }

    // ── LOGIN ──────────────────────────────────────────────────────────
    public function index() {
        $this->login();
    }

    public function login() {
        $this->redirect_if_logged_in();

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $email    = $this->input->post('email', TRUE);
                $password = $this->input->post('password');
                $user     = $this->User_model->validate_login($email, $password);

                if ($user) {
                    // if (!$user->is_verified) {
                        // $this->session->set_flashdata('error', 'Please verify your email before logging in.');
                    // } else {
                        $this->session->set_userdata([
                            'user_id'     => $user->id,
                            'full_name'   => $user->full_name,
                            'email'       => $user->email,
                            'zodiac_sign' => $user->zodiac_sign,
                        ]);
                        redirect('dashboard');
                    // }
                } else {
                    $this->session->set_flashdata('error', 'Invalid email or password.');
                }
            }
        }
        $this->load->view('auth/login');
    }

    // ── REGISTER ───────────────────────────────────────────────────────
    public function register() {
        $this->redirect_if_logged_in();

        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
            $this->form_validation->set_rules('gender', 'Gender', 'required|in_list[male,female,other]');

            if ($this->form_validation->run()) {
                $data = [
                    'full_name' => $this->input->post('full_name', TRUE),
                    'email'     => $this->input->post('email', TRUE),
                    'password'  => $this->input->post('password'),
                    'dob'       => $this->input->post('dob'),
                    'gender'    => $this->input->post('gender'),
                ];

                $user = $this->User_model->register($data);

                if ($user) {
                    $this->_send_verification_email($user);
                    $this->session->set_flashdata('success', 'Registration successful! Please check your email to verify your account.');
                    redirect('login');
                } else {
                    $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                }
            }
        }
        $this->load->view('auth/register');
    }

    // ── EMAIL VERIFICATION ─────────────────────────────────────────────
    public function verify($token) {
        if ($this->User_model->verify_email($token)) {
            $this->session->set_flashdata('success', 'Email verified! You can now log in.');
        } else {
            $this->session->set_flashdata('error', 'Invalid or expired verification link.');
        }
        redirect('login');
    }

    // ── FORGOT PASSWORD ────────────────────────────────────────────────
    public function forgot_password() {
        $this->redirect_if_logged_in();

        if ($this->input->post()) {
            $email = $this->input->post('email', TRUE);
            $user  = $this->User_model->get_by_email($email);

            if ($user) {
                $token = $this->User_model->set_reset_token($email);
                $this->_send_reset_email($user, $token);
            }
            // Always show same message for security
            $this->session->set_flashdata('success', 'If this email exists, a reset link has been sent.');
            redirect('forgot-password');
        }
        $this->load->view('auth/forgot_password');
    }

    // ── RESET PASSWORD ─────────────────────────────────────────────────
    public function reset_password($token) {
        $user = $this->User_model->get_by_reset_token($token);
        if (!$user) {
            $this->session->set_flashdata('error', 'Invalid or expired reset link.');
            redirect('login');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run()) {
                $this->User_model->update_password($user->id, $this->input->post('password'));
                $this->session->set_flashdata('success', 'Password reset successful! Please log in.');
                redirect('login');
            }
        }
        $this->load->view('auth/reset_password', ['token' => $token]);
    }

    // ── LOGOUT ─────────────────────────────────────────────────────────
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    // ── Send verification email ────────────────────────────────────────
    private function _send_verification_email($user) {
        $verify_link = base_url('verify/' . $user->verify_token);
        $this->_configure_email();

        $this->email->to($user->email);
        $this->email->subject('Verify Your Horoscope Account');
        $message = $this->load->view('email_templates/verify_email', [
            'user'        => $user,
            'verify_link' => $verify_link
        ], TRUE);
        $this->email->message($message);
        $this->email->send();
    }

    // ── Send password reset email ──────────────────────────────────────
    private function _send_reset_email($user, $token) {
        $reset_link = base_url('reset-password/' . $token);
        $this->_configure_email();

        $this->email->to($user->email);
        $this->email->subject('Reset Your Horoscope Password');
        $message = $this->load->view('email_templates/reset_email', [
            'user'       => $user,
            'reset_link' => $reset_link
        ], TRUE);
        $this->email->message($message);
        $this->email->send();
    }

    // ── Configure email library ────────────────────────────────────────
    public function _configure_email() {
        $this->email->initialize([
            'protocol'   => 'smtp',
            'smtp_host'  => $this->config->item('smtp_host'),
            'smtp_user'  => $this->config->item('smtp_user'),
            'smtp_pass'  => $this->config->item('smtp_pass'),
            'smtp_port'  => $this->config->item('smtp_port'),
            'smtp_crypto'=> 'tls',
            'mailtype'   => 'html',
            'charset'    => 'UTF-8',
            'from_email' => $this->config->item('from_email'),
            'from_name'  => $this->config->item('from_name'),
        ]);
    }
}
