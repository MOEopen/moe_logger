<?php

class moe_logger_screen extends moe_logger_abstract {
  public function execute() {
    return  $this->getLogAsString();
  }

  public function getName() {
    return __CLASS__;
  }

}