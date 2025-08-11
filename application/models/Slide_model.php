<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slide_model extends CI_Model {

    public function get_by_tab($tab_id) {
        return $this->db->order_by('sort_order','ASC')->get_where('slides', ['tab_id' => $tab_id])->result();
    }

    public function get($id) {
        return $this->db->get_where('slides', ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->insert('slides', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->where('id',$id)->update('slides',$data);
    }

    public function delete($id) {
        return $this->db->where('id',$id)->delete('slides');
    }

    public function get_all() {
        return $this->db->order_by('tab_id, sort_order')->get('slides')->result();
    }

    public function get_sortmaxid()
    {
        $this->db->select_max('sort_order');
        $query = $this->db->get('slides');
        return $query->row()->sort_order;
    }

}
?>