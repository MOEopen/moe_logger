Logging
=======

Logger for PHP (PSR-3)

Usage
-----

```php
<?php
  $moe_logger_file   = oxNew( 'moe_logger_file', 100, 'data/backup/log/TestLog.csv' );
  $moe_logger_screen = oxNew( 'moe_logger_screen', 200 );

  $moe_logger = oxNew( 'moe_logger_composite' );
  $moe_logger->addLogger( $moe_logger_file );
  $moe_logger->addLogger( $moe_logger_screen );

  $moe_logger->formatOutput('[', ']', '', ':');
  // $moe_logger_screen->formatOutput('[', ']', '', ':', '<br>');
  // $moe_logger_screen->setContextPretty( true );
  $moe_logger_screen->setOutputMultiline( true );

  $moe_logger->emergency('The Loglevel is {loglevel}.', array('loglevel' => 'emergency'));
  $moe_logger->alert('The Loglevel is {loglevel}.', array('loglevel' => 'alert'));
  $moe_logger->critical('The Loglevel is {loglevel}.', array('loglevel' => 'critical'));
  $moe_logger->error('The Loglevel is {loglevel}.', array('loglevel' => 'error'));
  $moe_logger->warning('The Loglevel is {loglevel}.', array('loglevel' => 'warning'));
  $moe_logger->notice('The Loglevel is {loglevel}.', array('loglevel' => 'notice'));
  $moe_logger->info('The Loglevel is {loglevel}.', array('loglevel' => 'info'));
  $moe_logger->debug('The Loglevel is {loglevel}.', array('loglevel' => 'debug'));

  $logs = $moe_logger->execute();
  echo $logs['moe_logger_screen'];
?>
```

This will output:
```
[Time:2014-06-30 15:57:55][Level:emergency][Message:The Loglevel is emergency.][Context:{"loglevel":"emergency"}]
[Time:2014-06-30 15:57:55][Level:alert][Message:The Loglevel is alert.][Context:{"loglevel":"alert"}]
[Time:2014-06-30 15:57:55][Level:critical][Message:The Loglevel is critical.][Context:{"loglevel":"critical"}]
[Time:2014-06-30 15:57:55][Level:error][Message:The Loglevel is error.][Context:{"loglevel":"error"}]
[Time:2014-06-30 15:57:55][Level:warning][Message:The Loglevel is warning.][Context:{"loglevel":"warning"}]
[Time:2014-06-30 15:57:55][Level:notice][Message:The Loglevel is notice.][Context:{"loglevel":"notice"}]
[Time:2014-06-30 15:57:55][Level:info][Message:The Loglevel is info.][Context:{"loglevel":"info"}]
```

Verfügbare Logger
------------------

Screen Logger:
```php
  $moe_logger_screen = oxNew( 'moe_logger_screen', 200 );
```
Der zweite Parameter (erforderlich) setzt den mindest Loglevel (Definition siehe unten)

File Logger:
```php
  $moe_logger_file   = oxNew( 'moe_logger_file', 100, 'data/backup/log/TestLog.csv' );
```
Der dritte Parameter setzt den Pfad und den Namen der Logdatei relativ zum Shoproot

Beide können zu einer Einheit zusammen gefügt werden, so dass beide Logger über einem Befehl angesprochen werden können.
```php
  $moe_logger = oxNew( 'moe_logger_composite' );
  $moe_logger->addLogger( $moe_logger_file );
  $moe_logger->addLogger( $moe_logger_screen );
```

Loglevel als Zahl um einen mindest Loglevel für den einzelnen Logger zu setzen.
```php
  const iEMERGENCY = 800;
  const iALERT     = 700;
  const iCRITICAL  = 600;
  const iERROR     = 500;
  const iWARNING   = 400;
  const iNOTICE    = 300;
  const iINFO      = 200;
  const iDEBUG     = 100;
```
