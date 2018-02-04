<?php

namespace Controller;

use Core\InputParameters;

class HomeController implements ControllerInterface {
    public function run(): array {
        $username = InputParameters::get('username');
        $fromDate = InputParameters::get('fromDate');
        $toDate = InputParameters::get('toDate');

        if($username && $fromDate && $toDate) {
            header('Location: /' . urlencode($username) . '/' . $fromDate . '/' . $toDate);
            exit();
        }

        return [];
    }
}