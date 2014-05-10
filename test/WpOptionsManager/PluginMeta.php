<?php

namespace WpOptionsManager;

class PluginMeta {

  public $optionsKey;
  public $optionsCapability;
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

  function getOptionsPageTitle() {
    return $this->optionsPageTitle;
  }

  function getOptionsMenuTitle() {
    return $this->optionsMenuTitle;
  }

  function getOptionsPageSlug() {
    return $this->getSlug() . '-options';
  }

  function getOptionsMenuSlug() {
    return $this->getSlug();
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
