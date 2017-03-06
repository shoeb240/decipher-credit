<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Calculation_model extends CI_Model {

    public function __construct(){
        //$this->load->database();
    }
        
    public function jaro_winkler($str1, $str2)
    {
        $str_len1 = strlen($str1);
        $str_len2 = strlen($str2);
        
        if ($str_len1 <= 2 || $str_len2 <= 2) {
            return false;
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
        
        return $dw;
    }
    
    private function calculate_dj($m, $str_len1, $str_len2, $t)
    {
        if ($m == 0) {
            return 0;
        }
        return ((($m / $str_len1) + ($m / $str_len2) + (($m - $t) / $m)) / 3);
    }
	
}

