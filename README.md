[![Latest Stable Version](https://poser.pugx.org/pmvc-plugin/dotenv/v/stable)](https://packagist.org/packages/pmvc-plugin/dotenv)
[![Latest Unstable Version](https://poser.pugx.org/pmvc-plugin/dotenv/v/unstable)](https://packagist.org/packages/pmvc-plugin/dotenv)
[![CircleCI](https://circleci.com/gh/pmvc-plugin/dotenv/tree/main.svg?style=svg)](https://circleci.com/gh/pmvc-plugin/dotenv/tree/main)
[![License](https://poser.pugx.org/pmvc-plugin/dotenv/license)](https://packagist.org/packages/pmvc-plugin/dotenv)
[![Total Downloads](https://poser.pugx.org/pmvc-plugin/dotenv/downloads)](https://packagist.org/packages/pmvc-plugin/dotenv)

# PMVC Dot Env plugin

## Comment

-   Need use ;
-   http://php.net/manual/en/function.parse-ini-file.php#refsect1-function.parse-ini-file-examples

```
; This is a sample configuration file
; Comments start with ';', as in php.ini
```

## Reserved special characters

-   Characters ?{}|&~![()^" must not be used anywhere in the key and have a special meaning in the value.
-   http://php.net/manual/en/function.parse-ini-string.php

```
?{}|&~![()^"
```

## Install with Composer

<details><summary>CLICK TO SEE</summary><p>
### 1. Download composer
   * mkdir test_folder
   * curl -sS https://getcomposer.org/installer | php

### 2. Install Use composer.json or use command-line directly

#### 2.1 Install Use composer.json

-   vim composer.json

```
{
    "require": {
        "pmvc-plugin/dotenv": "dev-main"
    }
}
```

-   php composer.phar install

#### 2.2 Or use composer command-line

-   php composer.phar require pmvc-plugin/dotenv

or

-   composer require pmvc-plugin/dotenv

</p></details>
