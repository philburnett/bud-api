<?php declare(strict_types=1);

namespace BudApi\Translator;

class DroidSpeakToEnglishTranslator
{
    /**
     * @param string $input
     * @return string
     */
    public function translate(string $input): string
    {
        $inputArray  = explode(' ', $input);
        $translation = '';

        foreach ($inputArray as $piece) {
            $translation .= chr(bindec($piece));
        }

        return $translation;
    }
}
