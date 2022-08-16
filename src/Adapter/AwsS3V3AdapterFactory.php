<?php

namespace ConductorAwsS3FilesystemSupport\Adapter;

use Aws\S3\S3Client;
use ConductorAwsS3FilesystemSupport\Exception;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;

class AwsS3V3AdapterFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     *
     * @return AwsS3V3Adapter
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): AwsS3V3Adapter
    {
        $this->validateOptions($options);

        $client = new S3Client($options['client']);
        $bucket = $options['bucket'];
        $prefix = $options['prefix'] ?? '';
        $options = $options['options'] ?? [];
        return new AwsS3V3Adapter($client, $bucket, $prefix, null, null, $options);
    }

    /**
     * @param array $options
     *
     * @throws Exception\InvalidArgumentException if options are invalid
     */
    private function validateOptions(array $options): void
    {
        $requiredOptions = ['client', 'bucket'];
        $allowedOptions = ['client', 'bucket', 'prefix', 'options'];

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
