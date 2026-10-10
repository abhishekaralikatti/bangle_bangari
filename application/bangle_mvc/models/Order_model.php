<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function create($order_data, $items) {
        $order_data['order_number'] = 'ORD-' . strtoupper(random_string('alnum', 8));
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

        foreach ($items as $item) {
            $item['order_id'] = $order_id;
            $this->db->insert('order_items', $item);
            // Decrement stock
            $this->db->where('id', $item['bangle_id'])
                     ->set('stock', 'stock - ' . (int)$item['quantity'], FALSE)
                     ->update('bangles');
        }
        return $order_id;
    }

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get('orders')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('orders')->row_array();
    }

    public function get_items($order_id) {
        return $this->db->where('order_id', $order_id)->get('order_items')->result_array();
    }

    public function update_status($id, $status) {
        $this->db->where('id', $id)->update('orders', ['status' => $status]);
    }

    public function count_by_status($status) {
        return $this->db->where('status', $status)->count_all_results('orders');
    }

    public function total_revenue() {
        $row = $this->db->select_sum('total_amount')->where_in('status', ['confirmed','shipped','delivered'])->get('orders')->row_array();
        return $row['total_amount'] ?? 0;
    }

    public function recent($limit = 5) {
        return $this->db->order_by('created_at','DESC')->limit($limit)->get('orders')->result_array();
    }
}
