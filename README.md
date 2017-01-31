### Permafrost Templated Text
---
Basic text templating for PHP 5+.

---

#### Installation
Install with composer:
	`composer require patinthehat/templated-text`

#### Sample Usage
```php
<?php

//if not using composer...
include('src/TemplatedText.php');

//if using composer...
include('vendor/autoload.php');


$tt = new Permafrost\TemplatedText;
$tt ->withTemplate('This is a {{test2}} template! {{testvar}} {{hello}}! ABC.')
    ->replacement('hello', 'HELLO WORLD')
    ->replacement('test2', function($v) { return strtoupper($v); })
    ->replacement('testvar', function($v) { return false; });


    echo $tt->process() . PHP_EOL . PHP_EOL;
```

#### Sample Output

`This is a TEST2 template! {{testvar}} HELLO WORLD! ABC.`


#### Notes
 - Note that `{{testvar}}` was not replaced, because its callback returned false.

 
#### License
This project is licensed under the [MIT License](LICENSE).
  