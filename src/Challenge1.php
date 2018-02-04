<?php
/**
 * Created by PhpStorm.
 * User: marcinmisiorek
 * Date: 01.02.2018
 * Time: 19:08
 */

/**
 * @param $string string
 * @return string
 */
function shorten_sentence(string $string): string {
    $result = "";
    $remainingLetters = "";
    for($i = 0; $i < strlen($string); $i++) {
        if(ord($string[$i]) >= ord('A') && ord($string[$i]) <= ord('Z')) {
            $result .= $string[$i];
        } else {
            $remainingLetters .= $string[$i];
        }
    }

    if(strlen($result) < 3) {
        $result .= strtoupper(substr($remainingLetters, 0, 3-strlen($result)));
    } else if(strlen($result) > 0) {
        $result = substr($result, 0, 3);
    }

    return $result;
}

