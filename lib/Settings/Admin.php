<?php
namespace OCA\SkeletonManagement\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;

class Admin implements ISettings {

    public function getForm() {
        return new TemplateResponse('skeleton_management', 'admin');
    }

    public function getSection() {
        return 'additional';
    }

    public function getPriority() {
        return 50;
    }
}
