<?php
/**
 * Created by PhpStorm.
 * User: marcinmisiorek
 * Date: 01.02.2018
 * Time: 20:05
 */

require __DIR__.'/../src/Challenge1.php';

use PHPUnit\Framework\TestCase;

class Challenge1Test extends TestCase
{
    /**
     * @dataProvider shortenSentenceProvider
     * @param string $sentence
     * @param string $short
     */
    public function testShortenSentence(string $sentence, string $short)
    {
        $this->assertEquals(shorten_sentence($sentence), $short);
    }

    /**
     * @return array
     */
    public function shortenSentenceProvider(): array
    {
        return [
            ['Test Me Please', 'TMP'],
            ['TEst me please', 'TES'],
            ['Tst Me please', 'TMS'],
            ['tEst Me please', 'EMT'],
            ['test Me please', 'MTE'],
            ['test me please', 'TES'],
            ['test me pleasE', 'ETE']
        ];
    }

}