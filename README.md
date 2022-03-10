# Path Helper

[![Latest Stable Version](https://poser.pugx.org/jackiedo/path-helper/v)](//packagist.org/packages/jackiedo/path-helper)
[![Total Downloads](https://poser.pugx.org/jackiedo/path-helper/downloads)](//packagist.org/packages/jackiedo/path-helper)
[![Latest Unstable Version](https://poser.pugx.org/jackiedo/path-helper/v/unstable)](//packagist.org/packages/jackiedo/path-helper)
[![License](https://poser.pugx.org/jackiedo/path-helper/license)](//packagist.org/packages/jackiedo/path-helper)

Helper class for working with local paths in PHP.

# Compatibility
This package requires PHP 5.4.0 or later.

# Overview
Look at one of the following topics to learn more about Path Helper

- [Path Helper](#path-helper)
- [Compatibility](#compatibility)
- [Overview](#overview)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Using static method](#using-static-method)
    - [Using method of instance](#using-method-of-instance)
    - [Using built-in function](#using-built-in-function)
  - [Available methods](#available-methods)
    - [Normalize the directory separators of the path](#normalize-the-directory-separators-of-the-path)
    - [Restyle the path](#restyle-the-path)
      - [Restyle to Unix style](#restyle-to-unix-style)
      - [Restyle to Windows style](#restyle-to-windows-style)
      - [Restyle belong to current OS](#restyle-belong-to-current-os)
    - [Create the absolute path](#create-the-absolute-path)
    - [Create the relative path](#create-the-relative-path)
    - [Check the form of the path](#check-the-form-of-the-path)
      - [Check the absolute form](#check-the-absolute-form)
      - [Check the relative form](#check-the-relative-form)
    - [Check the mutual wrapping of paths](#check-the-mutual-wrapping-of-paths)
      - [Check if the path is ancestor of another](#check-if-the-path-is-ancestor-of-another)
      - [Check if the path is descendant of another](#check-if-the-path-is-descendant-of-another)
  - [Available functions](#available-functions)
- [License](#license)

## Installation
[Download a latest package](https://github.com/JackieDo/Path-Helper/releases/latest) or use [Composer](http://getcomposer.org/):

```shell
$ composer require jackiedo/path-helper
```

## Usage

After requiring composer autoloader, you can use the package in the following ways:

### Using static method

``` php
use Jackiedo\PathHelper\Path;

// ...

$return = Path::doSomething();
```

### Using method of instance

```php
use Jackiedo\PathHelper\Path;

// ...

$helper = new Path;
$return = $helper->doSomething();
```

### Using built-in function

See [here](#available-functions) for more details.

## Available methods

### Normalize the directory separators of the path
Formats the directory separators of a given path with a specific string.

**Syntax:**

```php
/**
 * Formats the directory separators of a given path with a specific string.
 *
 * @param string $path      the path want to normalize
 * @param string $separator the directory separator want to use
 *
 * @return string
 */
public static function normalize($path, $separator = DIRECTORY_SEPARATOR);
```

**Example:**

```php
$return1 = Path::normalize('path\\to/specific/file/or\\directory');
// The result returned will depend on the operating system
//     On Windows -> path\to\specific\file\or\directory
//     On Unix    -> path/to/specific/file/or/directory

$return2 = Path::normalize('path\\to/specific/file/or\\directory', '/');
// path/to/specific/file/or/directory

$return3 = Path::normalize('path\\to/specific/file/or\\directory', ' > ');
// path > to > specific > file > or > directory
```

### Restyle the path

#### Restyle to Unix style
Alternative to `normalize($path, '/')` method.

**Syntax:**

```php
/**
 * Normalize directory separators of a given path according to Unix OS style.
 *
 * @param string $path the path want to normalize
 *
 * @return string
 */
public static function unixStyle($path);
```

**Example:**

```php
$return = Path::unixStyle('path\\to/specific/file/or\\directory');
// path/to/specific/file/or/directory
```

#### Restyle to Windows style
Alternative to `normalize($path, '\\')` method.

**Syntax:**

```php
/**
 * Normalize directory separators of a given path according to Windows OS style.
 *
 * @param string $path the path want to normalize
 *
 * @return string
 */
public static function winStyle($path);
```

**Example:**

```php
$return = Path::winStyle('path\\to/specific/file/or\\directory');
// path\to\specific\file\or\directory
```

#### Restyle belong to current OS
Alternative to `normalize($path, DIRECTORY_SEPARATOR)` method.

**Syntax:**

```php
/**
 * Normalize directory separators of a given path according to the current OS style.
 *
 * @param string $path the path want to normalize
 *
 * @return string
 */
public static function osStyle($path);
```

**Example:**

```php
$return = Path::osStyle('path\\to/specific/file/or\\directory');
// The result returned will depend on the operating system
//     On Windows -> path\to\specific\file\or\directory
//     On Unix    -> path/to/specific/file/or/directory
```

### Create the absolute path
Create the absolute path from a given path.

**Syntax:**

```php
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
public static function absolute($path, $separator = DIRECTORY_SEPARATOR);
```

**Example:**

```php
$return = Path::absolute('./this\\is/../sample/path');
// The result returned will depend on the operating system and current working directory
// You will probably get the following result: /home/www/public_html/this/sample/path
```

**Note:**

This method looks like PHP's `realpath()` function at first glance, but it actually works in a different way.

> The `realpath()` function returns the absolute path to the `existing` directory or file, while this method `does not check` for actual existence.

### Create the relative path
Create the relative path from a given file or directory to another location.

**Syntax:**

```php
/**
 * Return relative path from a given file or directory to another location.
 *
 * @param string $from      the path of departure file or directory
 * @param string $to        the path of destination file or directory
 * @param string $separator the directory separator want to use in the result
 *
 * @return string
 */
public static function relative($from, $to, $separator = DIRECTORY_SEPARATOR);
```

**Example:**

```php
$return = Path::absolute('./this\\is/../sample/path', '/home/www/another/directory');
// The result returned will depend on the operating system and current working directory
// You will probably get the following result: ../../../../another/directory
```

### Check the form of the path

#### Check the absolute form

**Syntax:**

```php
/**
 * Check if a given path is an absolute path.
 *
 * @param string $path the path want to check
 *
 * @return bool
 */
public static function isAbsolute($path);
```

**Example:**

```php
$return = Path::isAbsolute('/home/www/public_html');      // true
$return = Path::isAbsolute('sample/../path');             // false
$return = Path::isAbsolute('D:\\home\\www\\public_html'); // true
$return = Path::isAbsolute('sample\\..\\path');           // false
```

#### Check the relative form

**Syntax:**

```php
/**
 * Check if a given path is a relative path.
 *
 * @param string $path the path want to check
 *
 * @return bool
 */
public static function isRelative($path);
```

**Example:**

```php
$return = Path::isRelative('/home/www/public_html');      // false
$return = Path::isRelative('sample/../path');             // true
$return = Path::isRelative('D:\\home\\www\\public_html'); // false
$return = Path::isRelative('sample\\..\\path');           // true
```

### Check the mutual wrapping of paths

#### Check if the path is ancestor of another

**Syntax:**

```php
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
public static function isAncestor($path, $comparison);
```

**Example:**

```php
$return = Path::isAncestor('/home/www', '/home/www/public/assets/css/../images/sample.png');     // true
$return = Path::isAncestor('/home/www', '/another_home/public/assets/css/../images/sample.png'); // false
```

#### Check if the path is descendant of another

**Syntax:**

```php
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
public static function isDescendant($path, $comparison);
```

**Example:**

```php
$return = Path::isDescendant('/home/www/public/assets/css/../images/sample.png', '/home/www');     // true
$return = Path::isDescendant('/another_home/public/assets/css/../images/sample.png', '/home/www'); // false
```

## Available functions
This package contains several built-in `functions` to alternative using the `methods` of the `Path` class. However, the use of these functions is `not recommended`, because they may conflict with the functions of other packages.

| Function               | Class method           |
| ---------------------- | ---------------------- |
| *absolute_path()*      | *Path::absolute()*     |
| *relative_path()*      | *Path::relative()*     |
| *winstyle_path()*      | *Path::winStyle()*     |
| *unixstyle_path()*     | *Path::unixStyle()*    |
| *osstyle_path()*       | *Path::osStyle()*      |
| *normalize_path()*     | *Path::normalize()*    |
| *is_absolute_path()*   | *Path::isAbsolute()*   |
| *is_relative_path()*   | *Path::isRelative()*   |
| *is_descendant_path()* | *Path::isDescendant()* |
| *is_ancestor_path()*   | *Path::isAncestor()*   |

# License
[MIT](https://github.com/JackieDo/Path-Helper/blob/master/LICENSE) © Jackie Do
