<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tab_model');
        $this->load->model('Slide_model');
    }

    public function index() {
        $tabs = $this->Tab_model->get_all();
        foreach ($tabs as $t) {
            $t->slides = $this->Slide_model->get_by_tab($t->id);
        }
        $data['tabs'] = $tabs;
        $this->load->view('home_view', $data);
    }
}
?>