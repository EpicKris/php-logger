<?php

namespace EpicKris\Loggers;

use Psr\Log\AbstractLogger;

/**
 * File logger.
 *
 * @package EpicKris\Loggers
 */
class FileLogger extends AbstractLogger
{
    /**
     * @var string Path.
     */
    protected $path;

    /**
     * @var string Extension.
     */
    protected $extension;

    /**
     * @var string Date format.
     */
    protected $dateFormat;

    /**
     * @var array Is PHP.
     */
    protected $isPhp = [];

    /**
     * File logger constructor.
     *
     * @param string $path      Path.
     * @param string $extension Extension.
     */
    public function __construct($path = '', $extension = 'log')
    {
        $this->setPath($path);
        $this->setExtension($extension);
    }

    /**
     * Set path.
     *
     * @param string $path Path.
     */
    public function setPath($path)
    {
        if (! is_string($path)) {
            throw new \InvalidArgumentException('Path must be a string.');
        }

        $path = trim($path);

        $this->path = $path;
    }

    /**
     * Set extension.
     *
     * @param string $extension Extension.
     */
    public function setExtension($extension)
    {
        if (! is_string($extension)) {
            throw new \InvalidArgumentException('Extension must be a string.');
        }

        $extension = trim($extension);
        $extension = ltrim($extension);

        $this->extension = $extension;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param string $level   Level.
     * @param string $message Message.
     * @param array  $context Context.
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        if (! file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }

        if (! is_dir($this->path) || ! $this->isReallyWritable($this->path)) {
            return;
        }

        // TODO: Continue to implement log() method.
    }

    /**
     * Tests if a file is writable.
     *
     * @param string $file File.
     *
     * @return bool Returns true if file is writable, else false.
     */
    protected function isReallyWritable($file)
    {
        if (! is_string($file)) {
            throw new \InvalidArgumentException('File must be a string.');
        }

        if (DIRECTORY_SEPARATOR === '/' && ($this->isPhp('5.4') || ! ini_get('safe_mode'))) {
            return is_writable($file);
        }

        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand());
            if (($fp = @fopen($file, 'ab')) === false) {
                return false;
            }

            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);

            return true;
        } elseif (! is_file($file) || ($fp = @fopen($file, 'ab')) === false) {
            return false;
        }

        fclose($fp);

        return true;
    }

    /**
     * Determines if the current version of PHP is equal to or greater than the supplied value.
     *
     * @param string $version Version.
     *
     * @return bool Returns true if the current version is $version or higher.
     */
    protected function isPhp($version)
    {
        if (! is_string($version)) {
            throw new \InvalidArgumentException('Version must be a string.');
        }

        if (! isset($this->isPhp[$version])) {
            $this->isPhp[$version] = version_compare(PHP_VERSION, $version, '>=');
        }

        return $this-isPhp[$version];
    }
}
