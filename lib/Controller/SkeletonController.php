<?php
namespace OCA\SkeletonManagement\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\IConfig;
use OCP\IUserSession;

class SkeletonController extends Controller {
    private $config;
    private $userSession;

    public function __construct($AppName, IRequest $request, IConfig $config, IUserSession $userSession) {
        parent::__construct($AppName, $request);
        $this->config = $config;
        $this->userSession = $userSession;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function getSkeletonContents() {
        if (!$this->userSession->isAdminUser($this->userSession->getUser()->getUID())) {
            return new JSONResponse(['error' => 'Not authorized'], 403);
        }

        $skeletonDir = $this->config->getSystemValue('skeletondirectory', '/path/to/default/skeleton');
        $contents = scandir($skeletonDir);

        return new JSONResponse(['contents' => array_diff($contents, ['.', '..'])]);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function updateSkeletonContents($filename, $content) {
        if (!$this->userSession->isAdminUser($this->userSession->getUser()->getUID())) {
            return new JSONResponse(['error' => 'Not authorized'], 403);
        }

        $skeletonDir = $this->config->getSystemValue('skeletondirectory', '/path/to/default/skeleton');
        $filePath = $skeletonDir . '/' . $filename;

        try {
            file_put_contents($filePath, $content);
            return new JSONResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JSONResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function deleteSkeletonFile($filename) {
        if (!$this->userSession->isAdminUser($this->userSession->getUser()->getUID())) {
            return new JSONResponse(['error' => 'Not authorized'], 403);
        }

        $skeletonDir = $this->config->getSystemValue('skeletondirectory', '/path/to/default/skeleton');
        $filePath = $skeletonDir . '/' . $filename;

        try {
            if (is_file($filePath)) {
                unlink($filePath);
                return new JSONResponse(['success' => true]);
            } else {
                return new JSONResponse(['error' => 'File not found'], 404);
            }
        } catch (\Exception $e) {
            return new JSONResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function uploadSkeletonFile() {
        if (!$this->userSession->isAdminUser($this->userSession->getUser()->getUID())) {
            return new JSONResponse(['error' => 'Not authorized'], 403);
        }

        if (!isset($_FILES['file'])) {
            return new JSONResponse(['error' => 'No file uploaded'], 400);
        }

        $skeletonDir = $this->config->getSystemValue('skeletondirectory', '/path/to/default/skeleton');
        $filePath = $skeletonDir . '/' . $_FILES['file']['name'];

        try {
            move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
            return new JSONResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JSONResponse(['error' => $e->getMessage()], 500);
        }
    }
}
