<?php declare(strict_types=1);

namespace BudApi\Translator;

class DroidSpeakToEnglishTranslator
{
    /**
     * @param string $input
     * @return array
     */
    public function translate(string $input)
    {
        $inputArray  = explode(' ', $input);
        $translation = '';

        foreach ($inputArray as $piece) {
            $translation .= chr(bindec($piece));
        }

        return $translation;
    }
}
