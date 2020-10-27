<?php declare(strict_types=1);

namespace Yproximite\Bundle\CookieAcknowledgement\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Yproximite\Bundle\CookieAcknowledgement\YproximiteCookieAcknowledgementBundle;

class DummyKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new YproximiteCookieAcknowledgementBundle()
        ];
    }

    public function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->loadFromExtension('framework', [
            'test' => true,
        ]);

        $container->loadFromExtension('twig', [
            'paths' => [__DIR__ .'/..'],
        ]);
    }

    public function configureRoutes(RoutingConfigurator $routes)
    {
        $routes->add('homepage', '/')->controller([$this, 'requestHomepage']);
    }

    public function requestHomepage() {
        return new Response(<<<HTML
<!DOCTYPE html>
<html>
  <head>
    <title>The title</title>
  </head>
  <body>
    The body
  </body>
</html>
HTML
        );

    }
}