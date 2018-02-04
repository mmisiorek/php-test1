<?php
/**
 * Created by PhpStorm.
 * User: marcinmisiorek
 * Date: 01.02.2018
 * Time: 21:02
 */

require __DIR__.'/../src/Challenge4.php';

use PHPUnit\Framework\TestCase;

class Challenge4Test extends TestCase
{
    /**
     * @dataProvider getMatchesForRegexProvider
     * @param string $regex
     * @param string $string
     * @param string[] $values
     */
    public function testGetMatchesForRegex(string $regex, string $string, array $values)
    {
        $this->assertEquals(get_matches_for_regex($regex, $string), $values);
    }

    /**
     * @dataProvider parseSearchQueryProvider
     * @param string[] $availableParams
     * @param string $query
     * @param string[] $expectedResult
     * @param bool $shouldThrowParamNotFoundException
     * @param bool $shouldThrowGrammarException
     */
    public function testParseSearchQuery(array $availableParams, string $query, array $expectedResult,
                                            bool $shouldThrowParamNotFoundException, bool $shouldThrowGrammarException)
    {
        if($shouldThrowParamNotFoundException) {
            $this->expectException(ParamNotFoundException::class);
        }

        if($shouldThrowGrammarException) {
            $this->expectException(GrammarException::class);
        }

        $this->assertEquals(parse_search_query($availableParams, $query), $expectedResult);
    }

    /**
     * @return array
     */
    public function getMatchesForRegexProvider(): array
    {
        return [
            ['/[a-zA-Z0-9]+/', 'abc ', ['abc']],
            ['/[a-zA-Z0-9]+/', 'abc wqe', ['abc', 'wqe']]
        ];
    }

    /**
     * @return array
     */
    public function parseSearchQueryProvider(): array
    {
        return [
            [['param'], 'param:val', ['param' => 'val'], false, false],
            [['param', 'param31'], 'param31:val param:val', ['param31' => 'val', 'param' => 'val'], false, false],
            [['param', 'param31'], 'param31:"val" param:"val val"', ['param31' => 'val', 'param' => 'val val'], false, false],
            [['term', 'term2', 'term3', 'term4'], 'term:value term2:"value2" term3:"value value" term4:"value : value : value"',
                            ['term' => 'value', 'term2' => 'value2', 'term3' => 'value value', 'term4' => 'value : value : value'], false, false],

            [['term', 'term3', 'term4'], 'term:value term2:"value2" term3:"value value" term4:"value : value : value"',
                ['term' => 'value', 'term2' => 'value2', 'term3' => 'value value', 'term4' => 'value : value : value'], true, false],

            [['term', 'term2', 'term3', 'term4'], 'term:value term2:"value2" term3:"value value term4:"value : value : value"',
                ['term' => 'value', 'term2' => 'value2', 'term3' => 'value value', 'term4' => 'value : value : value'], false, true],


            [['term', 'term2', 'term3', 'term4'], 'term:value term2:"value2" term3:"value value" term4:value : value : value"',
                ['term' => 'value', 'term2' => 'value2', 'term3' => 'value value', 'term4' => 'value : value : value'], false, true],


            [['term', 'term2', 'term3', 'term4'], 'term:value term2:"value2" term3:"value value" term4:"value : value : value',
                ['term' => 'value', 'term2' => 'value2', 'term3' => 'value value', 'term4' => 'value : value : value'], false, true],

        ];
    }

}