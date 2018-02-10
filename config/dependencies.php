<?php

namespace ConductorAwsS3FilesystemSupport;

return [
    'factories' => [
        \League\Flysystem\AwsS3v3\AwsS3Adapter::class => Adapter\AwsS3AdapterFactory::class,
    ],
];
