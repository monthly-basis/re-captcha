<?php
namespace LeoGalleguillos\ReCaptcha\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DivTag extends AbstractHelper
{
    public function __construct(
        string $siteKey
    ) {
        $this->siteKey = $siteKey;
    }

    public function __invoke()
    {
        return '<div class="g-recaptcha" data-sitekey="'
             . $this->escape($this->siteKey)
             . '"></div>';
    }
}
