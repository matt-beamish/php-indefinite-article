<?php

use IndefiniteArticle\IndefiniteArticle;

class IndefiniteArticleTest extends PHPUnit\Framework\TestCase
{
    private const AN = 'an';

    private const A = 'a';

    /**
     * Numbers
     */
    public function testNumbers(): void
    {
        $assertions = array(
            0 => self::A,
            1 => self::A,
            8 => self::AN,
            88 => self::AN,
            800 => self::AN,
            11 => self::AN,
            100 => self::A,
            18 => self::AN,
            28 => self::A,
            110 => self::A,
            111 => self::A,
            1111 => self::A,
            1100 => self::A,
            18000 => self::AN,
            11000000 => self::AN,
            '-1' => self::A,
            '-18' => self::A
        );

        $this->_testAssertions($assertions);
    }

    /**
     * Ordinal forms
     */
    public function testOrdinals(): void
    {
        $assertions = array(
            'eleventh' => self::AN,
            'eighth' => self::AN,
            'ninth' => self::A,
            'one hundredth' => self::A,
            'eighteenth' => self::AN,
            'millionth' => self::A,
            'elevenhundredth' => self::AN,
            'hundredth' => self::A
        );

        $this->_testAssertions($assertions);
    }

    /**
     * Special cases
     */
    public function testSpecialCases(): void
    {
        $assertions = array(
            'euler number' => self::AN,
            's' => self::AN,
            'x' => self::AN,
            'hour' => self::AN,
            'heir' => self::AN,
            'honest' => self::AN,
            'honorary' => self::AN,
            'b' => self::A,
            'z' => self::A
        );

        $this->_testAssertions($assertions);
    }

    /**
     * Abbreviations
     */
    public function testAbbreviations(): void
    {
        $assertions = array('mr.' => self::A, 'mrs.' => self::A, 'dr.' => self::A, 'st.' => self::A, 'x-ray' => self::AN);

        $this->_testAssertions($assertions);
    }

    /**
     * Consonants
     */
    public function testConsonants(): void
    {
        $assertions = array(
            'dog' => self::A,
            'horse' => self::A,
            'zealot' => self::A,
            'doctor' => self::A,
            'dancer' => self::A,
            'car' => self::A,
            'laser' => self::A,
            'beer' => self::A
        );

        $this->_testAssertions($assertions);
    }

    /**
     * Special vowel forms
     */
    public function testSpecialVowelForms(): void
    {
        $assertions = array(
            'european' => self::A,
            'once' => self::A,
            'one' => self::A,
            'university' => self::A,
            'universal' => self::A,
            'utter' => self::AN,
            'useful' => self::A
        );

        $this->_testAssertions($assertions);
    }

    /**
     * Special capitals
     */
    public function testSpecialCapitals(): void
    {
        $assertions = array('Ukranian' => self::AN, 'Uzbekistani' => self::AN, 'UNO' => self::A, 'American' => self::AN);

        $this->_testAssertions($assertions);
    }

    /**
     * Vowels
     */
    public function testVowels(): void
    {
        $assertions = array(
            'apple' => self::AN,
            'elephant' => self::AN,
            'ugly duck' => self::AN,
            'unit' => self::A,
            'itchy sweater' => self::AN,
            'engineer' => self::AN,
            'orange' => self::AN
        );

        $this->_testAssertions($assertions);
    }

    /**
     * Y
     */
    public function testY(): void
    {
        $assertions = array('year' => self::A, 'yellow' => self::A, 'yclad' => self::AN);

        $this->_testAssertions($assertions);
    }

    /**
     * Actually test assertions
     *
     * @param  array $cases Array of key/value assertions
     */
    private function _testAssertions(array $cases = array()): void
    {
        foreach ($cases as $case => $prefix) {
            // ensure that the expected prefix is added to the original case
            $a = IndefiniteArticle::invoke($case);
            $this->assertEquals($prefix . ' ' . $case, $a);
        }
    }
}
