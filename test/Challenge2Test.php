<?php
/**
 * Created by PhpStorm.
 * User: marcinmisiorek
 * Date: 01.02.2018
 * Time: 20:22
 */

require __DIR__.'/../src/Challenge2.php';

use PHPUnit\Framework\TestCase;

class Challenge2Test extends TestCase
{

    /**
     * @dataProvider sortStringsProvider
     * @param string $string
     * @param string $sorted
     */
    public function testSortStrings(string $string, string $sorted)
    {
        $this->assertEquals(sort_strings($string), $sorted);
    }

    /**
     * @return array
     */
    public function sortStringsProvider(): array
    {
        return [
            ['is2 Thi1s T7est 4a', 'Thi1s is2 4a T7est'],
            ['bea7utiful 4a 3had dog9 W1e', 'W1e 3had 4a bea7utiful dog9'],
            ['t7oo is4 This1 sentence3 lo9ng defini6tely', 'This1 sentence3 is4 defini6tely t7oo lo9ng']
        ];
    }

}