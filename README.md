# PHP Indefinite Article Library

PHP implementation of the [Lingua::EN::Inflect](http://search.cpan.org/dist/Lingua-EN-Inflect/lib/Lingua/EN/Inflect.pm) 
Perl module's A() and AN() subroutines, 
originally [ported to PHP](https://github.com/Kaivosukeltaja/php-indefinite-article) by [Niko Salminen](http://nikosalminen.com),
and then by [made into composer package](https://github.com/zachflower/php-indefinite-article) by [Zach Flower](https://zacharyflower.com/).

## Installation

### Via Composer

Require the library and update via [Composer](https://getcomposer.org/)
```php
composer require bmstanley/indefinite-article
composer update
```

## Usage

The PHP Indefinite Article Library is used to determine the proper indefinite article to use before a word ('a' or 'an'). To do so, simply call the `invoke()` method with your word or phrase:

```
IndefiniteArticle::invoke('elephant')
```

The method will return a string prefixed with the appropriate indefinite article:

```
an elephant
```

## Copyright and License

Original Perl module Copyright &copy; 1997-2009 Damian Conway; Original PHP port Copyright &copy; 2012 Niko Salminen; Original library copyright &copy; 2016 Zachary Flower and copyright &copy; 2018 Spenser Hale; Current library copyright &copy; 2019 Brian Stanley; Code released under the [BSD license](LICENSE).
