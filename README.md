[![StyleCI](https://styleci.io/repos/119397036/shield)](https://styleci.io/repos/119397036)
[![Build Status](https://travis-ci.org/descom-es/php-file-encoding.svg?branch=1.0)](https://travis-ci.org/descom-es/php-file-encoding)

# PHP convert files encoding
PHP class to convert files encoding

## Installation

You can install it with composer:

```bash
composer require descom/file_encoding
```

## Usage
```php
encodeFile($file, $encoding_to, $encodings_detected);
```

This is an example:

```php
use Descom\File\Encoding;

$codification = new Encoding();

$file = 'file.txt';
$encoding_to = 'UTF-8';
$encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252';

$result = $codification->encodeFile($file, $encoding_to, $encodings_detected);
```

## Encoding values

### Allowed encodings
http://php.net/manual/es/mbstring.supported-encodings.php

### Default values
```php
$encoding_to = 'UTF-8';
$encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252';
```
