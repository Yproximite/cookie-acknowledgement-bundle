<?php

namespace Yproximite\Bundle\CookieAcknowledgement\Service;

interface CookieAcknowledgementInterface
{
    public function render(array $data = []): string;
}
