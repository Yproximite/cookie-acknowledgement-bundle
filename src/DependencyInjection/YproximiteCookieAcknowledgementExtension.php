<?php

declare(strict_types=1);

namespace Yproximite\Bundle\CookieAcknowledgement\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class YproximiteCookieAcknowledgementExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!$config['response_injection']) {
            $container->removeDefinition('yproximite.cookie_acknowledgement_bar.event_listener');
        }

        $container->setParameter('yproximite.cookie_acknowledgement_bar.template', $config['template']);
    }
}
