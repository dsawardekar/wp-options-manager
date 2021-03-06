<?php

namespace WpOptionsManager;

use Valitron\Validator;

class OptionsValidator {

  public $validator;
  public $options;

  function build() {
    $this->loadCustomRules();

    $this->validator = new Validator($this->options);
    $this->loadRules($this->validator);
  }

  function validate($options = null) {
    if (is_null($options)) {
      $options = $_POST;
    }

    $this->options = $options;
    $this->build();

    return $this->validator->validate();
  }

  function errors() {
    return $this->validator->errors();
  }

  /* abstract */
  function loadRules($validator) {
    return;
  }

  function loadCustomRules() {
    return;
  }

}
