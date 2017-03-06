<?php

class Embed extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        $this->load->view('embed/test');
    }

    public function script()
    {
        $this->load->library('encrypt');

        $this->load->model('customertemplates_model');

        $hash = $this->input->get('hash');
        $templateId = $this->encrypt->decode(base64_decode($hash), $this->customertemplates_model->get_encryption_key());

        $customerTemplate = $this->customertemplates_model->get_customer_template_by_id($templateId);

        $this->load->view(
            'embed/script',
            [
                'hash' => $hash,
                'customer_id' => $customerTemplate ? $customerTemplate->custid : 0,
                'application_id' => $customerTemplate ? $customerTemplate->id : 0
            ]
        );
    }

    public function generate_code($template_id)
    {
        if (!$template_id) {
            show_error('Template ID required');
        } else {
            $this->load->model('customertemplates_model');

            echo '<textarea rows="5" cols="200" onclick="this.select();">' . $this->customertemplates_model->get_embed_code($template_id) . '</textarea>';
        }
    }

}
