# Codeception Helper Module

[![Build Status](https://travis-ci.org/portrino/codeception-helper-module.svg?branch=master)](https://travis-ci.org/portrino/codeception-helper-module)
[![Maintainability](https://api.codeclimate.com/v1/badges/fd2055c9a44fd687926b/maintainability)](https://codeclimate.com/github/portrino/codeception-helper-module/maintainability)[![Maintainability](https://api.codeclimate.com/v1/badges/f3495eebb58cf8b50065/maintainability)](https://codeclimate.com/github/portrino/codeception-helper-module/maintainability)
[![Test Coverage](https://codeclimate.com/github/portrino/codeception-helper-module/badges/coverage.svg)](https://codeclimate.com/github/portrino/codeception-helper-module/coverage)
[![Test Coverage](https://api.codeclimate.com/v1/badges/fd2055c9a44fd687926b/test_coverage)](https://codeclimate.com/github/portrino/codeception-helper-module/test_coverage)
[![Issue Count](https://codeclimate.com/github/portrino/codeception-helper-module/badges/issue_count.svg)](https://codeclimate.com/github/portrino/codeception-helper-module)
[![Latest Stable Version](https://poser.pugx.org/portrino/codeception-helper-module/v/stable)](https://packagist.org/packages/portrino/codeception-helper-module)
[![Total Downloads](https://poser.pugx.org/portrino/codeception-helper-module/downloads)](https://packagist.org/packages/portrino/codeception-helper-module)

Collection of modules for codeception acceptance testing with TYPO3 and Shopware. You can use this module
as base for your codeception acceptance testsuite. It provides a set of modules, abstract page objects and 
interfaces to make acceptance testing a bit cleaner and easier in context of TYPO3 and Shopware.

## Installation

You need to add the repository into your composer.json file

```bash
composer require --dev portrino/codeception-helper-module
```

## Modules

You can use module(s) as any other codeception module, by adding '\Codeception\Module\Portrino\******' to the 
enabled modules in your codeception suite configurations.

### Database module

```yml
modules:
    enabled:
        - \Portrino\Codeception\Module\Database:
            depends: Db
            no_reset: true # do not reset database after testsuite
 ```  
 
Update codeception build
   
```bash
codecept build
```

### Methods

#### truncateTableInDatabase($table)

Truncates the ``$table``.

```php
  $I->truncateTableInDatabase($table);
```

#### deleteFromDatabase($table, $criteria)

Deletes the row(s) from ``$table`` matching the ``$criteria``

```php
$I->deleteFromDatabase($table, $criteria);
```

### TYPO3 module

```yml
modules:
    enabled:
        - \Portrino\Codeception\Module\Typo3:
            depends: Asserts
            domain: www.example.com
```  
 
Update codeception build
    
```bash
codecept build
```

### Methods

#### executeCommand

Executes the specified typo3_console ``$command``.

```php
$I->executeCommand($command, $arguments = [], $environmentVariables = [])
```

#### executeSchedulerTask

Executes tasks that are registered in the scheduler module.

```php
$I->executeSchedulerTask($taskId, $force = false, $environmentVariables = [])
```
#### flushCache

Flushes TYPO3 core caches first and after that, flushes caches from extensions.

```php
$I->flushCache($force = false, $filesOnly = false)
```

#### flushCacheGroups

Flushes all caches in specified groups. Valid group names are by default:
* all
* lowlevel
* pages
* system

```php
$I->flushCacheGroups($groups)
```

### Interfaces

You should use our constants defined in some interfaces to prevent typos and make refactoring easier.

#### TYPO3

* ``\Portrino\Codeception\Interfaces\DatabaseTables\Typo3Database``
* ``\Portrino\Codeception\Interfaces\Cookies\Typo3Cookie``
* ``\Portrino\Codeception\Interfaces\Commands\Typo3Command``

Example:
```php
  $I->seeInDatabase(
        \Portrino\Codeception\Interfaces\DatabaseTables\Typo3::PAGES,
        [
            'uid' => 123,
        ]
  );
```

#### Shopware

* ``\Portrino\Codeception\Interfaces\DatabaseTables\ShopwareDatabase``

```php
  $I->seeInDatabase(
        \Portrino\Codeception\Interfaces\DatabaseTables\Shopware::ARTICLE,
        [
            'id' => 123,
        ]
  );
```