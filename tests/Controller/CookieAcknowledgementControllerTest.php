<?php

declare(strict_types=1);

namespace Yproximite\Bundle\CookieAcknowledgement\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Yproximite\Bundle\CookieAcknowledgement\Tests\YproximiteCookieAcknowledgementTestKernel;

class CookieAcknowledgementControllerTest extends TestCase
{
    public function testIfCookieAcknowledgementBarAppearsIfCookieIsNotSet(): void
    {
        $kernel = new YproximiteCookieAcknowledgementTestKernel();
        $client = new KernelBrowser($kernel);

        $crawler = $client->request('GET', '/');

        $cookieInfoBar = $crawler->filter('#cookie-law-info-bar');

        static::assertEquals(1, $cookieInfoBar->count());
        static::assertStringContainsString('cookie.message.accept', $cookieInfoBar->html());
    }
}
