<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tab_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id','ASC')->get('tabs')->result();
    }

    public function get($id) {
        return $this->db->get_where('tabs', ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->insert('tabs', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->where('id',$id)->update('tabs',$data);
    }

    public function delete($id) {
        return $this->db->where('id',$id)->delete('tabs');
    }
}
?>