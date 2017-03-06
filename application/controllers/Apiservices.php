<?php

class Apiservices extends Base {

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }
    }

    private function parseRates($data)
    {
        if (!$data) {
            return [];
        }

        $result = [];

        foreach ($data as $row) {
            $result[$row->provider_id] = [
                'decipher' => $row->decipher_rate,
                'customer' => $row->customer_rate
            ];
        }

        return $result;
    }

    private function parseUsageCount($data)
    {
        if (!$data) {
            return [];
        }

        $result = [];

        foreach ($data as $row) {
            $result[$row->provider_id] = $row->usage_count;
        }

        return $result;
    }

    public function view()
    {
        $this->load->model('apiservices_model');
        $this->load->model('customer_model');

        $today = date('Y-m-d');
        $pastWeak = date('Y-m-d', strtotime('-7 day'));
        $pastMonth = date('Y-m-d', strtotime('-30 day'));

        $customerId = $this->customer_model->get_customerid_fromuserid($this->ion_auth->get_user_id());

        $today = date('Y-m-d');
        $pastWeak = date('Y-m-d', strtotime('-7 day'));
        $pastMonth = date('Y-m-d', strtotime('-30 day'));

        $this->load->view(
            'apiservices/view',
            [
                'services' => $this->apiservices_model->getList(),
                'rates' => $this->parseRates(
                    $this->apiservices_model->getRates($customerId)
                ),
                'usage' => [
                    'weak' => $this->parseUsageCount(
                        $this->apiservices_model->getUsageCount($pastWeak, $today)
                    ),
                    'month' => $this->parseUsageCount(
                        $this->apiservices_model->getUsageCount($pastMonth, $today)
                    )
                ]
            ]
        );
    }

    public function usage($id)
    {
        if (empty($id)) {
            redirect('apiservices/view');
        }

        $this->load->model('apiservices_model');

        $this->load->helper('object_helper');

        $this->load->view(
            'apiservices/usage',
            [
                'usages' => $this->apiservices_model->getUsageById($id)
            ]
        );
    }

}
