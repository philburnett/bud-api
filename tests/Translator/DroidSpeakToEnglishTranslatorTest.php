<?php declare(strict_types=1);

namespace UnitTest\BudApi\Translator;

use BudApi\Translator\DroidSpeakToEnglishTranslator;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class DroidSpeakToEnglishTranslatorTest extends MockeryTestCase
{
    public function testTranslate()
    {
        $translator = new DroidSpeakToEnglishTranslator();

        foreach ($this->getTests() as $expected => $input) {

            $this->assertEquals($expected, $translator->translate($input));
        }
    }

    public function getTests()
    {
        return [
            'Cell 2187'              => '01000011 01100101 01101100 01101100 00100000 00110010 00110001 00111000 00110111',
            'Detention Block AA-23,' => '01000100 01100101 01110100 01100101 01101110 01110100 01101001 01101111 ' .
                '01101110 00100000 01000010 01101100 01101111 01100011 01101011 00100000 01000001 01000001 ' .
                '00101101 00110010 00110011 00101100',
        ];
    }
}
