<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Order_model', 'Customer_model', 'Category_model']);
        $this->_require_login();
    }

    // ── Auth guard ───────────────────────────────────────────────
    private function _require_login() {
        if (!$this->session->userdata('customer_id')) {
            $this->session->set_userdata('redirect_after_login', uri_string());
            $this->session->set_flashdata('error', 'Please login to view your account.');
            redirect('auth/login');
        }
    }

    private function _customer_id() {
        return (int) $this->session->userdata('customer_id');
    }

    // ── My Orders list ───────────────────────────────────────────
    public function orders() {
        $data['title']      = 'My Orders';
        $data['orders']     = $this->Order_model->get_by_customer($this->_customer_id());
        $data['customer']   = $this->Customer_model->get_by_id($this->_customer_id());
        $data['categories'] = $this->Category_model->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('shop/my_orders', $data);
        $this->load->view('layouts/footer');
    }

    // ── Order Detail ─────────────────────────────────────────────
    public function order_detail($id) {
        $order = $this->Order_model->get_by_id_and_customer($id, $this->_customer_id());

        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('account/orders');
        }

        $data['title']      = 'Order #' . $order['order_number'];
        $data['order']      = $order;
        $data['items']      = $this->Order_model->get_items($id);
        $data['customer']   = $this->Customer_model->get_by_id($this->_customer_id());
        $data['categories'] = $this->Category_model->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('shop/order_detail', $data);
        $this->load->view('layouts/footer');
    }
}
