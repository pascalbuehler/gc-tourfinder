<?php

namespace Core;

use Controller\ControllerInterface;
use Helper\ApiHelper;
use Helper\ConfigHelper;
use Layout\Layout;

class PageRenderer {
    public static function render($page) {
        if(!$page) {
            throw new \Exception('No page to render');
        }

        // Controller
        $controllerName = 'Controller\\'.ucfirst($page).'Controller';
        /** @var ControllerInterface $controller */
        $controller = new $controllerName;
        $data = $controller->run();

        // Layout
        $layout = new Layout('home', $data);
        $layout->render();
    }
}

