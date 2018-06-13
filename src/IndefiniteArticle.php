<?php

namespace IndefiniteArticle;

class IndefiniteArticle
{
    private static $rules = [
        // any number starting with an '8' uses 'an'
        ["/^[8](\d+)?/", 0],
        // ordinal forms
        ['/^([bcdgjkpqtuvwyz]-?th)/i', 1],
        ['/^([aefhilmnorsx]-?th)/i', 0],
        // special cases
        ['/^(euler|hour(?!i)|heir|honest|hono)/i', 0],
        ['/^[aefhilmnorsx]$/i', 0],
        ['/^[bcdgjkpqtuvwyz]$/i', 1],
        // abbreviations
        [
            '/^((?! FJO | [HLMNS]Y.  | RY[EO] | SQU | ( F[LR]? | [HL] | MN? | N | RH? | S[CHKLMNPTVW]? | X(YL)?) [AEIOU]) [FHLMNRSX][A-Z])/x',
            0
        ],
        ['/^[aefhilmnorsx][.-]/i', 0],
        ['/^[a-z][.-]/i', 1],
        // consonants
        ['/^[^aeiouy]/i', 1],
        // special vowel forms
        ['/^e[uw]/i', 1],
        ["/^onc?e\b/i", 1],
        ['/^uni([^nmd]|mo)/i', 1],
        ['/^ut[th]/i', 0],
        ['/^u[bcfhjkqrst][aeiou]/i', 1],
        // special capitals
        ['/^U[NK][AIEO]?/', 1],
        // vowels
        ['/^[aeiou]/i', 0],
        // before certain consonants, y implies an "i" sound
        ['/^(y(b[lor]|cl[ea]|fere|gg|p[ios]|rou|tt))/i', 0],
    ];

    /**
     * Alias of the A() static method
     *
     * @param string $input
     *
     * @return string
     */
    public static function An(string $input): string
    {
        return self::A($input);
    }

    /**
     * Determine appropriate indefinite article
     *
     * @param  string $input A word or phrase
     *
     * @return string        Original word or phrase prefixed with 'a' or 'an'
     */
    public static function A(string $input): string
    {
        $matches = array();

        \preg_match("/\A(\s*)(?:an?\s+)?(.+?)(\s*)\Z/i", $input, $matches);

        [, $pre, $word, $post] = $matches;

        if (\null === $word) {
            return $input;
        }

        $result = self::_indefinite_article($word);

        return $pre . $result . $post;
    }

    /**
     * Determine appropriate indefinite article for a given word
     *
     * @param  string $word A word
     *
     * @return string       Original word prefixed with 'a' or 'an'
     */
    private static function _indefinite_article($word): string
    {
        // numbers starting with a '1' are trickier, only use 'an' if there are
        // 3, 6, 9, … digits after the 11 or 18
        if (\preg_match("/^[1][1](\d+)?/", $word) || \preg_match("/^[1][8](\d+)?/", $word)) {
            if (\strlen(\preg_replace(array("/\s/", '/,/', "/\.(\d+)?/"), '', $word)) % 3 === 2) {
                return 'an' . ' ' . $word;
            }
        }

        foreach (self::$rules as $rule) {
            [$pattern, $article] = $rule;
            if (\preg_match($pattern, $word)) {
                return ($article ? 'a' : 'an') . ' ' . $word;
            }
        }

        // not sure, so guess 'a'
        return 'a' . ' ' . $word;
    }
}
