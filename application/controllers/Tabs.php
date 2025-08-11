<?php
class Tabs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tab_model');
        $this->load->model('Slide_model');
    }

    public function index() {
        $data['tabs'] = $this->Tab_model->get_all_tabs();
        foreach ($data['tabs'] as $tab) {
            $tab->slides = $this->Slide_model->get_slides_by_tab($tab->id);
        }
        $this->load->view('frontend/tabs_slider', $data);
    }
}
