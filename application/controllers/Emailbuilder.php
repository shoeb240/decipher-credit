<?php

class Emailbuilder extends Base {

    public function __construct()
    {
        parent::__construct(false);

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }

        $this->load->library('ebuilder');
    }

    public function index($editor = null, $template = null)
    {
        if ($editor) {
            if ($template) {
                $path = APPPATH . 'views/emailbuilder/' . $template;

                if (file_exists($path)) {
                    $this->load->view('emailbuilder/' . basename($template, '.php'));
                } else {

                }
            } else {
                $this->load->view('emailbuilder/editor');
            }
        } else {
            $this->load->view('emailbuilder/index');
        }
    }

    public function image()
    {
        $this->ebuilder->image();
    }

    public function email()
    {
        $this->ebuilder->email();
    }

    public function upload()
    {
        $this->ebuilder->upload();
    }

}
