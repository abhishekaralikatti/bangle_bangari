<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('name')->get('categories')->result_array();
    }

    public function get_by_slug($slug) {
        return $this->db->where('slug', $slug)->get('categories')->row_array();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('categories')->row_array();
    }

    public function insert($data) {
        $this->db->insert('categories', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update('categories', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('categories');
    }

    public function make_slug($name) {
        return url_title(strtolower($name), '-', TRUE);
    }
}
