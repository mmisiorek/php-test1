<?php
/**
 * Created by PhpStorm.
 * User: marcinmisiorek
 * Date: 01.02.2018
 * Time: 19:12
 */

/**
 * The function sorts words in a given string based on the numbers
 * located in the words.
 *
 * @param string $string
 * @return string
 */
function sort_strings($string) {
    $array = [];

    for($i = 1; $i <= 9; $i++) {
        $matches = [];
        $isMatched = preg_match('/[a-zA-Z]*'.$i.'[a-zA-Z]*/', $string, $matches);
        if($isMatched) {
            $array[] = $matches[0];
        }
    }

    return implode(' ', $array);
}