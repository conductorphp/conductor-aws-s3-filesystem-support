Conductor: AWS S3 Filesystem Support
===============================================

This module adds support for the AWS S3 filesystem in the   
[Conductor](https://github.com/conductorphp/conductor-core).

## Config

```php

<?php

return [
    'filesystem' => [
        'adapters' => [
            'aws_s3_test' => [
                'class' => \League\Flysystem\AwsS3v3\AwsS3Adapter::class,
                'arguments' => [
                    'client' => [
                        'credentials' => [
                            'key' => 'myaccesskey',
                            'secret' => 'mysecretkey',
                        ],
                        'region' => 'us-east-1',
                        'version' => '2006-03-01',
                    ],
                    'bucket' => 'mybucket',
                    'prefix' => '',
                    'options' => [],
                ],
            ],
        ],
    ],
];
```
