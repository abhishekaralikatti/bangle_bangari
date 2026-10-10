<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bangle_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // ── Public shop queries ──────────────────────────────────────

    public function get_featured($limit = 8) {
        return $this->db->select('b.*, c.name as category_name')
            ->from('bangles b')
            ->join('categories c', 'c.id = b.category_id', 'left')
            ->where('b.is_active', 1)
            ->where('b.is_featured', 1)
            ->limit($limit)
            ->get()->result_array();
    }

    public function get_all_active($category_slug = null, $limit = 20, $offset = 0) {
        $this->db->select('b.*, c.name as category_name, c.slug as category_slug')
            ->from('bangles b')
            ->join('categories c', 'c.id = b.category_id', 'left')
            ->where('b.is_active', 1);
        if ($category_slug) {
            $this->db->where('c.slug', $category_slug);
        }
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    public function count_active($category_slug = null) {
        $this->db->from('bangles b')
            ->join('categories c', 'c.id = b.category_id', 'left')
            ->where('b.is_active', 1);
        if ($category_slug) {
            $this->db->where('c.slug', $category_slug);
        }
        return $this->db->count_all_results();
    }

    public function get_by_slug($slug) {
        return $this->db->select('b.*, c.name as category_name, c.slug as category_slug')
            ->from('bangles b')
            ->join('categories c', 'c.id = b.category_id', 'left')
            ->where('b.slug', $slug)
            ->where('b.is_active', 1)
            ->get()->row_array();
    }

    public function get_by_id($id) {
        return $this->db->select('b.*, c.name as category_name')
            ->from('bangles b')
            ->join('categories c', 'c.id = b.category_id', 'left')
            ->where('b.id', $id)
            ->get()->row_array();
    }

    public function search($term) {
        return $this->db->select('b.*, c.name as category_name')
            ->from('bangles b')
            ->join('categories c', 'c.id = b.category_id', 'left')
            ->where('b.is_active', 1)
            ->group_start()
                ->like('b.name', $term)
                ->or_like('b.description', $term)
                ->or_like('b.color', $term)
                ->or_like('b.material', $term)
            ->group_end()
            ->get()->result_array();
    }

    // ── Admin CRUD ───────────────────────────────────────────────

    public function get_all_admin() {
        return $this->db->select('b.*, c.name as category_name')
            ->from('bangles b')
            ->join('categories c', 'c.id = b.category_id', 'left')
            ->order_by('b.id', 'DESC')
            ->get()->result_array();
    }

    public function insert($data) {
        $this->db->insert('bangles', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update('bangles', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('bangles');
        return $this->db->affected_rows();
    }

    public function make_slug($name) {
        $slug = url_title(strtolower($name), '-', TRUE);
        $count = $this->db->where('slug', $slug)->count_all_results('bangles');
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }
        return $slug;
    }

    public function toggle_featured($id) {
        $bangle = $this->get_by_id($id);
        $new    = $bangle['is_featured'] ? 0 : 1;
        $this->db->where('id', $id)->update('bangles', ['is_featured' => $new]);
    }

    public function toggle_active($id) {
        $bangle = $this->get_by_id($id);
        $new    = $bangle['is_active'] ? 0 : 1;
        $this->db->where('id', $id)->update('bangles', ['is_active' => $new]);
    }

    public function count_total()  { return $this->db->count_all('bangles'); }
    public function count_active_products() { return $this->db->where('is_active', 1)->count_all_results('bangles'); }
    public function count_low_stock($threshold = 5) {
        return $this->db->where('stock <=', $threshold)->where('is_active', 1)->count_all_results('bangles');
    }
}
