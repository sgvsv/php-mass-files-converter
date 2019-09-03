<?php

namespace sgvsv\FilesConverter;

class Converter
{
    private $sourceEncoding = "windows-1251";
    private $iterator;

    /**
     * @return array
     */
    public function getExtensions(): array
    {
        return $this->iterator->extensions;
    }

    /**
     * @param array $extensions
     */
    public function setExtensions(array $extensions): void
    {
        $this->iterator->extensions = $extensions;
        $this->iterator->rewind();
    }

    /**
     * @return mixed
     */
    public function getDirectory()
    {
        return $this->iterator->directory;
    }

    /**
     * @param mixed $directory
     */
    protected function setDirectory($directory): void
    {
        $this->iterator = new Iterator($directory);
    }

    /**
     * @return array
     */
    public function getIgnoredPaths(): array
    {
        return $this->iterator->ignoredPaths;
    }

    /**
     * @param array $ignoredPaths
     */
    public function setIgnoredPaths(array $ignoredPaths): void
    {
        $this->iterator->ignoredPaths = $ignoredPaths;
        $this->iterator->rewind();
    }

    public function __construct(string $directory)
    {
        $this->setDirectory($directory);
    }

    public function preview(): string
    {
        $result = '';
        foreach ($this->iterator as $value) {
            $fileName = (string)$value;
            $contents = file_get_contents($fileName);
            $sourceEncoding = $this->isUTF($contents) ? 'UTF-8' : $this->sourceEncoding;
            $result .= "File: $fileName current encoding is $sourceEncoding\n";
        }
        return $result;
    }

    private function isUTF(string $text): bool
    {
        return (bool)preg_match('#.#u', $text);
    }

    public function convert(): void
    {
        foreach ($this->iterator as $value) {
            $fileName = (string)$value;
            $contents = file_get_contents($fileName);
            $sourceEncoding = $this->isUTF($contents) ? 'UTF-8' : $this->sourceEncoding;
            if ($sourceEncoding != 'UTF-8') {
                file_put_contents($fileName, iconv($sourceEncoding, "UTF-8", $contents));
            }
        }
    }
}