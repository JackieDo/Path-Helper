<?php

use Jackiedo\PathHelper\Path;

if (!function_exists('absolute_path')) {
    /**
     * Return absolute path from the input path.
     *
     * This function is an alternative to realpath() function for non-existent paths.
     *
     * @param string $path      the input path
     * @param string $separator the directory separator want to use in the result
     *
     * @return string
     */
    function absolute_path($path, $separator = DIRECTORY_SEPARATOR)
    {
        return Path::load($path)->absolute($separator);
    }
}

if (!function_exists('relative_path')) {
    /**
     * Return relative path from the source file or directory to destination.
     *
     * @param string $from      the path of source file or directory
     * @param string $to        the path of file or directory want to go to
     * @param string $separator the directory separator want to use in the result
     *
     * @return string
     */
    function relative_path($from, $to, $separator = DIRECTORY_SEPARATOR)
    {
        return Path::load($from)->relativeTo($to, $separator);
    }
}

if (!function_exists('winstyle_path')) {
    /**
     * Convert path to Windows OS style.
     *
     * @param string $path the input path
     *
     * @return string
     */
    function winstyle_path($path)
    {
        return Path::load($path)->winStyle();
    }
}

if (!function_exists('unixstyle_path')) {
    /**
     * Convert path to Unix OS style.
     *
     * @param string $path the input path
     *
     * @return string
     */
    function unixstyle_path($path)
    {
        return Path::load($path)->unixStyle();
    }
}

if (!function_exists('osstyle_path')) {
    /**
     * Normalize the path separators according to the current OS style.
     *
     * @param string $path the input path
     *
     * @return string
     */
    function osstyle_path($path)
    {
        return Path::load($path)->osStyle();
    }
}

if (!function_exists('normalize_path')) {
    /**
     * Formats the directory separators of the specific path with a specific string.
     *
     * @param string $path      the input path
     * @param string $separator the directory separator want to use in the result
     *
     * @return string
     */
    function normalize_path($path, $separator = DIRECTORY_SEPARATOR)
    {
        return Path::load($path)->normalize($separator);
    }
}

if (!function_exists('is_absolute_path')) {
    /**
     * Check if the path is an absolute path.
     *
     * @param string $path the input path
     *
     * @return bool
     */
    function is_absolute_path($path)
    {
        return Path::load($path)->isAbsolute();
    }
}

if (!function_exists('is_relative_path')) {
    /**
     * Check if the path is a relative path.
     *
     * @param string $path the input path
     *
     * @return bool
     */
    function is_relative_path($path)
    {
        return Path::load($path)->isRelative();
    }
}

if (!function_exists('is_descendant_path')) {
    /**
     * Check if the input path is descendant of the another path.
     *
     * Return true if the input path is descendant of the comparison
     *
     * @param string $path       the input path want to verify
     * @param string $comparison the target path used for comparison
     *
     * @return bool
     */
    function is_descendant_path($path, $comparison)
    {
        return Path::load($path)->isDescendantOf($comparison);
    }
}

if (!function_exists('is_ancestor_path')) {
    /**
     * Check if the input path is ancestor of the another path.
     *
     * Return true if the input path is ancestor of the comparison
     *
     * @param string $path       the input path want to verify
     * @param string $comparison the target path used for comparison
     *
     * @return bool
     */
    function is_ancestor_path($path, $comparison)
    {
        return Path::load($path)->isAncestorOf($comparison);
    }
}
