<?php

namespace Yproximite\Bundle\CookieAcknowledgement\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpKernel\Kernel;
use Yproximite\Bundle\CookieAcknowledgement\Tests\DummyKernel;
use Yproximite\Bundle\CookieAcknowledgement\YproximiteCookieAcknowledgementBundle;

class CookieAcknowledgementControllerTest extends TestCase
{
    protected function getBundleClass()
    {
        return YproximiteCookieAcknowledgementBundle::class;
    }

    public function testIfCookieAcknowledgementBarAppearsIfCookieIsNotSet()
    {
        $kernel = new DummyKernel();
        $client = new KernelBrowser($kernel);

        $crawler = $client->request('GET', '/');

        $cookieInfoBar = $crawler->filter('#cookie-law-info-bar');

        $this->assertEquals(1, $cookieInfoBar->count());
        $this->assertStringContainsString('cookie.message.accept', $cookieInfoBar->html());
    }
}
