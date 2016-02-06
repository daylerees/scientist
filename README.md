[![Scientist](scientist.png)](https://packagist.org/packages/daylerees/scientist)

# Scientist

[![Build Status](https://travis-ci.org/daylerees/scientist.svg?branch=master)](https://travis-ci.org/daylerees/scientist)
[![Packagist Version](https://img.shields.io/packagist/v/daylerees/scientist.svg)](https://packagist.org/packages/daylerees/scientist)
[![HHVM Tested](https://img.shields.io/hhvm/daylerees/scientist.svg)](https://travis-ci.org/daylerees/scientist)
[![Packagist](https://img.shields.io/packagist/dt/daylerees/scientist.svg)](https://packagist.org/packages/daylerees/scientist)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/daylerees/scientist/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/daylerees/scientist/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/daylerees/scientist/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/daylerees/scientist/?branch=master)
[![Code Climate](https://codeclimate.com/github/daylerees/scientist/badges/gpa.svg)](https://codeclimate.com/github/daylerees/scientist)

A PHP experiment library inspired by Github's own [Scientist](https://github.com/github/scientist).

---

Scientist is an experimentation framework for PHP that will allow you to refactor and improve upon existing code in a live environment, without incurring risk or breakages.

Simply define an experiment, sit back, and let the results flow in.

```php
<?php

$experiment = (new Scientist\Laboratory)
  ->experiment('experiment title')
  ->control($controlCallback)
  ->trial('trial name', $trialCallback);

$value = $experiment->run();
```

A [more detailed description](https://scientist.readme.io/docs/introduction), and [full documentation](https://scientist.readme.io/) is available.
