<?php

namespace WpOptionsManager;

class PluginMeta {

  public $optionsKey;
  public $defaultOptions;
  public $slug;

  function getSlug() {
    return $this->slug;
  }

  function getOptionsKey() {
    return $this->optionsKey;
  }

  function getOptionsCapability() {
    return $this->optionsCapability;
  }

  function getDefaultOptions() {
    return $this->defaultOptions;
  }

  function getOptionsUrl() {
    return admin_url(
      'options-general.php?page=' . $this->getSlug()
    );
  }

}
