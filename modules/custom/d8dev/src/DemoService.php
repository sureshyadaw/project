<?php

/**
 * @file
 * Contains Drupal\demo\DemoService.
 */

namespace Drupal\d8dev;

class DemoService {
  
  protected $demo_value;
  
  public function __construct() {
    $this->demo_value = 'Upchuk';
  }
  
  public function getDemoValue() {
    return $this->demo_value;
  }
  
}