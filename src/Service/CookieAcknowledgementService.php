<?php

namespace Yproximite\Bundle\CookieAcknowledgement\Service;

use Yproximite\Bundle\CookieAcknowledgement\Service\CookieAcknowledgementInterface;

class CookieAcknowledgementService implements CookieAcknowledgementInterface
{
    protected $template;

    /**
     *
     * @var \Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine
     */
    protected $templating;

    public function __construct($templating, $template)
    {
        $this->templating = $templating;
        $this->template   = $template;
    }

    public function render(array $data = array())
    {
        return $this->templating->render($this->template, $data);
    }

}
