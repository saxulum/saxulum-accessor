<?php

namespace Saxulum\Tests\Accessor;

use Doctrine\Common\Persistence\Mapping\RuntimeReflectionService;
use Doctrine\Common\Proxy\ProxyGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Saxulum\Tests\Accessor\Fixtures\Entity\Entity;

class DoctrineTest extends \PHPUnit_Framework_TestCase
{
    public function testDoctrineProxy()
    {
        $className = 'Saxulum\Tests\Accessor\Fixtures\Entity\Entity';

        $proxyDirectory = __DIR__ . '/../proxy/';
        $proxyNamespace = 'Proxy';
        $proxyClassName = $proxyNamespace . '\__CG__\\' . $className;
        $proxyClassFilename = $proxyDirectory . str_replace('\\', '_', $proxyClassName) . '.php';

        if (!is_dir($proxyDirectory)) {
            mkdir($proxyDirectory, 0777, true);
        }

        $reflectionService = new RuntimeReflectionService();

        $classMetadata = new ClassMetadata(get_class(new Entity()));
        $classMetadata->initializeReflection($reflectionService);

        $proxyGenerator = new ProxyGenerator($proxyDirectory, $proxyNamespace);
        $proxyGenerator->generateProxyClass($classMetadata, $proxyClassFilename);

        require $proxyClassFilename;

        /** @var Entity $proxy */
        $proxy = new $proxyClassName();

        $proxy->setName('test');

        $this->assertEquals('test', $proxy->getName());

        unlink($proxyClassFilename);
        //rmdir($proxyDirectory);
    }
}
