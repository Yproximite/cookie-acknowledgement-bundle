<?php declare(strict_types=1);

namespace Yproximite\Bundle\CookieAcknowledgement\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Yproximite\Bundle\CookieAcknowledgement\YproximiteCookieAcknowledgementBundle;

abstract class AbstractYproximiteCookieAcknowledgementTestKernel extends Kernel
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
            new YproximiteCookieAcknowledgementBundle(),
        ];
    }

    protected function configureContainer(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->loadFromExtension('framework', [
            'secret' => 'my-secret',
            'test'   => true,
        ]);

        $containerBuilder->loadFromExtension('twig', [
            'paths' => [__DIR__.'/..'],
        ]);
    }

    public function requestHomepage(): Response
    {
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

if (AbstractYproximiteCookieAcknowledgementTestKernel::VERSION_ID >= 50100) { // @phpstan-ignore-line
    class YproximiteCookieAcknowledgementTestKernel extends AbstractYproximiteCookieAcknowledgementTestKernel
    {
        protected function configureRoutes(RoutingConfigurator $routes): void
        {
            $routes->add('homepage', '/')->controller([$this, 'requestHomepage']);
        }
    }
} else { // @phpstan-ignore-line
    class YproximiteCookieAcknowledgementTestKernel extends AbstractYproximiteCookieAcknowledgementTestKernel
    {
        protected function configureRoutes(RouteCollectionBuilder $routes): void
        {
            $routes->add('/', 'kernel::requestHomepage');
        }
    }
}
