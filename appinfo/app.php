<?php
namespace OCA\SkeletonManagement\AppInfo;

use OCP\AppFramework\App;
use OCP\IContainer;

class Application extends App {
    public function __construct(array $urlParams = []) {
        parent::__construct('skeleton_management', $urlParams);
    }

    public function register(IContainer $container) {
        $container->registerService('SkeletonController', function($c) {
            return new \OCA\SkeletonManagement\Controller\SkeletonController(
                $c->query('ServerContainer')->getAppName(),
                $c->query('Request'),
                $c->query('Config'),
                $c->query('UserSession')
            );
        });
    }
}
