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
     * Return absolute path from a given path.
     *
     * This method is an alternative to `realpath()` function for non-existent paths.
     *
     * @param string $path      the path want to format
     * @param string $separator the directory separator want to use in the result
     *
     * @return string
     */
    public static function absolute($path, $separator = DIRECTORY_SEPARATOR)
    {
        // Normalize directory separators
        $separator = $separator ?: DIRECTORY_SEPARATOR;
        $path      = static::normalize($path, $separator);

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

            $path = static::normalize(getcwd(), $separator) . $separator . $path;
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
     * Return relative path from a given file or directory to another location.
     *
     * @param string $from      the path of departure file or directory
     * @param string $to        the path of destination file or directory
     * @param string $separator the directory separator want to use in the result
     *
     * @return string
     */
    public static function relative($from, $to, $separator = DIRECTORY_SEPARATOR)
    {
        $separator  = $separator ?: DIRECTORY_SEPARATOR;
        $fromParts  = explode($separator, static::absolute($from, $separator));
        $toParts    = explode($separator, static::absolute($to, $separator));
        $diffFromTo = array_diff_assoc($fromParts, $toParts);
        $diffToFrom = array_diff_assoc($toParts, $fromParts);

        if ($diffToFrom === $toParts) {
            return implode($separator, $toParts);
        }

        return str_repeat('..' . $separator, count($diffFromTo)) . implode($separator, $diffToFrom);
    }

    /**
     * Check if a given path is an absolute path.
     *
     * @param string $path the path want to check
     *
     * @return bool
     */
    public static function isAbsolute($path)
    {
        return !static::isRelative($path);
    }

    /**
     * Check if a given path is a relative path.
     *
     * @param string $path the path want to check
     *
     * @return bool
     */
    public static function isRelative($path)
    {
        $path       = static::normalize($path, DIRECTORY_SEPARATOR);
        $splitParts = explode(DIRECTORY_SEPARATOR, $path);

        if (in_array('.', $splitParts) || in_array('..', $splitParts)) {
            return true;
        }

        return '' !== $splitParts[0] && 0 === preg_match('/^[a-z]:$/i', $splitParts[0]);
    }

    /**
     * Check if a given path is descendant of the another path.
     *
     * Return true if the input path is descendant of the comparison
     *
     * @param string $path       the path want to check
     * @param string $comparison the target path used for comparison
     *
     * @return bool
     */
    public static function isDescendant($path, $comparison)
    {
        $ancestor   = static::absolute($comparison);
        $descendant = static::absolute($path);

        return substr($descendant, 0, strlen($ancestor)) === $ancestor;
    }

    /**
     * Check if a given path is ancestor of the another path.
     *
     * Return true if the input path is ancestor of the comparison
     *
     * @param string $path       the path want to check
     * @param string $comparison the target path used for comparison
     *
     * @return bool
     */
    public static function isAncestor($path, $comparison)
    {
        $ancestor   = static::absolute($path);
        $descendant = static::absolute($comparison);

        return substr($descendant, 0, strlen($ancestor)) === $ancestor;
    }

    /**
     * Normalize directory separators of a given path according to Windows OS style.
     *
     * @param string $path the path want to normalize
     *
     * @return string
     */
    public static function winStyle($path)
    {
        return str_replace('/', '\\', (string) $path);
    }

    /**
     * Normalize directory separators of a given path according to Unix OS style.
     *
     * @param string $path the path want to normalize
     *
     * @return string
     */
    public static function unixStyle($path)
    {
        return str_replace('\\', '/', (string) $path);
    }

    /**
     * Normalize directory separators of a given path according to the current OS style.
     *
     * @param string $path the path want to normalize
     *
     * @return string
     */
    public static function osStyle($path)
    {
        return static::normalize($path, DIRECTORY_SEPARATOR);
    }

    /**
     * Formats the directory separators of a given path with a specific string.
     *
     * @param string $path      the path want to normalize
     * @param string $separator the directory separator want to use
     *
     * @return string
     */
    public static function normalize($path, $separator = DIRECTORY_SEPARATOR)
    {
        return str_replace(['/', '\\'], (string) $separator, (string) $path);
    }
}
