<?php

class CSC_API_model extends CI_Model
{

    private function getXml($method, array $params = [])
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
        <soap12:Body>
        <' . $method . ' xmlns="http://eservices.diligenz.com/">';

        if ($params) {
            $xml .= '<params>';

            foreach ($params as $name => $value) {
                if (is_array($value)) {
                    $xml .= '<param name="' . $name . '"><array>';

                    foreach ($value as $itemKey => $itemValue) {
                        $xml .= '<item><key>' . $itemKey . '</key><value>' . $itemValue . '</value></item>';
                    }

                    $xml .= '</array></param>';
                } else {
                    $xml .= '<param name="' . $name . '">' . $value .'</param>';
                }
            }

            $xml .= '</params>';
        }

        return $xml . '</' . $method . '></soap12:Body></soap12:Envelope>';
    }

    private function request($xml)
    {
        $headers = [
            //"Content-Type: text/xml; charset=utf-8",
            "Content-Type: application/soap+xml; charset=utf-8",
            "Content-length: " . strlen($xml)
        ];

        $session = curl_init();
        curl_setopt($session, CURLOPT_URL, 'http://eservices-test.diligenz.com/eservices.asmx');
        curl_setopt($session, CURLOPT_POST, 1);
        curl_setopt($session, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($session);
        curl_close($session);

        return $result;
    }

    public function search(array $credentials, array $data)
    {
        if (!$credentials || !$data) {
            return false;
        }

        $xml = $this->getXml(
            'SubmitOnlineSearch',
            [
                'loginGuid' => $credentials['password'],
                'contactNo' => $credentials['identity'],
                'showAllResults' => 'true',
                'type' => 'UCC',
                'stateCD' => $data['state'],
                'companyName' => $data['company'],
                'references' => [
                    'Billing Reference' => 'xxxx'
                ]
            ]
        );

        $result = $this->request($xml);

        if (!$result) {
            return false;
        }

        $orderId = 0;

        if (preg_match('/<orderID>(.+)<\/orderID>/is', $result, $matches)) {
            $orderId = $matches[1];
        }

        if (!$orderId) {
            return $result;
        }

        $xml = $this->getXml(
            'GetSummaryResults',
            [
                'loginGuid' => $credentials['password'],
                'contactNo' => $credentials['identity'],
                'orderID' => $orderId
            ]
        );

        $result = $this->request($xml);

        if (!$result) {
            return false;
        }

        return $result;
    }

}
