<?php

namespace Descom\File\Test;

use Descom\File\Encoding;
use PHPUnit\Framework\TestCase;

class FileEncodingTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        copy(__DIR__.'/files/test_iso-8859-1.txt', __DIR__.'/files/iso88591.txt');
        copy(__DIR__.'/files/test_utf8.txt', __DIR__.'/files/utf8.txt');
    }

    public function close()
    {
        unlink(__DIR__.'/files/iso88591.txt');
        unlink(__DIR__.'/files/utf8.txt');
    }

    /** @test */
    public function test_encoding_iso88591_as_UTF8()
    {
        $encoding = new Encoding();

        $this->assertTrue($encoding->detectEncoding(__DIR__.'/files/iso88591.txt', 'UTF-8,ISO-8859-1,WINDOWS-1252') == 'ISO-8859-1');
        $this->assertTrue($encoding->encodeFile(__DIR__.'/files/iso88591.txt', 'UTF-8', 'UTF-8,ISO-8859-1,WINDOWS-1252'));
        $this->assertTrue($encoding->checkEncoding(__DIR__.'/files/iso88591.txt', 'UTF-8'));

        $this->close();
    }

    /** @test */
    public function test_encoding_UTF8_as_UTF8()
    {
        $encoding = new Encoding();
        $this->assertTrue($encoding->detectEncoding('tests/files/utf8.txt', 'UTF-8,ISO-8859-1,WINDOWS-1252') == 'UTF-8');
        $this->assertTrue($result = $encoding->encodeFile('tests/files/utf8.txt'));
        $this->assertTrue($encoding->checkEncoding('tests/files/utf8.txt', 'UTF-8'));

        $this->close();
    }

    /** @test */
    public function test_file_not_exists()
    {
        $encoding = new Encoding();
        $this->assertFalse($encoding->detectEncoding('tests/files/test.txt', 'UTF-8,ISO-8859-1,WINDOWS-1252') == 'UTF-8');
        $this->assertFalse($result = $encoding->encodeFile('tests/files/test.txt'));
        $this->assertFalse($encoding->checkEncoding('tests/files/test.txt', 'UTF-8'));

        $this->close();
    }

    /** @test */
    public function test_encoding_file_not_exists_in_encodings_detected()
    {
        $encoding = new Encoding();
        $this->assertFalse($encoding->encodeFile(__DIR__.'/files/iso88591.txt', 'UTF-8', 'UTF-8,WINDOWS-1252'));
        $this->assertFalse($encoding->checkEncoding(__DIR__.'/files/iso88591.txt', 'UTF-8'));

        $this->close();
    }
}
