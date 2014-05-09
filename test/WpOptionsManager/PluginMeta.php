<?php

namespace WpOptionsManager;

class PluginMeta {

  public $optionsKey;
  public $defaultOptions;

  function getOptionsKey() {
    return $this->optionsKey;
  }

  function getDefaultOptions() {
    return $this->defaultOptions;
  }

}
