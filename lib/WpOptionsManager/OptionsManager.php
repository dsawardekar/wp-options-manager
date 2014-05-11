<?php

namespace WpOptionsManager;

class OptionsManager {

  function __construct($container) {
    $container
      ->singleton('optionsStore', 'WpOptionsManager\OptionsStore')
      ->singleton('optionsFlash', 'WpOptionsManager\OptionsFlash')
      ->singleton('optionsPostHandler', 'WpOptionsManager\OptionsPostHandler')
      ->singleton('twigHelper', 'WpTwigHelper\TwigHelper');

    $container->initializer('twigHelper', array($this, 'initializeTwig'));
  }

  function initializeTwig($twigHelper, $container) {
    $pluginMeta = $container->lookup('pluginMeta');
    $twigHelper->setBaseDir($pluginMeta->getDir());
  }

}
