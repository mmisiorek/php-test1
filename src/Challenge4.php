<?php
/**
 * Created by PhpStorm.
 * User: marcinmisiorek
 * Date: 01.02.2018
 * Time: 19:34
 */

class ParamNotFoundException extends \Exception
{
    /**
     * ParamNotFoundException constructor.
     * @param string $param
     */
    public function __construct($param) {
        parent::__construct("The param '$param' has not been found");
    }

}

class GrammarException extends \Exception
{
    /**
     * GrammarException constructor.
     * @param string[] $notValidExpressions
     */
    public function __construct(array $notValidExpressions)
    {
        $str = implode(' ', array_map(function ($expr) {
            return sprintf('%s, ', $expr);

        }, $notValidExpressions));

        $str = substr($str, 0, strlen($str) - 2);

        parent::__construct(sprintf("The following expressions are not gramatically correct: %s", $str));
    }

}

/**
 * Util function.
 *
 * @param string $pattern
 * @param string $string
 * @return string[]
 */
function get_matches_for_regex(string $pattern, string $string): array
{
    $matches = [];
    preg_match_all($pattern, $string, $matches);

    return $matches[0];
}

/**
 * The function parses the search query string and it returns as an array of
 * params and values from array of allowed parameters.
 *
 * @param array $paramList
 * @param string $query
 * @return array
 * @throws GrammarException
 * @throws ParamNotFoundException
 */
function parse_search_query(array $paramList, string $query): array
{
    // grammar definitions of correct gramatically elements
    $valueDef = "(('|\")[^\"']*('|\")|[a-zA-Z0-9]+)";
    $paramDef = "[a-zA-Z0-9]+";
    $expressionDef = "$paramDef:$valueDef";

    // loose grammar definitions for elements so we can detect incorrect data
    $valueLooseDef = "(('|\")[^\"']*('|\")|['\"]?[a-zA-Z0-9]+|[a-zA-Z0-9]+['\"]?)";
    $paramLooseDef = "[a-zA-Z0-9]+";
    $expressionLooseDef = "$paramLooseDef(\:$valueLooseDef)?";

    $expressions = get_matches_for_regex("/$expressionDef/", $query);

    $result = array();
    foreach($expressions as $expression) {
        $param = get_matches_for_regex("/^$paramDef/", $expression)[0];
        $value = get_matches_for_regex("/$valueDef$/", $expression)[0];

        if(!in_array($param, $paramList)) {
            throw new ParamNotFoundException($param);
        }

        $quotesArr = ['"', "'"];
        if(in_array($value[0], $quotesArr) && in_array($value[strlen($value)-1], $quotesArr)) {
            $value = substr($value, 1, strlen($value)-2);
        }

        $result[$param] = $value;
    }

    $potentialExpressions = get_matches_for_regex("/$expressionLooseDef/", $query);
    $notValidExpressions = array_diff($potentialExpressions, $expressions);

    if(count($notValidExpressions) > 0) {
        throw new GrammarException($notValidExpressions);
    }

    return $result;
}