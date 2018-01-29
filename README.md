# PHP convert files encoding
PHP class to convert files encoding

## Usage
```php
__construct($encoding_to = 'UTF-8', $encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252');
EncodeFile($fileR, $fileW, &$encoding_original, &$encoding_final);
```

This is an example:

```php
include 'src/codification.php';

$codification = new Codification();

$fileR = "file.txt";
$fileW = 'encodedFile.txt;
$encoding_original = "";
$encoding_final = "";

$result = $codification->EncodeFile($fileR, $fileW, $encoding_original, $encoding_final);

($result) ? 'True' : 'False';
echo "Original encoding: " . $encoding_original;
echo "Final encoding: " . $encoding_final;
```

## Encoding values

### Allowed encodings
http://php.net/manual/es/mbstring.supported-encodings.php

### Default values
```php
$encoding_to = 'UTF-8';
$encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252';
```
