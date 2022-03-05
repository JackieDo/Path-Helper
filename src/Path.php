<?php

namespace Jackiedo\PathHelper;

/**
 * The Path Helper class.
 *
 * @package jackiedo/path-helper
 *
 * @author  Jackie Do <anhvudo@gmail.com>
 */
class Path
{
    /**
     * The original path.
     *
     * @var string
     */
    protected $path;

    /**
     * The constructor.
     *
     * @param string $path
     */
    public function __construct($path = null)
    {
        $this->path = (string) $path;
    }

    /**
     * Load the original path.
     *
     * @param string $path
     *
     * @return Path
     */
    public static function load($path)
    {
        return new static($path);
    }

    /**
     * Return absolute path from the loaded path.
     *
     * This function is an alternative to realpath() function for non-existent paths.
     *
     * @param string $separator the directory separator wants to use in the results
     *
     * @return string
     */
    public function absolute($separator = DIRECTORY_SEPARATOR)
    {
        return $this->makeAbsolutePath($this->path, $separator);
    }

    /**
     * Return relative path from the loaded path to the specific path.
     *
     * @param string $path      the path of file or directory want to go to
     * @param string $separator the directory separator wants to use in the results
     *
     * @return string
     */
    public function relativeTo($path, $separator = DIRECTORY_SEPARATOR)
    {
        $separator  = $separator ?: DIRECTORY_SEPARATOR;
        $fromParts  = explode($separator, $this->makeAbsolutePath($this->path, $separator));
        $toParts    = explode($separator, $this->makeAbsolutePath($path, $separator));
        $diffFromTo = array_diff_assoc($fromParts, $toParts);
        $diffToFrom = array_diff_assoc($toParts, $fromParts);

        if ($diffToFrom === $toParts) {
            return implode($separator, $toParts);
        }

        return str_repeat('..' . $separator, count($diffFromTo)) . implode($separator, $diffToFrom);
    }

    /**
     * Return relative path from the specific path to the loaded path.
     *
     * @param string $path      the departure file or directory location
     * @param string $separator the directory separator wants to use in the results
     *
     * @return string
     */
    public function relativeFrom($path, $separator = DIRECTORY_SEPARATOR)
    {
        $separator  = $separator ?: DIRECTORY_SEPARATOR;
        $fromParts  = explode($separator, $this->makeAbsolutePath($path, $separator));
        $toParts    = explode($separator, $this->makeAbsolutePath($this->path, $separator));
        $diffFromTo = array_diff_assoc($fromParts, $toParts);
        $diffToFrom = array_diff_assoc($toParts, $fromParts);

        if ($diffToFrom === $toParts) {
            return implode($separator, $toParts);
        }

        return str_repeat('..' . $separator, count($diffFromTo)) . implode($separator, $diffToFrom);
    }

    /**
     * Check if the loaded path is an absolute path.
     *
     * @return bool
     */
    public function isAbsolute()
    {
        return !$this->isRelative();
    }

    /**
     * Check if the loaded path is a relative path.
     *
     * @return bool
     */
    public function isRelative()
    {
        $path       = $this->normalizePath($this->path, DIRECTORY_SEPARATOR);
        $splitParts = explode(DIRECTORY_SEPARATOR, $path);

        if (in_array('.', $splitParts) || in_array('..', $splitParts)) {
            return true;
        }

        return '' !== $splitParts[0] && 0 === preg_match('/^[a-z]:$/i', $splitParts[0]);
    }

    /**
     * Check if the loaded path is descendant of the specific path.
     *
     * @param string $path the ancestor
     *
     * @return bool
     */
    public function isDescendantOf($path)
    {
        $ancestor   = $this->makeAbsolutePath($path);
        $descendant = $this->makeAbsolutePath($this->path);

        return substr($descendant, 0, strlen($ancestor)) === $ancestor;
    }

    /**
     * Check if the loaded path is ancestor of the specific path.
     *
     * @param string $path the ancestor
     *
     * @return bool
     */
    public function isAncestorOf($path)
    {
        $ancestor   = $this->makeAbsolutePath($this->path);
        $descendant = $this->makeAbsolutePath($path);

        return substr($descendant, 0, strlen($ancestor)) === $ancestor;
    }

    /**
     * Convert the loaded path to Windows style.
     *
     * @return string
     */
    public function winStyle()
    {
        return str_replace('/', '\\', $this->path);
    }

    /**
     * Convert the loaded path to Unix style.
     *
     * @return string
     */
    public function unixStyle()
    {
        return str_replace('\\', '/', $this->path);
    }

    /**
     * Normalize the loaded path separators according to the current OS style.
     *
     * @return string
     */
    public function osStyle()
    {
        return $this->normalizePath($this->path, DIRECTORY_SEPARATOR);
    }

    /**
     * Formats the directory separators of the loaded path with a specific string.
     *
     * @param string $separator the directory separator want to use
     *
     * @return string
     */
    public function normalize($separator = DIRECTORY_SEPARATOR)
    {
        return $this->normalizePath($this->path, $separator);
    }

    /**
     * Make the absolute path from the specific path.
     *
     * @param string $path      the input path
     * @param string $separator the directory separator want to use
     *
     * @return string
     */
    protected function makeAbsolutePath($path, $separator = DIRECTORY_SEPARATOR)
    {
        // Normalize directory separators
        $separator = $separator ?: DIRECTORY_SEPARATOR;
        $path      = $this->normalizePath($path, $separator);

        // Store root part of path
        $root = null;

        while (is_null($root)) {
            // Check if path start with a separator (UNIX)
            if (substr($path, 0, 1) === $separator) {
                $root = $separator;
                $path = substr($path, 1);

                break;
            }

            // Check if path start with drive letter (WINDOWS OS)
            preg_match('/^[a-z]:' . preg_quote($separator, '/') . '/i', $path, $matches);

            if (isset($matches[0])) {
                $root = $matches[0];
                $path = substr($path, 2);

                break;
            }

            $path = $this->normalizePath(getcwd(), $separator) . $separator . $path;
        }

        // Get and filter empty sub paths
        $subPaths  = array_filter(explode($separator, $path), 'strlen');
        $absolutes = [];

        foreach ($subPaths as $subPath) {
            if ('.' === $subPath) {
                continue;
            }

            if ('..' === $subPath) {
                array_pop($absolutes);

                continue;
            }

            $absolutes[] = $subPath;
        }

        return $root . implode($separator, $absolutes);
    }

    /**
     * Formats the directory separators of the path with a specific string.
     *
     * @param string $path      the input path
     * @param string $separator the directory separator want to use
     *
     * @return string
     */
    protected function normalizePath($path, $separator = DIRECTORY_SEPARATOR)
    {
        return str_replace(['/', '\\'], (string) $separator, (string) $path);
    }
}
