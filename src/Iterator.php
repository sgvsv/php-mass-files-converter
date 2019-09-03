<?php
/**
 * User: Vasily Svitkin
 * Project: klerk.ru
 * Email: svitkin@gmail.com
 * Date: 03.09.2019
 * Time: 10:15
 */

namespace sgvsv\FilesConverter;


use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class Iterator
 * @property RecursiveIteratorIterator $iterator
 * @package sgvsv\FilesConverter
 */
class Iterator implements \Iterator
{
    private $iterator;
    public $directory;
    public $extensions = ['txt'];
    public $ignoredPaths = [];

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        while (!$this->checkFileConditions($this->iterator->current())) {
            $this->iterator->next();
        }
        return $this->iterator->current();
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        do {
            $this->iterator->next();
        } while ($this->valid() && !$this->checkFileConditions($this->iterator->current()));
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        echo "key";
        die();
        return $this->iterator->key();
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return ($this->iterator->valid());
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }

    private function checkForExtension(string $fileName): bool
    {
        $result = false;
        foreach ($this->extensions as $extension) {
            if (strpos($fileName, ".$extension") === strlen($fileName) - strlen($extension) - 1) {
                $result = true;
                break;
            }
        }
        return $result;
    }

    private function checkForIgnoredPath(string $fileName): bool
    {
        $result = false;
        foreach ($this->ignoredPaths as $path) {
            if (strpos($fileName, $path) !== false) {
                $result = true;
                break;
            }
        }
        return $result;

    }

    private function checkFileConditions(string $fileName): bool
    {
        return ($this->checkForExtension($fileName) && !$this->checkForIgnoredPath($fileName));
    }

    private function initialize()
    {
        $path = realpath($this->directory);
        $this->iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::SELF_FIRST
        );
    }

    public function __construct(string $directory)
    {
        $this->directory = $directory;
        $this->initialize();
    }
}