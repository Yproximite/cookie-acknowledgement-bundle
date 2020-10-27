<?php

namespace Yproximite\Bundle\CookieAcknowledgement\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class YproximiteCookieAcknowledgementExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($config['response_injection']) {
            $this->registerResponseListener($container);
        }

        $container->setParameter('yproximite.cookie_acknowledgement_bar.template', $config['template']);
    }

    protected function registerResponseListener(ContainerBuilder $container)
    {
        $definition = new Definition();
        $definition->setClass($container->getParameter('yproximite.cookie_acknowledgement_bar.event_listener.class'));
        $definition->addArgument(new Reference('yproximite.cookie_acknowledgement_bar.service'));

        $definition->addTag('kernel.event_listener', array(
            'event'  => 'kernel.response',
            'method' => 'onKernelResponse'
        ));

        $container->setDefinition('yproximite.cookie_acknowledgement_bar.event_listener', $definition);
    }
}
