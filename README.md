### Permafrost Templated Text
---
Basic text templating for PHP 5+.

---

#### Installation
Install with composer:
	`composer require patinthehat/templated-text`

---

#### Sample Usage
```php
<?php

include 'vendor/autoload.php';

use Permafrost\TemplatedText\TemplatedText;

$tt = new TemplatedText;

$tt ->variable('one', 'OONNEE')
    ->variable('hw', 'Hello World')
    ->filter('test', function($v) { return '->>'.$v.'<<-'; })
    ->template('This is a test template, one is {{one|aquote}} and {{hw}}! then, {{hw | quote | test}}!! and {{one | quote}} ');

echo $tt->process() . PHP_EOL . PHP_EOL;
```

---

#### Sample Output

`This is a test template, one is ->OONNEE<- and Hello World! then, ->>"Hello World"<<-!! and "OONNEE"`


---

#### License
This project is licensed under the [MIT License](LICENSE).
  