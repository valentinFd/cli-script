<?php

namespace App;

class App
{
    private const PUNCTUATIONS = ['.', ',', '?', ';', '!', ':', '\'', '(', ')', '[', ']', '"', '-', '_', '/', '@', '{', '}', '*'];

    private const LETTERS = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    private bool $nonRepeating = false;

    private bool $leastRepeating = false;

    private bool $mostRepeating = false;

    private bool $letter = false;

    private bool $punctuation = false;

    private bool $symbol = false;

    private array $argv;

    private array $charCount;

    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    private function parseCommandLine(): int
    {
        if (!(isset($this->argv[1], $this->argv[2]) && ($this->argv[1] === '-i' || $this->argv[1] === '--input') &&
            file_exists($this->argv[2])))
        {
            return 1;
        }

        if (count($lines = file($this->argv[2])) !== 1)
        {
            return 2;
        }

        foreach (str_split($lines[0]) as $char)
        {
            if (!(mb_check_encoding($char, 'ASCII') && (ctype_lower($char) || ctype_punct($char) || ctype_digit($char))))
            {
                return 2;
            }
        }

        if (isset($this->argv[3], $this->argv[4]) && ($this->argv[3] === '-f' || $this->argv[3] === '--format'))
        {
            switch ($this->argv[4])
            {
                case 'non-repeating':
                    $this->nonRepeating = true;
                    break;
                case 'least-repeating':
                    $this->leastRepeating = true;
                    break;
                case 'most-repeating':
                    $this->mostRepeating = true;
                    break;
                default:
                    return 3;
            }
        }
        else
        {
            return 3;
        }

        if (isset($this->argv[5]))
        {
            switch (true)
            {
                case $this->argv[5] === '-L' || $this->argv[5] === '--include-letter':
                    $this->letter = true;
                    break;
                case $this->argv[5] === '-P' || $this->argv[5] === '--include-punctuation':
                    $this->punctuation = true;
                    break;
                case $this->argv[5] === '-S' || $this->argv[5] === '--include-symbol':
                    $this->symbol = true;
                    break;
                default:
                    return 4;
            }
        }
        else
        {
            return 4;
        }

        if (isset($this->argv[6]))
        {
            switch (true)
            {
                case $this->argv[6] === '-L' || $this->argv[6] === '--include-letter':
                    $this->letter = true;
                    break;
                case $this->argv[6] === '-P' || $this->argv[6] === '--include-punctuation':
                    $this->punctuation = true;
                    break;
                case $this->argv[6] === '-S' || $this->argv[6] === '--include-symbol':
                    $this->symbol = true;
                    break;
            }
        }

        if (isset($this->argv[7]))
        {
            switch (true)
            {
                case $this->argv[7] === '-L' || $this->argv[7] === '--include-letter':
                    $this->letter = true;
                    break;
                case $this->argv[7] === '-P' || $this->argv[7] === '--include-punctuation':
                    $this->punctuation = true;
                    break;
                case $this->argv[7] === '-S' || $this->argv[7] === '--include-symbol':
                    $this->symbol = true;
                    break;
            }
        }

        $this->charCount = $this->countChars($lines[0]);
        return 0;
    }

    private function nonRepeating(): array
    {
        $result = [];

        if ($this->letter)
        {
            $result['letter'] = 'none';
            foreach ($this->charCount as $char => $count)
            {
                if ($count === 1 && in_array($char, self::LETTERS))
                {
                    $result['letter'] = $char;
                    break;
                }
            }
        }

        if ($this->punctuation)
        {
            $result['punctuation'] = 'none';
            foreach ($this->charCount as $char => $count)
            {
                if ($count === 1 && in_array($char, self::PUNCTUATIONS))
                {
                    $result['punctuation'] = $char;
                    break;
                }
            }
        }

        if ($this->symbol)
        {
            $result['symbol'] = 'none';
            foreach ($this->charCount as $char => $count)
            {
                if ($count === 1 && !in_array($char, self::PUNCTUATIONS) && !in_array($char, self::LETTERS))
                {
                    $result['symbol'] = $char;
                    break;
                }
            }
        }
        return $result;
    }

    private function leastRepeating(): array
    {
        $result = [];
        $minCount = 999999;
        $minChar = 'none';

        if ($this->letter)
        {
            foreach ($this->charCount as $char => $count)
            {
                if ($count < $minCount && in_array($char, self::LETTERS))
                {
                    $minCount = $count;
                    $minChar = $char;
                }
            }
            $result['letter'] = $minChar;
        }

        $minCount = 999999;
        $minChar = 'none';

        if ($this->punctuation)
        {
            foreach ($this->charCount as $char => $count)
            {
                if ($count < $minCount && in_array($char, self::PUNCTUATIONS))
                {
                    $minCount = $count;
                    $minChar = $char;
                }
            }
            $result['punctuation'] = $minChar;
        }

        $minCount = 999999;
        $minChar = 'none';

        if ($this->symbol)
        {
            foreach ($this->charCount as $char => $count)
            {
                if ($count < $minCount && !in_array($char, self::PUNCTUATIONS) && !in_array($char, self::LETTERS))
                {
                    $minCount = $count;
                    $minChar = $char;
                }
            }
            $result['symbol'] = $minChar;
        }
        return $result;
    }

    private function mostRepeating(): array
    {
        $result = [];
        $maxCount = 0;
        $maxChar = 'none';

        if ($this->letter)
        {
            foreach ($this->charCount as $char => $count)
            {
                if ($count > $maxCount && in_array($char, self::LETTERS))
                {
                    $maxCount = $count;
                    $maxChar = $char;
                }
            }
            $result['letter'] = $maxChar;
        }

        $maxCount = 0;
        $maxChar = 'none';

        if ($this->punctuation)
        {
            foreach ($this->charCount as $char => $count)
            {
                if ($count > $maxCount && in_array($char, self::PUNCTUATIONS))
                {
                    $maxCount = $count;
                    $maxChar = $char;
                }
            }
            $result['punctuation'] = $maxChar;
        }

        $maxCount = 0;
        $maxChar = 'none';

        if ($this->symbol)
        {
            foreach ($this->charCount as $char => $count)
            {
                if ($count > $maxCount && !in_array($char, self::PUNCTUATIONS) && !in_array($char, self::LETTERS))
                {
                    $maxCount = $count;
                    $maxChar = $char;
                }
            }
            $result['symbol'] = $maxChar;
        }
        return $result;
    }

    private function countChars(string $line): array
    {
        $result = [];
        foreach (str_split($line) as $char)
        {
            if (!isset($result[$char])) $result[$char] = 1;
            else $result[$char]++;
        }
        return $result;
    }

    public function start(): array|int
    {
        $code = $this->parseCommandLine();
        if ($code > 0) return $code;
        $result['file'] = $this->argv[2];
        $result['format'] = $this->argv[4];
        return match (true)
        {
            $this->nonRepeating => array_merge($result, $this->nonRepeating()),
            $this->leastRepeating => array_merge($result, $this->leastRepeating()),
            $this->mostRepeating => array_merge($result, $this->mostRepeating()),
        };
    }
}
