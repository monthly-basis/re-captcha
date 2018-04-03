<?php
namespace LeoGalleguillos\ReCaptcha\View\Helper;

use LeoGalleguillos\String\View\Helper as StringHelper;
use Zend\View\Helper\AbstractHelper;

class DivTag extends AbstractHelper
{
    public function __construct(
        string $siteKey,
        StringHelper\Escape $escapeHelper
    ) {
        $this->siteKey      = $siteKey;
        $this->escapeHelper = $escapeHelper;
    }

    public function __invoke()
    {
        return '<div class="g-recaptcha" data-sitekey="'
             . $this->escapeHelper->__invoke($this->siteKey)
             . '"></div>';
    }
}
