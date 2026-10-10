<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Auth Controller
 * Handles customer register, login, logout, and Google OAuth.
 *
 * Google OAuth setup:
 *   1. Go to https://console.cloud.google.com
 *   2. Create OAuth 2.0 credentials (Web application)
 *   3. Add Authorized redirect URI:
 *      http://yourdomain.com/auth/google_callback
 *   4. Put your Client ID & Secret in application/config/google_oauth.php
 */

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
        // Load google config if it exists
        if (file_exists(APPPATH . 'config/google_oauth.php')) {
            $this->config->load('google_oauth');
        }
    }

    // ── Helper: is customer logged in? ──────────────────────────
    private function is_logged_in() {
        return (bool) $this->session->userdata('customer_id');
    }

    // ── Register ─────────────────────────────────────────────────
    public function register() {
        if ($this->is_logged_in()) redirect('/');

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name',     'Name',     'required|trim|min_length[2]');
            $this->form_validation->set_rules('email',    'Email',    'required|trim|valid_email');
            $this->form_validation->set_rules('phone',    'Phone',    'trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email', TRUE);

                if ($this->Customer_model->email_exists($email)) {
                    $data['error'] = 'An account with this email already exists. Please login.';
                } else {
                    $id = $this->Customer_model->register([
                        'name'  => $this->input->post('name', TRUE),
                        'email' => $email,
                        'phone' => $this->input->post('phone', TRUE),
                        'password' => $this->input->post('password'),
                    ]);
                    $this->_set_customer_session($this->Customer_model->get_by_id($id));
                    $this->session->set_flashdata('success', 'Welcome! Your account has been created.');
                    // Redirect back to checkout if that's where they came from
                    $redirect = $this->session->userdata('redirect_after_login') ?? '/';
                    $this->session->unset_userdata('redirect_after_login');
                    redirect($redirect);
                }
            }
        }

        $data['title'] = 'Create Account';
        $data['google_client_id'] = $this->config->item('google_client_id') ?? null;
        $this->load->view('layouts/header', $data);
        $this->load->view('auth/register', $data ?? []);
        $this->load->view('layouts/footer');
    }

    // ── Login ────────────────────────────────────────────────────
    public function login() {
        if ($this->is_logged_in()) redirect('/');

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email',    'Email',    'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $email    = $this->input->post('email', TRUE);
                $password = $this->input->post('password');
                $customer = $this->Customer_model->get_by_email($email);

                if ($customer && !empty($customer['password']) && $this->Customer_model->verify_password($password, $customer['password'])) {
                    $this->_set_customer_session($customer);
                    $this->session->set_flashdata('success', 'Welcome back, ' . $customer['name'] . '!');
                    $redirect = $this->session->userdata('redirect_after_login') ?? '/';
                    $this->session->unset_userdata('redirect_after_login');
                    redirect($redirect);
                } else {
                    $data['error'] = 'Invalid email or password.';
                }
            }
        }

        $data['title'] = 'Login';
        $data['google_client_id'] = $this->config->item('google_client_id') ?? null;
        $this->load->view('layouts/header', $data);
        $this->load->view('auth/login', $data ?? []);
        $this->load->view('layouts/footer');
    }

    // ── Logout ───────────────────────────────────────────────────
    public function logout() {
        $this->session->unset_userdata(['customer_id', 'customer_name', 'customer_email', 'customer_avatar']);
        $this->session->set_flashdata('success', 'You have been logged out.');
        redirect('/');
    }

    // ── Google OAuth – Step 1: Redirect to Google ────────────────
    public function google() {
        $client_id    = $this->config->item('google_client_id');
        $redirect_uri = base_url('auth/google_callback');

        if (!$client_id) {
            $this->session->set_flashdata('error', 'Google login is not configured.');
            redirect('auth/login');
        }

        $params = http_build_query([
            'client_id'     => $client_id,
            'redirect_uri'  => $redirect_uri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
        ]);
        redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $params);
    }

    // ── Google OAuth – Step 2: Callback ─────────────────────────
    public function google_callback() {
        $code          = $this->input->get('code');
        $client_id     = $this->config->item('google_client_id');
        $client_secret = $this->config->item('google_client_secret');
        $redirect_uri  = base_url('auth/google_callback');

        if (!$code) {
            $this->session->set_flashdata('error', 'Google login failed. Please try again.');
            redirect('auth/login');
        }

        // Exchange code for token
        $token_response = $this->_http_post('https://oauth2.googleapis.com/token', [
            'code'          => $code,
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri'  => $redirect_uri,
            'grant_type'    => 'authorization_code',
        ]);

        if (empty($token_response['access_token'])) {
            $this->session->set_flashdata('error', 'Could not get access token from Google.');
            redirect('auth/login');
        }

        // Get user info from Google
        $user_info = $this->_http_get(
            'https://www.googleapis.com/oauth2/v3/userinfo',
            $token_response['access_token']
        );

        if (empty($user_info['email'])) {
            $this->session->set_flashdata('error', 'Could not retrieve your Google account info.');
            redirect('auth/login');
        }

        // Find or create customer
        $customer = $this->Customer_model->get_by_google_id($user_info['sub']);

        if (!$customer) {
            // Check if email already exists (registered manually before)
            $customer = $this->Customer_model->get_by_email($user_info['email']);
            if ($customer) {
                // Link Google ID to existing account
                $this->Customer_model->update($customer['id'], [
                    'google_id' => $user_info['sub'],
                    'avatar'    => $user_info['picture'] ?? null,
                ]);
                $customer = $this->Customer_model->get_by_id($customer['id']);
            } else {
                // Brand new Google user
                $id = $this->Customer_model->create_google_customer([
                    'name'      => $user_info['name'],
                    'email'     => $user_info['email'],
                    'google_id' => $user_info['sub'],
                    'avatar'    => $user_info['picture'] ?? null,
                ]);
                $customer = $this->Customer_model->get_by_id($id);
            }
        }

        $this->_set_customer_session($customer);
        $this->session->set_flashdata('success', 'Welcome, ' . $customer['name'] . '!');
        $redirect = $this->session->userdata('redirect_after_login') ?? '/';
        $this->session->unset_userdata('redirect_after_login');
        redirect($redirect);
    }

    // ── Private helpers ──────────────────────────────────────────

    private function _set_customer_session($customer) {
        $this->session->set_userdata([
            'customer_id'     => $customer['id'],
            'customer_name'   => $customer['name'],
            'customer_email'  => $customer['email'],
            'customer_avatar' => $customer['avatar'] ?? null,
        ]);
    }

    private function _http_post($url, $data) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true) ?? [];
    }

    private function _http_get($url, $access_token) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $access_token],
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true) ?? [];
    }
}
