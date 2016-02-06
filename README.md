[![Scientist](scientist.png)](https://packagist.org/packages/daylerees/scientist)

# Scientist

[![Build Status](https://travis-ci.org/daylerees/scientist.svg?branch=master)](https://travis-ci.org/daylerees/scientist)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/daylerees/scientist/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/daylerees/scientist/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/daylerees/scientist/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/daylerees/scientist/?branch=master)
[![Code Climate](https://codeclimate.com/github/daylerees/scientist/badges/gpa.svg)](https://codeclimate.com/github/daylerees/scientist)
[![HHVM Tested](https://img.shields.io/hhvm/daylerees/scientist.svg)](https://travis-ci.org/daylerees/scientist)

[![Packagist Version](https://img.shields.io/packagist/v/daylerees/scientist.svg)](https://packagist.org/packages/daylerees/scientist)
[![Packagist](https://img.shields.io/packagist/dt/daylerees/scientist.svg)](https://packagist.org/packages/daylerees/scientist)

A PHP experiment library inspired by Github's own [Scientist](https://github.com/github/scientist).

---

## Introduction

Scientist is an experimentation framework for PHP that will allow you to refactor and improve upon existing code in a live environment, without incurring risk or breakages.

Simply define an experiment, sit back, and let the results flow in.

```php
<?php

// We need a Laboratory to do science.
$experiment = (new Scientist\Laboratory)

    // Define an experiment with a name.
    ->experiment('experiment title')
    
    // Set a callback containing our control code.
    ->control($controlCallback)
    
    // Set a callback containing our trial code.
    ->trial('trial name', $trialCallback);

// Run the experiment, receiving the control return value.
$value = $experiment->run();
```

A [more detailed description](https://scientist.readme.io/docs/introduction), and [full documentation](https://scientist.readme.io/) is available.

## User Contributed Resources

Users of scientist contribute a variety of resources to enhance the functionality of the application.

### Journals

Journals allow experiment data to be sent to data stores for later inspection.

- [PSR-3 / Monolog](https://github.com/nikkobautista/scientist-psr3-journal) by [Nikko Bautista](https://github.com/nikkobautista). - *Write experiments to any PSR-3 compatible logger.*

### Bridges

Bridges allow for Scientist to be used seamlessly with other frameworks and libraries.

- [Laravel](https://github.com/daylerees/scientist-laravel) by [Dayle Rees](https://github.com/daylerees) - *Use Scientist with the Laravel PHP framework.*
- [Silex](https://packagist.org/packages/mauro-moreno/silex-scientist) by [Mauro Moreno](https://github.com/mauro-moreno) - *Use Scientist with the Silex micro-framework.*

### Matchers

Matchers allow for complex types to be matched.

- *None yet. [Would you like to build one?](CONTRIBUTING.md)*

### Interfaces

Interfaces allow for experiment data to be viewed in a clear way.

- *None yet. [Would you like to build one?](CONTRIBUTING.md)*
