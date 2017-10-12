# Codeception Helper Module

[![Build Status](https://travis-ci.org/portrino/codeception-helper-module.svg?branch=master)](https://travis-ci.org/portrino/codeception-helper-module)
[![Maintainability](https://api.codeclimate.com/v1/badges/fd2055c9a44fd687926b/maintainability)](https://codeclimate.com/github/portrino/codeception-helper-module/maintainability)[![Maintainability](https://api.codeclimate.com/v1/badges/f3495eebb58cf8b50065/maintainability)](https://codeclimate.com/github/portrino/codeception-helper-module/maintainability)
[![Test Coverage](https://codeclimate.com/github/portrino/codeception-helper-module/badges/coverage.svg)](https://codeclimate.com/github/portrino/codeception-helper-module/coverage)
[![Test Coverage](https://api.codeclimate.com/v1/badges/fd2055c9a44fd687926b/test_coverage)](https://codeclimate.com/github/portrino/codeception-helper-module/test_coverage)
[![Issue Count](https://codeclimate.com/github/portrino/codeception-helper-module/badges/issue_count.svg)](https://codeclimate.com/github/portrino/codeception-helper-module)
[![Latest Stable Version](https://poser.pugx.org/portrino/codeception-helper-module/v/stable)](https://packagist.org/packages/portrino/codeception-helper-module)
[![Total Downloads](https://poser.pugx.org/portrino/codeception-helper-module/downloads)](https://packagist.org/packages/portrino/codeception-helper-module)

Generic helper module for codeception acceptance testing

This package provides parsing and validation of sitemap.xml files

## Installation

You need to add the repository into your composer.json file

```bash
    composer require --dev portrino/codeception-helper-module
```

## Usage

You can use this module as any other Codeception module, by adding '\Codeception\Module\Portrino\Database' to the 
enabled modules in your codeception suite configurations.

### Enable database module

```yml
modules:
    enabled:
        - \Portrino\Codeception\Module\Database:
            depends: Db
            no_reset: true # do not reset database after testsuite
 ```  
 
### Enable typo3 module

 ```yml
modules:
    enabled:
        - \Portrino\Codeception\Module\Typo3:
            depends: Db
            domain: %CODECEPT_DOMAIN%
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

### Interfaces

You should use our constants for the database tables of the corresponding system for database operations.

#### TYPO3

``\Portrino\Codeception\Interfaces\DatabaseTables\Typo3``

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

``\Portrino\Codeception\Interfaces\DatabaseTables\Shopware``

```php
  $I->seeInDatabase(
        \Portrino\Codeception\Interfaces\DatabaseTables\Shopware::ARTICLE,
        [
            'id' => 123,
        ]
  );
```