<?php

class Apiservices_model extends CI_Model {

    public function __construct()
    {
        $this->load->database('');
    }

    public function getList()
    {
        return $this->db
            ->select('id, provider, service, testform')
            ->from('apiservices')
            ->get()
            ->result();
    }

    public function getRates($customerId)
    {
        return $this->db
            ->select('apiid as provider_id, decipherRate as decipher_rate, customerRate as customer_rate')
            ->from('apirates')
            ->where('custno', (int) $customerId)
            ->where('effectiveDt <= CURDATE()')
            ->where('expirationDt > CURDATE()')
            ->order_by('effectiveDt', 'DESC')
            ->order_by('expirationDt', 'ASC')
            ->get()
            ->result();
    }

    public function getUsageCount($start, $end)
    {
        if (!$start || !$end) {
            return false;
        }

        return $this->db
            ->select('apikey as provider_id, COUNT(*) as usage_count')
            ->from('apiusage')
            ->where('DATE(accessedon) >=', $start)
            ->where('DATE(accessedon) <=', $end)
            ->group_by('apikey')
            ->get()
            ->result();
    }

    public function getUsageById($id)
    {
        return $this->db
            ->select('accessedon, accessedBy, query')
            ->from('apiusage')
            ->where('apikey', $id)
            ->order_by('accessedon', 'DESC')
            ->get()
            ->result();
    }

}
