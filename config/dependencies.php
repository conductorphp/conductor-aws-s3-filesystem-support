<?php

namespace ConductorAwsS3FilesystemSupport;

return [
    'factories' => [
        \League\Flysystem\AwsS3V3\AwsS3V3Adapter::class => Adapter\AwsS3V3AdapterFactory::class,
    ],
];
