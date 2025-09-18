<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DependencyInjection;

use Symfony\Bundle\MonologBundle\Tests\DependencyInjection\FixtureMonologExtensionTestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class XmlLegacyMonologExtensionTest extends FixtureMonologExtensionTestCase
{
    protected function loadFixture(ContainerBuilder $container, $fixture)
    {
        $container->setDefinition('mailer', new Definition('Swiftmailer'));

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/Fixtures/xml/legacy'));
        $loader->load($fixture.'.xml');
    }
}
