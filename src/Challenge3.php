<?php
/**
 * Created by PhpStorm.
 * User: marcinmisiorek
 * Date: 01.02.2018
 * Time: 19:20
 */

/**
 * Create a signature of a string. It is made by set of unique characters from string
 * ordered in the alphabetical order.
 *
 * @param string $word
 * @return string
 */
function create_signature(string $word): string {
    $wordArr = str_split($word);
    $wordArrOrds = array_unique(array_map(function($char) {
        return ord(strtolower($char));

    }, $wordArr));

    sort($wordArrOrds);

    return implode('', array_map(function($ord) {

        // check if spacebar and if yes replace it with empty string
        if($ord !== ord(' ')) {
            return chr($ord);

        } else {
            return '';
        }

    }, $wordArrOrds));
}

/**
 * The function returns a string which does not match to others from array of strings.
 *
 * @param string[] $array
 * @return null|string
 */
function find_uniq(array $array) {
    $signatures = array_map("create_signature", $array);

    $ranking = array_count_values($signatures);

    // here can be a check if there are only two values in ranking and throw an exception if there are more

    $highestRankingVal = max(array_values($ranking));
    $commonSignature = array_flip($ranking)[$highestRankingVal];

    for($i = 0; $i < count($array); $i++) {
        if($signatures[$i] !== $commonSignature) {
            return $array[$i];
        }
    }

    return null;
}