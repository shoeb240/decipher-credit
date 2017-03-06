<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Premailer
{

    private $endpoint = 'http://premailer.dialect.ca/api/0.1/documents';

    private function convert($html = '', $url = '', $fetchresult = true, $adaptor = 'hpricot', $base_url = '', $line_length = 65, $link_query_string = '', $preserve_styles = true, $remove_ids = false, $remove_classes = false, $remove_comments = false) {
        $params = array();
        if (!empty($html)) {
            $params['html'] = $html;
        } elseif (!empty($url)) {
            $params['url'] = $url;
        } else {
            throw new Exception('Must supply an html or url value');
        }
        if ($adaptor == 'hpricot' or $adaptor == 'nokigiri') {
            $params['adaptor'] = $adaptor;
        }
        if (!empty($base_url)) {
            $params['base_url'] = $base_url;
        }
        $params['line_length'] = (integer)$line_length;
        if (!empty($link_query_string)) {
            $params['link_query_string'] = $link_query_string;
        }
        $params['preserve_styles'] = ($preserve_styles?'true':'false');
        $params['remove_ids'] = ($remove_ids?'true':'false');
        $params['$remove_classes'] = ($remove_classes?'true':'false');
        $params['$remove_comments'] = ($remove_comments?'true':'false');

        $conf = array(
            'url'	=> $this->endpoint,
            'timeout' => 15,
            'useragent' => 'PHP Premailer',
            'ssl_verifyhost'	=> 0,
            'SSL_VERIFYPEER'	=> 0,
            'post'		=> 1,
            'postfields' => $params,
            'returntransfer' => true,
            'httpheader' => array("Expect:")
        );

        foreach($conf as $key => $value){
            $name = constant('CURLOPT_'.strtoupper($key));
            $val  = $value;
            $data_conf[$name] = $val;
        }
        $cu = curl_init();
        curl_setopt_array($cu, $data_conf);
        $exec = curl_exec($cu);
        $_res			= json_decode($exec);
        $_res_info 	= json_decode(json_encode(curl_getinfo($cu)));
        curl_close($cu);
        if($_res_info->http_code != 201){
            $code = $_res_info->http_code;
            switch ($code) {
                case 400:
                    throw new Exception('Content missing', 400);
                    break;
                case 403:
                    throw new Exception('Access forbidden', 403);
                    break;
                case 500:
                default:
                    throw new Exception('Error', $code);
            }

        }
        $return = array('result' => $_res);
        if ($fetchresult) {
            $html = curl_init();
            curl_setopt_array(
                $html, array(
                    CURLOPT_URL 			=> $_res->documents->html,
                    CURLOPT_TIMEOUT 		=> 15,
                    CURLOPT_USERAGENT 		=> 'PHP Premailer',
                    CURLOPT_SSL_VERIFYHOST	=> 0,
                    CURLOPT_SSL_VERIFYPEER	=> 0,
                    CURLOPT_HTTPHEADER 		=> array("Expect:"),
                    CURLOPT_RETURNTRANSFER 	=> true
                )
            );
            $return['html'] = curl_exec($html);
            curl_close($html);

            $plain = curl_init();
            curl_setopt_array(
                $plain, array(
                    CURLOPT_URL 			=> $_res->documents->txt,
                    CURLOPT_TIMEOUT 		=> 15,
                    CURLOPT_USERAGENT 		=> 'PHP Premailer',
                    CURLOPT_SSL_VERIFYHOST	=> 0,
                    CURLOPT_SSL_VERIFYPEER	=> 0,
                    CURLOPT_HTTPHEADER 		=> array("Expect:"),
                    CURLOPT_RETURNTRANSFER 	=> true
                )
            );
            $return['plain'] = curl_exec($plain);
            curl_close($plain);

            return $return;
        }

        return false;
    }

    public function html($html, $fetchresult = true, $adaptor = 'hpricot', $base_url = '', $line_length = 65, $link_query_string = '', $preserve_styles = true, $remove_ids = false, $remove_classes = false, $remove_comments = false) {
        return $this->convert($html, '', $fetchresult, $adaptor, $base_url, $line_length, $link_query_string, $preserve_styles, $remove_ids, $remove_classes, $remove_comments);
    }

    public function url($url, $fetchresult = true, $adaptor = 'hpricot', $base_url = '', $line_length = 65, $link_query_string = '', $preserve_styles = true, $remove_ids = false, $remove_classes = false, $remove_comments = false) {
        return $this->convert('', $url, $fetchresult, $adaptor, $base_url, $line_length, $link_query_string, $preserve_styles, $remove_ids, $remove_classes, $remove_comments);
    }
}
