<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Bangle_model', 'Category_model', 'Order_model']);
    }

    // ── Home page ────────────────────────────────────────────────
    public function index() {
        $data['title']      = 'Bangles – Beautiful Bangles for Every Occasion';
        $data['featured']   = $this->Bangle_model->get_featured(8);
        $data['categories'] = $this->Category_model->get_all();
        $data['all_bangles']= $this->Bangle_model->get_all_active(null, 12);
        $this->load->view('layouts/header', $data);
        $this->load->view('shop/home', $data);
        $this->load->view('layouts/footer', $data);
    }

    // ── Category page ────────────────────────────────────────────
    public function category($slug) {
        $data['category']   = $this->Category_model->get_by_slug($slug);
        if (!$data['category']) show_404();
        $data['title']      = $data['category']['name'] . ' – Bangle Store';
        $data['bangles']    = $this->Bangle_model->get_all_active($slug);
        $data['categories'] = $this->Category_model->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('shop/category', $data);
        $this->load->view('layouts/footer', $data);
    }

    // ── Product detail ───────────────────────────────────────────
    public function product($slug) {
        $data['bangle']     = $this->Bangle_model->get_by_slug($slug);
        if (!$data['bangle']) show_404();
        $data['title']      = $data['bangle']['name'] . ' – Bangle Store';
        $data['categories'] = $this->Category_model->get_all();
        $data['related']    = $this->Bangle_model->get_all_active($data['bangle']['category_slug'] ?? null, 4);
        $this->load->view('layouts/header', $data);
        $this->load->view('shop/product', $data);
        $this->load->view('layouts/footer', $data);
    }

    // ── Cart ─────────────────────────────────────────────────────
    public function cart() {
        $data['title']      = 'Your Cart – Bangle Store';
        $data['cart']       = $this->session->userdata('cart') ?? [];
        $data['categories'] = $this->Category_model->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('shop/cart', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function add_to_cart() {
        $bangle_id  = (int) $this->input->post('bangle_id');
        $quantity   = max(1, (int) $this->input->post('quantity'));
        $bangle     = $this->Bangle_model->get_by_id($bangle_id);

        if (!$bangle || !$bangle['is_active']) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect('shop/cart');
        }

        $cart = $this->session->userdata('cart') ?? [];
        if (isset($cart[$bangle_id])) {
            $cart[$bangle_id]['quantity'] += $quantity;
        } else {
            $cart[$bangle_id] = [
                'id'       => $bangle['id'],
                'name'     => $bangle['name'],
                'price'    => $bangle['price'],
                'image'    => $bangle['image'],
                'slug'     => $bangle['slug'],
                'quantity' => $quantity,
            ];
        }
        $this->session->set_userdata('cart', $cart);
        $this->session->set_flashdata('success', '"' . $bangle['name'] . '" added to cart!');
        redirect('shop/cart');
    }

    public function update_cart() {
        $cart = $this->session->userdata('cart') ?? [];
        foreach ($this->input->post('quantity') as $id => $qty) {
            $id  = (int) $id;
            $qty = (int) $qty;
            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                if (isset($cart[$id])) $cart[$id]['quantity'] = $qty;
            }
        }
        $this->session->set_userdata('cart', $cart);
        redirect('shop/cart');
    }

    public function remove_from_cart($id) {
        $cart = $this->session->userdata('cart') ?? [];
        unset($cart[(int)$id]);
        $this->session->set_userdata('cart', $cart);
        redirect('shop/cart');
    }

    // ── Checkout ─────────────────────────────────────────────────
    public function checkout() {
        $cart = $this->session->userdata('cart') ?? [];
        if (empty($cart)) { redirect('shop/cart'); }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name',    'Name',         'required|trim');
            $this->form_validation->set_rules('email',   'Email',        'required|valid_email|trim');
            $this->form_validation->set_rules('phone',   'Phone',        'required|trim');
            $this->form_validation->set_rules('address', 'Address',      'required|trim');
            $this->form_validation->set_rules('city',    'City',         'required|trim');
            $this->form_validation->set_rules('state',   'State',        'required|trim');
            $this->form_validation->set_rules('pincode', 'Pincode',      'required|trim');

            if ($this->form_validation->run()) {
                $total = 0;
                $items = [];
                foreach ($cart as $item) {
                    $bangle  = $this->Bangle_model->get_by_id($item['id']);
                    $total  += $bangle['price'] * $item['quantity'];
                    $items[] = [
                        'bangle_id'   => $bangle['id'],
                        'bangle_name' => $bangle['name'],
                        'price'       => $bangle['price'],
                        'quantity'    => $item['quantity'],
                    ];
                }

                $order_data = [
                    'customer_name'  => $this->input->post('name', TRUE),
                    'customer_email' => $this->input->post('email', TRUE),
                    'customer_phone' => $this->input->post('phone', TRUE),
                    'address'        => $this->input->post('address', TRUE),
                    'city'           => $this->input->post('city', TRUE),
                    'state'          => $this->input->post('state', TRUE),
                    'pincode'        => $this->input->post('pincode', TRUE),
                    'total_amount'   => $total,
                    'notes'          => $this->input->post('notes', TRUE),
                    'status'         => 'pending',
                ];

                $order_id = $this->Order_model->create($order_data, $items);
                $order    = $this->Order_model->get_by_id($order_id);
                $this->session->unset_userdata('cart');
                $this->session->set_userdata('last_order', $order);
                redirect('shop/order_success');
            }
        }

        $data['title']      = 'Checkout – Bangle Store';
        $data['cart']       = $cart;
        $data['categories'] = $this->Category_model->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('shop/checkout', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function order_success() {
        $order = $this->session->userdata('last_order');
        if (!$order) redirect('/');
        $data['title']  = 'Order Placed! – Bangle Store';
        $data['order']  = $order;
        $data['categories'] = $this->Category_model->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('shop/order_success', $data);
        $this->load->view('layouts/footer', $data);
    }
}
