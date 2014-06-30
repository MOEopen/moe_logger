Logging
=======

Logger for PHP (PSR-3)

Usage
-----

```php
<?php
  $moe_logger = oxNew( 'moe_logger_composite' );
  $moe_logger_file   = oxNew( 'moe_logger_file', 100, 'data/backup/log/TestLog.csv' );
  $moe_logger->addLogger( $moe_logger_file );

  $moe_logger_screen = oxNew( 'moe_logger_screen', 200 );
  $moe_logger->addLogger( $moe_logger_screen );

  $moe_logger->emergency('The Loglevel is {loglevel}.', array('loglevel' => 'emergency'));
  $moe_logger->alert('The Loglevel is {loglevel}.', array('loglevel' => 'alert'));
  $moe_logger->critical('The Loglevel is {loglevel}.', array('loglevel' => 'critical'));
  $moe_logger->error('The Loglevel is {loglevel}.', array('loglevel' => 'error'));
  $moe_logger->warning('The Loglevel is {loglevel}.', array('loglevel' => 'warning'));
  $moe_logger->notice('The Loglevel is {loglevel}.', array('loglevel' => 'notice'));
  $moe_logger->info('The Loglevel is {loglevel}.', array('loglevel' => 'info'));
  $moe_logger->debug('The Loglevel is {loglevel}.', array('loglevel' => 'debug'));
  $moe_logger->formatOutput('[', ']', '', ':');

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