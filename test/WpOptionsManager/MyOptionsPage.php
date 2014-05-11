<?php

namespace WpOptionsManager;

class MyOptionsPage extends OptionsPage {

  public $templateName;
  public $templateContext;

  function getTemplateName() {
    return $this->templateName;
  }

  function getTemplateContext() {
    return $this->templateContext;
  }

}
