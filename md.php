<?php
namespace Pulsestorm\CommonMark;
require 'vendor/autoload.php';

// $converter = new CommonMarkConverter([
//     'html_input' => 'strip',
//     'allow_unsafe_links' => false,
// ]);
//
// echo $converter->convertToHtml('# Hello World!');

//"Pulsestorm\\CommonMark\\": "src-roundtrip"

$converter = new RoundTripConverter([]);
$contents = file_get_contents('/Users/alanstorm/Documents/github/astorm/pestle/docs/magento2-mvc.md');

// echo $converter->convertToMarkdown('## Hello World
//
// This is a **test**.');

echo $converter->convertToMarkdown($contents);
