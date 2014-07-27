## WP Options Manager [![Build Status](https://travis-ci.org/dsawardekar/wp-options-manager.svg?branch=develop)](https://travis-ci.org/dsawardekar/wp-options-manager)  [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dsawardekar/wp-options-manager/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/dsawardekar/wp-options-manager/?branch=develop)

Options API for WordPress

Deprecated. This repo has been merged into
[Arrow](https://github.com/dsawardekar/arrow).

# Usage

```php
$container->object('script', new \WpOptionsManager\OptionsManager($container));
$container->singleton('optionsValidator', 'MyOptionsValidator');
$container->singleton('optionsPage', 'MyOptionsPage');

class MyOptionsPage extends \WpOptionsManager\OptionsPage {

  function getTemplateContext() {
    return array(
      'foo' => $this->getOption('foo')
    );
  }

}

class MyOptionsValidator extends \WpOptionsManager\OptionsValidator {

  function loadRules($validator) {
    $validator->rule('required', 'foo');
    $validator->rule('length', 3);
    // more Valitron rules
  }

}
```
