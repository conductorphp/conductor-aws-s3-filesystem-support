<?php

namespace ConductorAwsS3FilesystemSupport\Adapter;

use Aws\S3\S3Client;
use ConductorAwsS3FilesystemSupport\Exception;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AwsS3AdapterFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     *
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $this->validateOptions($options);

        $client = new S3Client($options['client']);
        $bucket = $options['bucket'];
        $prefix = isset($options['prefix']) ? $options['prefix'] : '';
        $options = isset($options['options']) ? $options['options'] : [];
        return new AwsS3Adapter($client, $bucket, $prefix, $options);
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
                    AwsS3Adapter::class,
                    implode(', ', $missingRequiredOptions)
                )
            );
        }

        $disallowedOptions = array_diff(array_keys($options), $allowedOptions);
        if ($disallowedOptions) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Invalid %s constructor options: %s',
                    AwsS3Adapter::class,
                    implode(', ', $disallowedOptions)
                )
            );
        }
    }
}
