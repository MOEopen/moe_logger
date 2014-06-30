<?php

class moe_logger_composite {
  protected $loggers = array();
  
  public function addLogger($logger) {
    $this->loggers[] = $logger;
  }

  public function execute() {
    $Ret = array();
    foreach ($this->loggers as $logger) {
      $_ret = $logger->execute();
      if( !empty( $_ret ) ) $Ret[$logger->getName()] = $_ret;
    }
    return $Ret;
  }
  
  public function formatOutput( $sOutputLeftDelimitter, $sOutputRightDelimitter, $sOutputFieldSepatator, $sOutputKeySeparator = '', $sOutputNewline = null ) {
    foreach ($this->loggers as $logger) {
      $logger->formatOutput( $sOutputLeftDelimitter, $sOutputRightDelimitter, $sOutputFieldSepatator, $sOutputKeySeparator, $sOutputNewline ) ;
    }
  }
  
  public function emergency($message, array $context = array()) {
    foreach ($this->loggers as $logger) {
      $logger->emergency($message, $context) ;
    }
  }
  
  public function alert($message, array $context = array()) {
    foreach ($this->loggers as $logger) {
      $logger->alert($message, $context) ;
    }
  }
  
  public function critical($message, array $context = array()) {
    foreach ($this->loggers as $logger) {
      $logger->critical($message, $context) ;
    }
  }
  
  public function error($message, array $context = array()) {
    foreach ($this->loggers as $logger) {
      $logger->error($message, $context) ;
    }
  }
  
  public function warning($message, array $context = array()) {
    foreach ($this->loggers as $logger) {
      $logger->warning($message, $context) ;
    }
  }
  
  public function notice($message, array $context = array()) {
    foreach ($this->loggers as $logger) {
      $logger->notice($message, $context) ;
    }
  }
  
  public function info($message, array $context = array()) {
    foreach ($this->loggers as $logger) {
      $logger->info($message, $context) ;
    }
  }
  
  public function debug($message, array $context = array()) {
    foreach ($this->loggers as $logger) {
      $logger->debug($message, $context) ;
    }
  }
  
  // public function __call($name, $arguments) {
    // foreach( $this->loggers as $logger ) {
      // if( empty( $arguments ) ) {
        // $logger->$name( );
      // } else {
        // $logger->$name( $arguments );
      // }
    // }
  // }
  
}