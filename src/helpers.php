<?php

use Jackiedo\PathHelper\Path;

if (!function_exists('absolute_path')) {
    /**
     * Return absolute path from a given path.
     *
     * This function is an alternative to `realpath()` function for non-existent paths.
     *
     * @param string $path      the path want to format
     * @param string $separator the directory separator want to use in the result
     *
     * @return string
     */
    function absolute_path($path, $separator = DIRECTORY_SEPARATOR)
    {
        return Path::absolute($path, $separator);
    }
}

if (!function_exists('relative_path')) {
    /**
     * Return relative path from a given file or directory to another location.
     *
     * @param string $from      the path of departure file or directory
     * @param string $to        the path of destination file or directory
     * @param string $separator the directory separator want to use in the result
     *
     * @return string
     */
    function relative_path($from, $to, $separator = DIRECTORY_SEPARATOR)
    {
        return Path::relative($from, $to, $separator);
    }
}

if (!function_exists('winstyle_path')) {
    /**
     * Normalize directory separators of a given path according to Windows OS style.
     *
     * @param string $path the path want to normalize
     *
     * @return string
     */
    function winstyle_path($path)
    {
        return Path::winStyle($path);
    }
}

if (!function_exists('unixstyle_path')) {
    /**
     * Normalize directory separators of a given path according to Unix OS style.
     *
     * @param string $path the path want to normalize
     *
     * @return string
     */
    function unixstyle_path($path)
    {
        return Path::unixStyle($path);
    }
}

if (!function_exists('osstyle_path')) {
    /**
     * Normalize directory separators of a given path according to the current OS style.
     *
     * @param string $path the path want to normalize
     *
     * @return string
     */
    function osstyle_path($path)
    {
        return Path::osStyle($path);
    }
}

if (!function_exists('normalize_path')) {
    /**
     * Formats the directory separators of a given path with a specific string.
     *
     * @param string $path      the path want to normalize
     * @param string $separator the directory separator want to use
     *
     * @return string
     */
    function normalize_path($path, $separator = DIRECTORY_SEPARATOR)
    {
        return Path::normalize($path, $separator);
    }
}

if (!function_exists('is_absolute_path')) {
    /**
     * Check if a given path is an absolute path.
     *
     * @param string $path the path want to check
     *
     * @return bool
     */
    function is_absolute_path($path)
    {
        return Path::isAbsolute($path);
    }
}

if (!function_exists('is_relative_path')) {
    /**
     * Check if a given path is a relative path.
     *
     * @param string $path the path want to check
     *
     * @return bool
     */
    function is_relative_path($path)
    {
        return Path::isRelative($path);
    }
}

if (!function_exists('is_descendant_path')) {
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
    function is_descendant_path($path, $comparison)
    {
        return Path::isDescendant($path, $comparison);
    }
}

if (!function_exists('is_ancestor_path')) {
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
    function is_ancestor_path($path, $comparison)
    {
        return Path::isAncestor($path, $comparison);
    }
}
