<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Calculate_ajax extends CI_Controller {
	
	
    public function __construct()
    {
            parent::__construct();		

            $this->load->model('ion_auth_model');
    }
	
    
    public function jaro_winkler()
    {
        $str1 = $this->input->get('str1');
        $str2 = $this->input->get('str2');
        
        $str_len1 = strlen($str1);
        $str_len2 = strlen($str2);
        
        if ($str_len1 <= 2 || $str_len2 <= 2) {
            echo json_encode(array('dw' => false));
        }

        $matching_factor = floor(max(array($str_len1, $str_len2))/2) -1;
        $m = 0;
        $transposition = 0;
        $p = 0.1;
        
        for($i = 0; $i < $str_len1; $i++)
        {
            if (isset($str1[$i]) && isset($str2[$i]) && ($str1[$i] === $str2[$i])) {
                $m++;
            } else if ($matching_factor > 0) {
                for($k = 1; $k <= $matching_factor; $k++)
                {
                    if (isset($str1[$i]) && isset($str2[$i+$k]) && ($str1[$i] === $str2[$i+$k])
                            && isset($str1[$i+$k]) && isset($str2[$i]) && ($str1[$i+$k] === $str2[$i])) {
                        $m++;
                        $transposition++;
                    } else if (isset($str1[$i]) && isset($str2[$i-$k]) && ($str1[$i] === $str2[$i-$k])
                            && isset($str1[$i-$k]) && isset($str2[$i]) && ($str1[$i-$k] === $str2[$i])) {
                        $m++;
                        $transposition++;
                    } else if (isset($str1[$i]) && isset($str2[$i+$k]) && ($str1[$i] === $str2[$i+$k])) {
                        $m++;
                    } else if (isset($str1[$i]) && isset($str2[$i-$k]) && ($str1[$i] === $str2[$i-$k])) {
                        $m++;
                    }
                }
            }
        }

        $t = floor($transposition / 2);
        
        $l = 0;
        $started = false;
        for($i = 0; $i < $str_len1; $i++)
        {
            if ($str1[$i] === $str2[$i]) {
                $l++;
                $started = true;
                if ($l >= 4) break;
            } else {
                if ($started) break;
            }
        }
        
        $dj = number_format($this->calculate_dj($m, $str_len1, $str_len2, $t), 3);

        $dw = number_format($dj + ($l * $p * (1 - $dj)), 3);
                
//        echo '$matching_factor:' . $matching_factor. '<br />';
//        echo '$transposition='. $transposition . '<br />';
//        echo 't:'.$t.'<br />';
//        echo '$m='.$m.'<br />';
//        echo '$str_len1='.$str_len1.'<br />';
//        echo '$str_len2='.$str_len2.'<br />';
//        echo '$dj=' . $dj . '<br />';
//        echo '$dw=' . $dw . '<br />';
        
        echo json_encode(array('score' => $dw));
    }
    
    private function calculate_dj($m, $str_len1, $str_len2, $t)
    {
        if ($m == 0) {
            return 0;
        }
        return ((($m / $str_len1) + ($m / $str_len2) + (($m - $t) / $m)) / 3);
    }

    
}
?>