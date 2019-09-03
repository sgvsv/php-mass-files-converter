<?php

require_once __DIR__ . '/vendor/autoload.php';

use \sgvsv\FilesConverter\Converter;

//Argument is a directory to convert
//c:\\my\\dir in windows or /path/to/dir in linux
$converter = new Converter("c:\\my\\dir");

//Files with /vendor/ or /.git/ substrings in their paths will be ignored
$converter->setIgnoredPaths(['/vendor/', '/.git/']);

//Files with other extensions will be ignored
$converter->setExtensions(['txt', 'php']);

//Output list of files and detected encodings
echo $converter->preview();

//Files that wasn't in UTF will be replaced with converted files
//File that already was in UTF will not be changed
$converter->convert();