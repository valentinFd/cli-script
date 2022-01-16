<?php

use App\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testValidFile()
    {
        file_put_contents('test.txt', 'asd');
        $app = new App(['script.php', '-i', 'test.txt']);
        $response = $app->start();
        $this->assertEquals(3, $response);
    }

    public function testInvalidFileContent()
    {
        file_put_contents('test.txt', 'āsd');
        $app = new App(['script.php', '-i', 'test.txt']);
        $response = $app->start();
        $this->assertEquals(2, $response);

        file_put_contents('test.txt', 'Asd');
        $app = new App(['script.php', '-i', 'test.txt']);
        $response = $app->start();
        $this->assertEquals(2, $response);

        file_put_contents('test.txt', 'a sd');
        $app = new App(['script.php', '-i', 'test.txt']);
        $response = $app->start();
        $this->assertEquals(2, $response);
    }

    public function testValidFormat()
    {
        file_put_contents('test.txt', 'asd');
        $app = new App(['script.php', '-i', 'test.txt', '-f', 'most-repeating']);
        $response = $app->start();
        $this->assertEquals(4, $response);
    }

    public function testValidCharacter()
    {
        file_put_contents('test.txt', 'asd');
        $app = new App(['script.php', '-i', 'test.txt', '-f', 'most-repeating', '-L']);
        $response = $app->start();
        $this->assertEquals([
            'file' => 'test.txt',
            'format' => 'most-repeating',
            'letter' => 'a'
        ], $response);
    }

    public function testNoCharactersFound()
    {
        file_put_contents('test.txt', 'asd');
        $app = new App(['script.php', '-i', 'test.txt', '-f', 'most-repeating', '-P']);
        $response = $app->start();
        $this->assertEquals([
            'file' => 'test.txt',
            'format' => 'most-repeating',
            'punctuation' => 'none'
        ], $response);
    }

    public function testThreeCharactersMostRepeating()
    {
        file_put_contents('test.txt', 'aassdddd112222223$$$$+++++........???');
        $app = new App(['script.php', '-i', 'test.txt', '-f', 'most-repeating', '-L', '-P', '-S']);
        $response = $app->start();
        $this->assertEquals([
            'file' => 'test.txt',
            'format' => 'most-repeating',
            'letter' => 'd',
            'punctuation' => '.',
            'symbol' => '2',
        ], $response);
    }

    public function testLeastRepeating()
    {
        file_put_contents('test.txt', 'aassdddd112222223$$$$+++++........???');
        $app = new App(['script.php', '-i', 'test.txt', '-f', 'least-repeating', '-L', '-P', '-S']);
        $response = $app->start();
        $this->assertEquals([
            'file' => 'test.txt',
            'format' => 'least-repeating',
            'letter' => 'a',
            'punctuation' => '?',
            'symbol' => '3',
        ], $response);
    }

    public function testNonRepeating()
    {
        file_put_contents('test.txt', 'aassdddd112222223$$$$+++++........???');
        $app = new App(['script.php', '-i', 'test.txt', '-f', 'non-repeating', '-L', '-P', '-S']);
        $response = $app->start();
        $this->assertEquals([
            'file' => 'test.txt',
            'format' => 'non-repeating',
            'letter' => 'none',
            'punctuation' => 'none',
            'symbol' => '3',
        ], $response);
    }
}
