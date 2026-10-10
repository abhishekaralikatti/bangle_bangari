<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Bangle_model', 'Category_model', 'Order_model', 'Admin_model']);
    }

    // ── Auth guard ───────────────────────────────────────────────
    private function require_login() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    // ── Login ────────────────────────────────────────────────────
    public function login() {
        if ($this->session->userdata('admin_logged_in')) redirect('admin/dashboard');

        if ($this->input->method() === 'post') {
            $email    = $this->input->post('email', TRUE);
            $password = $this->input->post('password');
            $admin    = $this->Admin_model->get_by_email($email);

            if ($admin && $this->Admin_model->verify_password($password, $admin['password'])) {
                $this->session->set_userdata([
                    'admin_logged_in' => TRUE,
                    'admin_id'   => $admin['id'],
                    'admin_name' => $admin['name'],
                    'admin_email'=> $admin['email'],
                ]);
                redirect('admin/dashboard');
            } else {
                $data['error'] = 'Invalid email or password.';
            }
        }

        $data['title'] = 'Admin Login';
        $this->load->view('admin/login', $data ?? []);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    // ── Dashboard ────────────────────────────────────────────────
    public function dashboard() {
        $this->require_login();
        $data['title']           = 'Dashboard';
        $data['total_products']  = $this->Bangle_model->count_total();
        $data['active_products'] = $this->Bangle_model->count_active_products();
        $data['low_stock']       = $this->Bangle_model->count_low_stock(5);
        $data['pending_orders']  = $this->Order_model->count_by_status('pending');
        $data['total_revenue']   = $this->Order_model->total_revenue();
        $data['recent_orders']   = $this->Order_model->recent(5);
        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/layout_footer');
    }

    // ── Bangles list ─────────────────────────────────────────────
    public function bangles() {
        $this->require_login();
        $data['title']   = 'Manage Bangles';
        $data['bangles'] = $this->Bangle_model->get_all_admin();
        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/bangles', $data);
        $this->load->view('admin/layout_footer');
    }

    // ── Add bangle ───────────────────────────────────────────────
    public function add_bangle() {
        $this->require_login();
        $data['title']      = 'Add New Bangle';
        $data['categories'] = $this->Category_model->get_all();
        $data['bangle']     = null;

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name',     'Name',     'required|trim');
            $this->form_validation->set_rules('price',    'Price',    'required|decimal');
            $this->form_validation->set_rules('stock',    'Stock',    'required|integer');

            if ($this->form_validation->run()) {
                $image_name = $this->_upload_image();

                $bangle_data = [
                    'category_id'   => (int) $this->input->post('category_id'),
                    'name'          => $this->input->post('name', TRUE),
                    'slug'          => $this->Bangle_model->make_slug($this->input->post('name', TRUE)),
                    'description'   => $this->input->post('description', TRUE),
                    'material'      => $this->input->post('material', TRUE),
                    'size'          => $this->input->post('size', TRUE),
                    'color'         => $this->input->post('color', TRUE),
                    'price'         => (float) $this->input->post('price'),
                    'compare_price' => $this->input->post('compare_price') ?: null,
                    'stock'         => (int) $this->input->post('stock'),
                    'is_featured'   => $this->input->post('is_featured') ? 1 : 0,
                    'is_active'     => $this->input->post('is_active') ? 1 : 0,
                    'image'         => $image_name,
                ];

                $this->Bangle_model->insert($bangle_data);
                // pr($this->db->last_query()); exit;
                $this->session->set_flashdata('success', 'Bangle added successfully!');
                redirect('admin/bangles');
            }
        }

        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/bangle_form', $data);
        $this->load->view('admin/layout_footer');
    }

    // ── Edit bangle ──────────────────────────────────────────────
    public function edit_bangle($id) {
        $this->require_login();
        $data['bangle']     = $this->Bangle_model->get_by_id($id);
        if (!$data['bangle']) show_404();
        $data['title']      = 'Edit Bangle';
        $data['categories'] = $this->Category_model->get_all();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name',  'Name',  'required|trim');
            $this->form_validation->set_rules('price', 'Price', 'required|decimal');
            $this->form_validation->set_rules('stock', 'Stock', 'required|integer');

            if ($this->form_validation->run()) {
                $image_name = $this->_upload_image();
                if (!$image_name) $image_name = $data['bangle']['image']; // keep old

                $update = [
                    'category_id'   => (int) $this->input->post('category_id'),
                    'name'          => $this->input->post('name', TRUE),
                    'description'   => $this->input->post('description', TRUE),
                    'material'      => $this->input->post('material', TRUE),
                    'size'          => $this->input->post('size', TRUE),
                    'color'         => $this->input->post('color', TRUE),
                    'price'         => (float) $this->input->post('price'),
                    'compare_price' => $this->input->post('compare_price') ?: null,
                    'stock'         => (int) $this->input->post('stock'),
                    'is_featured'   => $this->input->post('is_featured') ? 1 : 0,
                    'is_active'     => $this->input->post('is_active') ? 1 : 0,
                    'image'         => $image_name,
                ];
                $this->Bangle_model->update($id, $update);
                $this->session->set_flashdata('success', 'Bangle updated successfully!');
                redirect('admin/bangles');
            }
        }

        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/bangle_form', $data);
        $this->load->view('admin/layout_footer');
    }

    // ── Delete bangle ────────────────────────────────────────────
    public function delete_bangle($id) {
        $this->require_login();
        $bangle = $this->Bangle_model->get_by_id($id);
        if ($bangle && $bangle['image']) {
            @unlink(FCPATH . 'assets/uploads/bangles/' . $bangle['image']);
        }
        $this->Bangle_model->delete($id);
        $this->session->set_flashdata('success', 'Bangle deleted.');
        redirect('admin/bangles');
    }

    // ── Orders ───────────────────────────────────────────────────
    public function orders() {
        $this->require_login();
        $data['title']  = 'Orders';
        $data['orders'] = $this->Order_model->get_all();
        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/orders', $data);
        $this->load->view('admin/layout_footer');
    }

    public function order_detail($id) {
        $this->require_login();
        $data['order'] = $this->Order_model->get_by_id($id);
        if (!$data['order']) show_404();
        $data['items']  = $this->Order_model->get_items($id);
        $data['title']  = 'Order #' . $data['order']['order_number'];
        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/order_detail', $data);
        $this->load->view('admin/layout_footer');
    }

    public function update_order_status($id) {
        $this->require_login();
        $status = $this->input->post('status', TRUE);
        $allowed = ['pending','confirmed','shipped','delivered','cancelled'];
        if (in_array($status, $allowed)) {
            $this->Order_model->update_status($id, $status);
            $this->session->set_flashdata('success', 'Order status updated.');
        }
        redirect('admin/orders/' . $id);
    }

    // ── Toggle helpers ──────────────────────────────────────────
    public function toggle_featured($id) {
        $this->require_login();
        $this->Bangle_model->toggle_featured($id);
        redirect('admin/bangles');
    }

    public function toggle_active($id) {
        $this->require_login();
        $this->Bangle_model->toggle_active($id);
        redirect('admin/bangles');
    }

    // ── Categories ───────────────────────────────────────────────
    public function categories() {
        $this->require_login();
        $data['categories'] = $this->Category_model->get_all();
        $data['title']      = 'Categories';

        if ($this->input->method() === 'post') {
            $name = $this->input->post('name', TRUE);
            if ($name) {
                $this->Category_model->insert([
                    'name'        => $name,
                    'slug'        => $this->Category_model->make_slug($name),
                    'description' => $this->input->post('description', TRUE),
                ]);
                $this->session->set_flashdata('success', 'Category added.');
                redirect('admin/categories');
            }
        }

        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/categories', $data);
        $this->load->view('admin/layout_footer');
    }

    public function delete_category($id) {
        $this->require_login();
        $this->Category_model->delete($id);
        $this->session->set_flashdata('success', 'Category deleted.');
        redirect('admin/categories');
    }

    // ── Image upload helper ──────────────────────────────────────
    private function _upload_image() {
        if (empty($_FILES['image']['name'])) return null;

        $upload_path = FCPATH . 'assets/uploads/bangles/';
        if (!is_dir($upload_path)) mkdir($upload_path, 0755, TRUE);

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'max_size'      => 2048,
            'file_name'     => 'bangle_' . time(),
            'overwrite'     => FALSE,
        ];
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            return $this->upload->data('file_name');
        }
        $this->session->set_flashdata('upload_error', $this->upload->display_errors('', ''));
        return null;
    }
}
