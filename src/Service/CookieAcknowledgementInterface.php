<?php

namespace Yproximite\Bundle\CookieAcknowledgement\Service;

interface CookieAcknowledgementInterface
{
    /**
     * @param array<mixed> $data
     */
    public function render(array $data = []): string;
}
