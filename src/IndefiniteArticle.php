<?php

namespace IndefiniteArticle;

class IndefiniteArticle
{
    const A = 'a';

    const AN = 'an';

    private static $rules = [
        // any number starting with an '8' uses 'an'
        ["/^[8](\d+)?/", self::AN],
        // ordinal forms
        ['/^([bcdgjkpqtuvwyz]-?th)/i', self::A],
        ['/^([aefhilmnorsx]-?th)/i', self::AN],
        // special cases
        ['/^(euler|hour(?!i)|heir|honest|hono)/i', self::AN],
        ['/^[aefhilmnorsx]$/i', self::AN],
        ['/^[bcdgjkpqtuvwyz]$/i', self::A],
        // abbreviations
        [
            '/^((?! FJO | [HLMNS]Y.  | RY[EO] | SQU | ( F[LR]? | [HL] | MN? | N | RH? | S[CHKLMNPTVW]? | X(YL)?) [AEIOU]) [FHLMNRSX][A-Z])/x',
            self::AN
        ],
        ['/^[aefhilmnorsx][.-]/i', self::AN],
        ['/^[a-z][.-]/i', self::A],
        // consonants
        ['/^[^aeiouy]/i', self::A],
        // special vowel forms
        ['/^e[uw]/i', self::A],
        ["/^onc?e\b/i", self::A],
        ['/^uni([^nmd]|mo)/i', self::A],
        ['/^ut[th]/i', self::AN],
        ['/^u[bcfhjkqrst][aeiou]/i', self::A],
        // special capitals
        ['/^U[NK][AIEO]?/', self::A],
        // vowels
        ['/^[aeiou]/i', self::AN],
        // before certain consonants, y implies an "i" sound
        ['/^(y(b[lor]|cl[ea]|fere|gg|p[ios]|rou|tt))/i', self::AN],
    ];

    /**
     * Determine appropriate indefinite article
     *
     * @param  string $input A word or phrase
     *
     * @return string Original word or phrase prefixed with 'a' or 'an'
     */
    public static function invoke(string $input): string
    {
        $matches = array();

        \preg_match("/\A(\s*)(?:an?\s+)?(.+?)(\s*)\Z/i", $input, $matches);

        list(, $pre, $word, $post) = $matches;

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
                return self::AN . ' ' . $word;
            }
        }

        foreach (self::$rules as $rule) {
            list($pattern, $article) = $rule;
            if (\preg_match($pattern, $word)) {
                return $article . ' ' . $word;
            }
        }

        // not sure, so guess 'a'
        return self::A . ' ' . $word;
    }
}
