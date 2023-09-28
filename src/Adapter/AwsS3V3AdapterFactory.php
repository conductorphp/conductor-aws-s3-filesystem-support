<?php

namespace ConductorAwsS3FilesystemSupport\Adapter;

use Aws\S3\S3Client;
use ConductorAwsS3FilesystemSupport\Exception;
use Laminas\ServiceManager\Factory\FactoryInterface;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;
use League\Flysystem\Visibility;
class AwsS3V3AdapterFactory implements FactoryInterface
{
    public function __invoke(\Psr\Container\ContainerInterface $container, $requestedName, ?array $config = []): AwsS3V3Adapter
    {
        $this->validateOptions($config);

        $client = new S3Client($config['client']);
        $bucket = $config['bucket'];
        $prefix = $config['prefix'] ?? '';
        $options = $config['options'] ?? [];
        $visibility = new PortableVisibilityConverter($config['visibility'] ?? Visibility::PRIVATE);
        unset($options['visibility']);
        return new AwsS3V3Adapter($client, $bucket, $prefix, $visibility, null, $options);
    }

    /**
     * @throws Exception\InvalidArgumentException if options are invalid
     */
    private function validateOptions(array $options): void
    {
        $requiredOptions = ['client', 'bucket'];
        $allowedOptions = ['client', 'bucket', 'prefix', 'options', 'visibility'];

        $missingRequiredOptions = array_diff($requiredOptions, array_keys($options));
        if ($missingRequiredOptions) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Missing %s constructor options: %s',
                    AwsS3V3Adapter::class,
                    implode(', ', $missingRequiredOptions)
                )
            );
        }

        $disallowedOptions = array_diff(array_keys($options), $allowedOptions);
        if ($disallowedOptions) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Invalid %s constructor options: %s',
                    AwsS3V3Adapter::class,
                    implode(', ', $disallowedOptions)
                )
            );
        }
    }
}
