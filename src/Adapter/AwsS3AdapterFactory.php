<?php

namespace DevopsToolAwsS3FilesystemSupport\Adapter;

use Aws\S3\S3Client;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use ReflectionClass;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

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
        $options['client'] = new S3Client($options['client']);
        unset($options['client']);
        $reflector = new ReflectionClass(AwsS3Adapter::class);
        return $reflector->newInstanceArgs($options);
    }
}
