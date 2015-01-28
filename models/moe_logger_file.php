<?php

class moe_logger_file extends moe_logger_abstract {
  protected $sFile;
  
  /*
   * Contructor
   * 
   * @
   */
  public function __construct( $iMinLoglevel, $File ) {
    parent::__construct( $iMinLoglevel );
    
    if (empty($this->oConfig))  $this->oConfig  = oxConfig::getInstance();
    if (empty($this->sShopDir)) $this->sShopDir = $this->oConfig->getConfigParam( 'sShopDir' );
    $this->setFile( $File );
  }
  
  public function execute() {
    $this->writeToFile();
  }
  
  protected function writeToFile() {
    @$fp = fopen( $this->sFile, 'a' );
    if( $fp === false ) {
      //tu was
    } else {
      $sMessages  = '--------------------------'.$this->sOutputNewline;
      $sMessages .= $this->getLogAsString();
      fputs( $fp, $sMessages);
      fclose( $fp );
    }
  }
  
  public function getName() {
    return __CLASS__;
  }

  protected function setFile( $sFile ) {
    $Path = $this->getPathAbs( dirname( $sFile ) );
    $aFileInfo = pathinfo( $sFile );
    $this->sFile = $Path . $aFileInfo['basename'];
    // echo $this->sFile;
  }

  public function getPathAbs($sFile){
    // Gibt validen Pfad zum Sicherungsverzeichnis zurück
    $this->sFile = $this->getPath($this->sShopDir.$sFile);
    $this->sFile = $this->getValidatePath($this->sFile);
    return  $this->sFile;
  }
  
  private function getPath($Path) {
    if (empty($Path)) die("Bei dem Aufruf der Funktion getParam() wurde kein Wert übergeben");
    
    // Versuche konischen (absoluten) Pfad zu erzeugen, falls der Pfad nicht existiert wird false zurückgegeben
    $_sPath = realpath($Path);
    
    // Wenn false, dann soll neuer Pfad angelegt werden. Falls das nicht möglich ist wird das Script abgebrochen
    if(!$_sPath)
    {
      if (!mkdir($Path, 0777, true)) die("<b>Fehler:</b> Das Importverzeichniss ".$Path." ist nicht vorhanden und kann nicht angelegt werden.");
      $_sPath = realpath($Path);
    }
    return $_sPath;
  }
  
  private function getValidatePath($Path) {
    //if (substr($Path, 0, 1) == "/")  $Path = substr($Path, 1, strlen($Path));
    if (substr($Path, -1) != "/") $Path = $Path."/";
    return $Path;
  }

  
}