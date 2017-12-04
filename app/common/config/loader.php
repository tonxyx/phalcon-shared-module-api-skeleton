<?php

// Use composer autoloader to load vendor classes
require_once BASE_PATH . '/vendor/autoload.php';

return [
  'PSMAS\Common\Library' => $this->config->application->libraryCommonDir,
  'PSMAS\Common\Models' => $this->config->application->modelsCommonDir,
  'PSMAS\Common\Forms' => $this->config->application->formsCommonDir,
];
