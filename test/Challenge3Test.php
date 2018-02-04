<?php
/**
 * Created by PhpStorm.
 * User: marcinmisiorek
 * Date: 01.02.2018
 * Time: 20:32
 */

require __DIR__.'/../src/Challenge3.php';

use PHPUnit\Framework\TestCase;

class Challenge3Test extends TestCase
{
    /**
     * @dataProvider createSignatureProvider
     * @param string $word
     * @param string $signature
     */
    public function testCreateSignature(string $word, string $signature)
    {
        $this->assertEquals(create_signature($word), $signature);
    }

    /**
     * @dataProvider findUniqProvider
     * @param string[] $set
     * @param string $uniqueElement
     */
    public function testFindUniq(array $set, string $uniqueElement)
    {
        $this->assertEquals(find_uniq($set), $uniqueElement);
    }

    /**
     * @return array
     */
    public function createSignatureProvider(): array
    {
        return [
            ['AaaaAa', 'a'],
            ['foo', 'fo'],
            ['Bar', 'abr'],
            ['cAbcabc', 'abc'],
            ['Voldemort', 'delmortv'],
            ['     ', ''],
            ['  v  a ', 'av']
        ];
    }

    /**
     * @return array
     */
    public function findUniqProvider(): array
    {
        return [
            [[ 'Aa', 'aaa', 'aaaaa', 'BbBb', 'Aaaa', 'AaAaAa', 'a' ], 'BbBb'],
            [[ 'abc', 'acb', 'bac', 'foo', 'bca', 'cab', 'cba' ], 'foo'],
            [[ 'silvia', 'vasili', 'victor' ], 'victor'],
            [[ 'Tom Marvolo Riddle', 'I am Lord Voldemort', 'Harry Potter' ], 'Harry Potter'],
            [['     ', 'a', ' ',], 'a']
        ];
    }

}