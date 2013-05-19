<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
require_once dirname(__FILE__).'/../lib/autoload/SplClassLoader.php';
sfCoreAutoload::register();
$classLoader = new SplClassLoader('Zend', dirname(__FILE__).'/../lib/vendor/');
$classLoader->register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
  }
}
