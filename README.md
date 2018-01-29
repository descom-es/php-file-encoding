[![StyleCI](https://styleci.io/repos/119397036/shield)](https://styleci.io/repos/119397036)
# PHP convert files encoding
PHP class to convert files encoding

## Usage
```php
EncodeFile($fileR, $encoding_to, $encodings_detected);
```

This is an example:

```php
$codification = new Codification();

$fileR = 'file.txt';
$encoding_to = 'UTF-8';
$encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252';

$result = $codification->EncodeFile($fileR, $encoding_to, $encodings_detected);
```

## Encoding values

### Allowed encodings
http://php.net/manual/es/mbstring.supported-encodings.php

### Default values
```php
$encoding_to = 'UTF-8';
$encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252';
```
