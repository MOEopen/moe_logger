<?php

abstract class moe_logger_abstract {
  
  const EMERGENCY = 'emergency';
  const ALERT     = 'alert';
  const CRITICAL  = 'critical';
  const ERROR     = 'error';
  const WARNING   = 'warning';
  const NOTICE    = 'notice';
  const INFO      = 'info';
  const DEBUG     = 'debug';
  
  const iEMERGENCY = 800;
  const iALERT     = 700;
  const iCRITICAL  = 600;
  const iERROR     = 500;
  const iWARNING   = 400;
  const iNOTICE    = 300;
  const iINFO      = 200;
  const iDEBUG     = 100;
  
  protected $iMinLoglevel = 300;
  
  protected $aMessages = array();
  
  protected $sOutputLeftDelimitter  = '[';
  protected $sOutputRightDelimitter = ']';
  protected $sOutputFieldSepatator  = ' ';
  protected $sOutputNewline         = "\n";
  protected $sOutputKeySeparator    = ':';
  protected $bOutputContextPretty   = false;
  protected $bOutputMultiline       = false;
  
  abstract public function execute();

  abstract public function getName();
  
  public function __construct( $iMinLoglevel ) {
    if( !empty( $iMinLoglevel ) ) $this->iMinLoglevel = $iMinLoglevel;
  }
    
  public function getLogAsString()
  {
    if( $this->getOutputMultiline() === true ) {
      $ret  = "<pre>".$this->sOutputNewline;
      $ret .= print_r( $this->getLog(), true );
      $ret .= "<pre>".$this->sOutputNewline;
      return $ret;
    }
    $sLog = "";
    foreach( $this->getLog() as $aMessage) {
      foreach( $aMessage as $Key=>$Value) {
        $sLog .= $this->sOutputLeftDelimitter;
        if( $this->sOutputWithKey === true ) $sLog .= $Key . $this->sOutputKeySeparator;
        $sLog .= $Value;
        $sLog .= $this->sOutputRightDelimitter;
        $sLog .= $this->sOutputFieldSepatator;
      }
      $sLog .= $this->sOutputNewline;
    }
    return $sLog;
  }
  
  public function formatOutput( $sOutputLeftDelimitter, $sOutputRightDelimitter, $sOutputFieldSepatator, $sOutputKeySeparator = '', $sOutputNewline = null ) {
    $this->sOutputLeftDelimitter = $sOutputLeftDelimitter;
    $this->sOutputRightDelimitter = $sOutputRightDelimitter;
    $this->sOutputFieldSepatator = $sOutputFieldSepatator;
    if( !empty( $sOutputKeySeparator ) ) {
      $this->sOutputKeySeparator = $sOutputKeySeparator;
      $this->sOutputWithKey = true;
    } else {
      $this->sOutputWithKey = false;
    }
    if( !empty( $sOutputNewline ) ) $this->sOutputNewline = $sOutputNewline;
  }
  
  public function setOutputMultiline( $bFlag ) {
    $this->bOutputMultiline = $bFlag;
  }
  
  public function getOutputMultiline( ) {
    return $this->bOutputMultiline;
  }
  
  public function setContextPretty( $bFlag ) {
    $this->bOutputContextPretty = $bFlag;
  }
  
  public function getContextPretty( ) {
    return $this->bOutputContextPretty;
  }
  
  public function getLog() {
    if( empty( $this->aMessages ) ) {
      return false;
    }
    foreach( $this->aMessages as $aMessage ) {
      if( $this->getIndexLoglevel( $aMessage['Level'] ) >= $this->getMinLoglevel() ) {
        $aLog[] = $aMessage;
      }
    }
    return $aLog;
  }
  
  public function setMinLoglevel( $iMinLoglevel ) {
    $this->iMinLoglevel = $iMinLoglevel;
  }
  
  public function getMinLoglevel() {
    return $this->iMinLoglevel;
  }
  
  protected function getIndexLoglevel( $level ) {
    switch( $level ) {
      case self::EMERGENCY:
        return self::iEMERGENCY;
        break;
      case self::ALERT:
        return self::iALERT;
        break;
      case self::CRITICAL:
        return self::iCRITICAL;
        break;
      case self::ERROR:
        return self::iERROR;
        break;
      case self::WARNING:
        return self::iWARNING;
        break;
      case self::NOTICE:
        return self::iNOTICE;
        break;
      case self::INFO:
        return self::iINFO;
        break;
      case self::DEBUG:
        return self::iDEBUG;
        break;
      default:
        return $this->getMinLoglevel();
    }
  }

  /**
   * Logs with an arbitrary level.
   *
   * @param mixed $level
   * @param string $message
   * @param array $context
   * @return null
   */
  public function log($level, $message, array $context = array())
  {
    $_aMessage = array( 'Time'    => date('Y-m-d H:i:s'),
                        'Level'   => $level,
                        'Message' => $this->interpolate($message, $context),
                        'Context' => json_encode( $context ),
                       );
    if( $this->getContextPretty() === true ) {
      $_aMessage['Context'] = $this->sOutputNewline . print_r( $context, true );
    }
    if( $this->getOutputMultiline( ) === true ) {
      $_aMessage['Context'] = $context;
    }
    $this->aMessages[] = $_aMessage;
  }
  
  public function emergency($message, array $context = array())
  {
    $this->log(self::EMERGENCY, $message, $context);
  }

  /**
   * Action must be taken immediately.
   *
   * Example: Entire website down, database unavailable, etc. This should
   * trigger the SMS alerts and wake you up.
   *
   * @param string $message
   * @param array $context
   * @return null
   */
  public function alert($message, array $context = array())
  {
    $this->log(self::ALERT, $message, $context);
  }


  /**
   * Critical conditions.
   *
   * Example: Application component unavailable, unexpected exception.
   *
   * @param string $message
   * @param array $context
   * @return null
   */
  public function critical($message, array $context = array())
  {
    $this->log(self::CRITICAL, $message, $context);
  }


  /**
   * Runtime errors that do not require immediate action but should typically
   * be logged and monitored.
   *
   * @param string $message
   * @param array $context
   * @return null
   */
  public function error($message, array $context = array())
  {
    $this->log(self::ERROR, $message, $context);
  }


  /**
   * Exceptional occurrences that are not errors.
   *
   * Example: Use of deprecated APIs, poor use of an API, undesirable things
   * that are not necessarily wrong.
   *
   * @param string $message
   * @param array $context
   * @return null
   */
  public function warning($message, array $context = array())
  {
    $this->log(self::WARNING, $message, $context);
  }


  /**
   * Normal but significant events.
   *
   * @param string $message
   * @param array $context
   * @return null
   */
  public function notice($message, array $context = array())
  {
    $this->log(self::NOTICE, $message, $context);
  }


  /**
   * Interesting events.
   *
   * Example: User logs in, SQL logs.
   *
   * @param string $message
   * @param array $context
   * @return null
   */
  public function info($message, array $context = array())
  {
    $this->log(self::INFO, $message, $context);
  }


  /**
   * Detailed debug information.
   *
   * @param string $message
   * @param array $context
   * @return null
   */
  public function debug($message, array $context = array())
  {
    $this->log(self::DEBUG, $message, $context);
  }
    
  /**
  * Interpolates context values into the message placeholders.
  */
  protected function interpolate($message, array $context = array())
  {
    // build a replacement array with braces around the context keys
    $replace = array();
    foreach ($context as $key => $val) {
      $replace['{' . $key . '}'] = $val;
    }

    // interpolate replacement values into the message and return
    return strtr($message, $replace);
  }

}