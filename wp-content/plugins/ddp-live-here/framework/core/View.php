<?php

namespace ddp\live;

class View
{
  protected $viewPath;
  protected $cachePath;
  protected $engine;
  protected $extension = '.snipes.php';

  public function __construct()
  {
    $config = Config::get('global');
    $this->engine = new ViewEngine;
    $this->viewPath = __DIR__.'/../views';

    if (empty($config['cache_path'])) {
      throw new \Exception('Cache path is not set');
    }

    $this->cachePath = $config['cache_path'];

    if (! is_dir($this->cachePath)) {
      if (! mkdir($this->cachePath, 0755)) {
        throw new \Exception('Cache folder could not be created at '.$this->cachePath);
      }
    }
  }

  public function makeView($view, $data = array())
  {

    $templatePath = $this->parseTemplatePath($view);
    $fullPath = $this->viewPath.'/'.$templatePath.$this->extension;
    $templateName = basename($fullPath);

    if (!file_exists($fullPath)) {
      throw new \Exception('Template '.$templateName.' does not exist');
    }

    if (! file_exists($this->cachePath.'/'.md5($templateName)) ||
        ( filemtime($fullPath) >=
           filemtime($this->cachePath.'/'.md5($templateName)) ) ) {

      $this->cacheView($fullPath);
    }

    return $this->renderView(md5($templateName), $data);
  }

  public function cacheView($path)
  {

    $rendered = $this->compileTemplate($path);

    file_put_contents($this->cachePath.'/'.md5(basename($path)), $rendered);
  }

  public static function getView($view)
  {
    $parts = explode('.', $view);

    $i = Instance::get($parts[0].'_Controller');

    return $i->$parts[1]();
  }

  public function parseTemplatePath($template)
  {
    return preg_replace('/\./', '/', $template);
  }

  public function renderView($view, $data)
  {
    extract($data);

    $__view = $this;
    $__env = $this->engine;

    ob_start();
      require $this->cachePath.'/'.$view;
      $rendered = ob_get_contents();
    ob_end_clean();

    return $rendered;

  }

  public function compileTemplate($path)
  {
    return $this->engine->compile($path);
  }
}