<?php

namespace ConductorAwsS3FilesystemSupport;

class ConfigProvider
{
    /**
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    private function getDependencies(): array
    {
        return require(__DIR__ . '/../config/dependencies.php');
    }

}
