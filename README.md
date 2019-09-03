# php-mass-files-converter
Mass recursive convert files in given directory from given encoding to **UTF**. Class checks each file if it is already in UTF. In this case it will not be double-converted.
It is possible to set file extensions to convert. And exclude some subdirs from converting.
## Requirements
 For providing modern PHP features such as setting types in method's signatures **PHP7.1 or higher** is required. 
## Installation
Best way to use this library is install it via composer:
````bash
composer require sgvsv/php-mass-files-converter
````
## Usage example
After installing you can convert files:
````php
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
````