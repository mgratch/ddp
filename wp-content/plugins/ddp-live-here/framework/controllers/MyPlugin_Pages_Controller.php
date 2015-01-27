<?php
use sixlabs\sl_framework\Controller as Controller;

class MyPlugin_Pages_Controller extends Controller
{
  public function actions()
  {
    var_dump('actions called');
  }
}