<?php

class ioAdminHelpers extends ioAdmin\ioAdminBase\ioAdminBase
{

  public static function ioOptionKey()
  {
    $self = new ioAdmin\ioAdminBase\ioAdminBase;
    return $self->config['options_keys']['io-options'];
  }

  public static function getOptions()
  {
    return get_option(ioAdminHelpers::ioOptionKey());
  }

  public static function getSocial( $network = null ) {
    $options = get_option(ioAdminHelpers::ioOptionKey());

    if( !empty( $options['social-links']['social-'.$network] ) ) {
      return $options['social-links']['social-'.$network];
    } else {
      return $options['social-links'];
    }
  }

  public static function getCompany( $entry = null ) {
    $options = get_option(ioAdminHelpers::ioOptionKey());

    if( !empty( $options['company-info']['company-'.$entry] ) ) {
      return $options['company-info']['company-'.$entry];
    } else {
      return $options['company-info'];
    }
  }
}