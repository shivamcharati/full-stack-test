<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public $upload_path = './assets/upload/';
    public function __construct() {
        parent::__construct();
        $this->load->model('Tab_model');
        $this->load->model('Slide_model');
        $this->load->helper('url','form');
        $this->load->library('upload');
    }

    /* ---------- TABS ---------- */

    public function tabs_list() {
        $data['tabs'] = $this->Tab_model->get_all();
        $this->load->view('admin/tabs_list', $data);
    }

    public function tab_form($id = null) {
        $data['tab'] = null;
        if ($id) $data['tab'] = $this->Tab_model->get($id);
        $this->load->view('admin/tabs_form', $data);
    }

    public function save_tab() {
        $id = $this->input->post('id');
        $save = [
            'tab_key' => $this->input->post('tab_key', true),
            'title'   => $this->input->post('title', true)
        ];

        // handle icon upload
        if (!empty($_FILES['icon']['name'])) {
            $config = [
                'upload_path' => $this->upload_path,
                'allowed_types' => 'jpg|jpeg|png|gif|svg|webp',
                'max_size' => 4096,
                'encrypt_name' => TRUE
            ];
            $this->upload->initialize($config);
            if ($this->upload->do_upload('icon')) {
                $u = $this->upload->data();
                $save['icon'] = $u['file_name'];
                if ($id) {
                    $old = $this->Tab_model->get($id);
                    if ($old && !empty($old->icon) && file_exists($this->upload_path.$old->icon)) {
                        @unlink($this->upload_path.$old->icon);
                    }
                }
            } 
        }

        if ($id) {
            $this->Tab_model->update($id, $save);
        } else {
            $this->Tab_model->insert($save);
        }
        redirect('admin/tabs_list');
    }

    public function delete_tab($id) {
        $tab = $this->Tab_model->get($id);
        if ($tab && !empty($tab->icon) && file_exists($this->upload_path.$tab->icon)) {
            @unlink($this->upload_path.$tab->icon);
        }

        $slides = $this->Slide_model->get_by_tab($id);
        foreach ($slides as $s) {
            if (!empty($s->image) && file_exists($this->upload_path.$s->image)) {
                @unlink($this->upload_path.$s->image);
            }
        }

        $this->Tab_model->delete($id);
        redirect('admin/tabs_list');
    }

    /* ---------- Slide Code Start ---------- */

    public function slides_list($tab_id) {
        $data['slides'] = $this->Slide_model->get_by_tab($tab_id);
        $data['tab'] = $this->Tab_model->get($tab_id);
        $this->load->view('admin/slides_list', $data);
    }

    public function slide_form($tab_id, $id = null) {
        $data['slide'] = null;
        $data['tab_id'] = $tab_id;
        $data['sortid'] = $this->Slide_model->get_sortmaxid();
        if ($id) $data['slide'] = $this->Slide_model->get($id);
        $this->load->view('admin/slides_form', $data);
    }

    public function save_slide() {
        $id = $this->input->post('id');
        $tab_id = $this->input->post('tab_id');
        $save = [
            'tab_id' => $tab_id,
            'tag'    => $this->input->post('tag', true),
            'title'  => $this->input->post('title', true),
            'sort_order' => (int)$this->input->post('sort_order', true)
        ];

        // handle image upload
        if (!empty($_FILES['image']['name'])) {
            $config = [
                'upload_path' => $this->upload_path,
                'allowed_types' => 'jpg|jpeg|png|svg',
                'max_size' => 8192,
                'encrypt_name' => TRUE
            ];
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $u = $this->upload->data();
                $save['image'] = $u['file_name'];

                // delete old image if editing
                if ($id) {
                    $old = $this->Slide_model->get($id);
                    if ($old && !empty($old->image) && file_exists($this->upload_path.$old->image)) {
                        @unlink($this->upload_path.$old->image);
                    }
                }
            }
        }

        if ($id) {
            $this->Slide_model->update($id, $save);
        } else {
            $this->Slide_model->insert($save);
        }
        redirect('admin/slides_list/'.$tab_id);
    }

    public function delete_slide($tab_id, $id) {
        $slide = $this->Slide_model->get($id);
        if ($slide && !empty($slide->image) && file_exists($this->upload_path.$slide->image)) {
            @unlink($this->upload_path.$slide->image);
        }
        $this->Slide_model->delete($id);
        redirect('admin/slides_list/'.$tab_id);
    }
}
