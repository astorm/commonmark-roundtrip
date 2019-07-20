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
            'docs/magento2-database.md',
            'docs/magento2-mvc.md',
            'docs/pestle-third-party.md',
            'docs/magento2-scans-and-reports.md',
            'docs/magento2-generate-acl.md',
            'docs/magento2-generate-ui.md',
            'docs/magento2-di-observers.md',
            'docs/magento2-introduction.md',
            'docs/magento2-other-introduction.md',
            'docs/dev-internals-enviornment.md',
            'docs/dev-internals-introduction.md',
            'docs/magento2-other-other.md',
            'docs/magento2-others.md',
            'docs/pestle-generate.md',
            'docs/dev-internals-theroy-of-operation.md',
            'docs/index.md',
            'docs/magento2-module-setup.md',
            'docs/magento2-generate-full-module.md',
            'docs/pestle-library.md',
            'docs/dev-internals-build.md',
            'docs/magento2-quick-conversions.md',
        ];
    }

    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $files = $this->getFiles();
        foreach($files as $file) {
            $file = '/Users/alanstorm/Documents/github/astorm/pestle/' .
                $file;
//                 '/docs/magento2-mvc.md';

            $fromDisk = trim(file_get_contents($file));
            $converted = trim($this->converter->convertToMarkdown($fromDisk));

            $path1 = '/tmp/' . md5($fromDisk);
            $path2 = '/tmp/' . md5($converted);

            if($path1 !== $path2) {
                file_put_contents($path1, $fromDisk);
                file_put_contents($path2, $converted);
                $cmd = "diff $path1 $path2";
                $output = `$cmd`;
                file_put_contents('/tmp/test.log',"$file\n$cmd\n$output",FILE_APPEND);
            }

            $this->assertEquals($path1, $path2,"meow");
        }
    }
}


// $contents = file_get_contents('/Users/alanstorm/Documents/github/astorm/pestle/docs/magento2-mvc.md');
// echo $converter->convertToMarkdown($contents);
