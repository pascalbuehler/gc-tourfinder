<?php

namespace Controller;

use Core\InputParameters;
use Helper\ConfigHelper;

class HomeController implements ControllerInterface {
    public function run(): array {
        return [
            'config' => ConfigHelper::getConfig()
        ];
    }
}