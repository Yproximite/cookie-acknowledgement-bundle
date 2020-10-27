<?php

declare(strict_types=1);

namespace Yproximite\Bundle\CookieAcknowledgement\Service;

class CookieAcknowledgementService implements CookieAcknowledgementInterface
{
    private $twig;
    private $template;

    public function __construct(\Twig\Environment $twig, string $template)
    {
        $this->twig     = $twig;
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function render(array $data = []): string
    {
        return $this->twig->render($this->template, $data);
    }
}
