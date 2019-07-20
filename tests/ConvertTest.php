<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pulsestorm\CommonMark\RoundTripConverter;

class ConvertTest extends TestCase
{
    protected $converter;
    public function setUp() : void
    {
        $this->converter = new RoundTripConverter([]);
    }

    public function getFiles() : array {
        return [
//             'magento2-database.md',
//             'magento2-mvc.md',
//             'pestle-third-party.md',
//             'magento2-scans-and-reports.md',
//             'magento2-generate-acl.md',
//             'magento2-generate-ui.md',
//             'magento2-di-observers.md',
//             'magento2-introduction.md',
//             'magento2-other-introduction.md',
//             'dev-internals-enviornment.md',
//             'dev-internals-introduction.md',
//             'magento2-other-other.md',
//             'magento2-others.md',
//             'pestle-generate.md',
//             'dev-internals-theroy-of-operation.md',
//             'index.md',
//             'magento2-module-setup.md',
            'magento2-generate-full-module.md',
//             'pestle-library.md',
//             'dev-internals-build.md',
//             'magento2-quick-conversions.md',
        ];
    }

    public function testDocs(): void
    {
        $files = $this->getFiles();
        $baseFolder = realpath(__DIR__) . '/fixtures';
        foreach($files as $file) {
            $file = $baseFolder . '/' . $file;

            $fromDisk = trim(file_get_contents($file));
            $converted = trim($this->converter->convertToMarkdown($fromDisk));

            $path1 = '/tmp/' . md5($fromDisk);
            $path2 = '/tmp/' . md5($converted);

            if($path1 !== $path2) {
                file_put_contents($path1, $fromDisk);
                file_put_contents($path2, $converted);
                $cmd = "diff $path1 $path2";
                $output = `$cmd`;
                $this->log("$file\nbb$cmd\n$output");
            }

            $this->assertEquals($path1, $path2,"meow");
        }
    }

    public function log($string) {
        file_put_contents(
            '/tmp/commonmark-roundtrip.log',
            $string,
            FILE_APPEND
        );
    }
}


// $contents = file_get_contents('/Users/alanstorm/Documents/github/astorm/pestle/docs/magento2-mvc.md');
// echo $converter->convertToMarkdown($contents);
