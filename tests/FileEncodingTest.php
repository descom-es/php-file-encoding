<?php
namespace Descom\FileEncoding\Test;
use Descom\FileEncoding;

class FileEncodingTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        copy('files/test_iso88591.txt', 'iso88591.txt');
        copy('files/test_utf8.txt', 'utf8.txt');
    }

    /** @test */
    public function test_encoding_iso88591_as_UTF8()
    {
        $encoding = new FileEncoding();
        $result = FileEncoding->encodeFile('iso88591.txt', 'UTF-8', 'UTF-8,ISO-8859-1,WINDOWS-1252');
        $this->assertTrue($result);
    }

    /** @test */
    public function test_encoding_UTF8_as_UTF8()
    {
        $encoding = new FileEncoding();
        $result = FileEncoding->encodeFile('utf8.txt');
        $this->assertTrue($result);
    }

    /** @test */
    public function test_encoding_file_not_exists()
    {
        $encoding = new FileEncoding();
        $result = FileEncoding->encodeFile('test.txt');
        $this->assertFalse($result);
    }
}
