<?php

namespace WpOptionsManager;

require_once __DIR__ . '/MyOptionsValidator.php';

use Valitron\Validator;

class OptionsValidatorTest extends \WP_UnitTestCase {

  public $validator;

  function setUp() {
    parent::setUp();

    $this->validator = new MyOptionsValidator();
  }

  function test_it_knows_if_input_is_not_valid() {
    $rules = [
        'required' => [
            ['foo'],
            ['bar']
        ],
        'length' => [
            ['foo', 3]
        ]
    ];

    $this->validator->rules = $rules;
    $result = $this->validator->validate([]);
    $this->assertFalse($result);
  }

  function test_it_knows_if_input_is_valid() {
    $rules = [
        'required' => [
            ['foo'],
            ['bar']
        ],
        'length' => [
            ['foo', 3]
        ]
    ];

    $input = [
      'foo' => 'lor',
      'bar' => 'yes'
    ];

    $this->validator->rules = $rules;
    $result = $this->validator->validate($input);
    $this->assertTrue($result);
  }

  function test_it_has_errors_if_input_is_not_valid() {
    $input = [
      'bar' => 'two'
    ];

    $rules = [
        'required' => [
            ['foo'],
            ['bar']
        ]
    ];

    $this->validator->rules = $rules;
    $result = $this->validator->validate($input);
    $errors = $this->validator->errors();
    $this->assertEquals('Foo is required', $errors['foo'][0]);
  }

  function test_it_can_use_custom_rules() {
    $rules = [
      'customRule' => [
        ['foo']
      ]
    ];

    $this->validator->rules = $rules;
    $input = ['foo' => 'foo'];
    $result = $this->validator->validate($input);
    $this->assertTrue($result);
  }

}
