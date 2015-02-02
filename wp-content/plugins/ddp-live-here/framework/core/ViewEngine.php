<?php

namespace ddp\live;

class ViewEngine
{

  protected $path;
  protected $contentTags = array('{{', '}}');
  protected $escapedTags = array('{{{', '}}}');
  protected $compilers = array(
    // 'Extensions',
    'Statements',
    'Comments',
    'Echos'
  );

  public function compile($path)
  {
    $this->path = $path;

    $contents = $this->process(file_get_contents($path));

    return $contents;
  }

  protected function process($content)
  {
    $result = '';

    // Here we will loop through all of the tokens returned by the Zend lexer and
    // parse each one into the corresponding valid PHP. We will then have this
    // template as the correctly rendered PHP that can be rendered natively.
    foreach (token_get_all($content) as $token) {
      $result .= is_array($token) ? $this->parseToken($token) : $token;
    }

    // If there are any footer lines that need to get added to a template we will
    // add them here at the end of the template. This gets used mainly for the
    // template inheritance via the extends keyword that should be appended.
    // if (count($this->footer) > 0) {
    //   $result = ltrim($result, PHP_EOL)
    //       .PHP_EOL.implode(PHP_EOL, array_reverse($this->footer));
    // }

    return $result;
  }

  protected function parseToken($token)
  {
    list($id, $content) = $token;

    if ($id == T_INLINE_HTML) {
      foreach ($this->compilers as $type) {
        $content = $this->{"compile{$type}"}($content);
      }
    }

    return $content;
  }

  protected function compileComments($value)
  {
    $pattern = sprintf('/%s--((.|\s)*?)--%s/', $this->contentTags[0], $this->contentTags[1]);

    return preg_replace($pattern, '<?php /*$1*/ ?>', $value);
  }

  protected function compileEchos($value)
  {
    $difference = strlen($this->contentTags[0]) - strlen($this->escapedTags[0]);

    if ($difference > 0)
    {
      return $this->compileEscapedEchos($this->compileRegularEchos($value));
    }

    return $this->compileRegularEchos($this->compileEscapedEchos($value));
  }

  protected function compileStatements($value)
  {
    $callback = function($match)
    {
      if (method_exists($this, $method = 'compile'.ucfirst($match[1]))) {
        $match[0] = $this->$method($this->arrGet($match, 3));
      }

      return isset($match[3]) ? $match[0] : $match[0].$match[2];
    };

    return preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', $callback, $value);
  }

  protected function compileRegularEchos($value)
  {
    $pattern = sprintf('/(@)?%s\s*(.+?)\s*%s(\r?\n)?/s', $this->contentTags[0], $this->contentTags[1]);

    $callback = function($matches)
    {
      $whitespace = empty($matches[3]) ? '' : $matches[3].$matches[3];

      return $matches[1] ? substr($matches[0], 1) : '<?php echo '.$this->compileEchoDefaults($matches[2]).'; ?>'.$whitespace;
    };

    return preg_replace_callback($pattern, $callback, $value);
  }

  protected function compileEscapedEchos($value)
  {
    $pattern = sprintf('/%s\s*(.+?)\s*%s(\r?\n)?/s', $this->escapedTags[0], $this->escapedTags[1]);

    $callback = function($matches)
    {
      $whitespace = empty($matches[2]) ? '' : $matches[2].$matches[2];

      return '<?php echo e('.$this->compileEchoDefaults($matches[1]).'); ?>'.$whitespace;
    };

    return preg_replace_callback($pattern, $callback, $value);
  }

  public function compileEchoDefaults($value)
  {
      return preg_replace('/^(?=\$)(.+?)(?:\s+or\s+)(.+?)$/s', 'isset($1) ? $1 : $2', $value);
  }

  protected function compileUnless($expression)
  {
      return "<?php if ( ! $expression): ?>";
  }

  protected function compileEndunless($expression)
  {
      return "<?php endif; ?>";
  }

  protected function compileElse($expression)
  {
      return "<?php else: ?>";
  }

  protected function compileFor($expression)
  {
    return "<?php for{$expression}: ?>";
  }

  protected function compileForeach($expression)
  {
    return "<?php foreach{$expression}: ?>";
  }

  protected function compileForelse($expression)
  {
    $empty = '$__empty_' . ++$this->forelseCounter;

    return "<?php {$empty} = true; foreach{$expression}: {$empty} = false; ?>";
  }

  protected function compileIf($expression)
  {
    return "<?php if{$expression}: ?>";
  }

  protected function compileElseif($expression)
  {
    return "<?php elseif{$expression}: ?>";
  }

  protected function compileEmpty($expression)
  {
    $empty = '$__empty_' . $this->forelseCounter--;

    return "<?php endforeach; if ({$empty}): ?>";
  }

  protected function compileWhile($expression)
  {
    return "<?php while{$expression}: ?>";
  }

  protected function compileEndwhile($expression)
  {
    return "<?php endwhile; ?>";
  }

  protected function compileEndfor($expression)
  {
    return "<?php endfor; ?>";
  }

  protected function compileEndforeach($expression)
  {
    return "<?php endforeach; ?>";
  }

  protected function compileEndif($expression)
  {
    return "<?php endif; ?>";
  }

  protected function compileEndforelse($expression)
  {
    return "<?php endif; ?>";
  }

  public function arrGet($array, $key, $default = null)
  {
    if (is_null($key)) return $array;

    if (isset($array[$key])) return $array[$key];

    foreach (explode('.', $key) as $segment)
    {
      if ( ! is_array($array) || ! array_key_exists($segment, $array))
      {
        return $default;
      }

      $array = $array[$segment];
    }

    return $array;
  }
}