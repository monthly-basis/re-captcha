<?php
namespace LeoGalleguillos\ReCaptcha\View\Helper;

use MonthlyBasis\String\Model\Service as StringService;
use Zend\View\Helper\AbstractHelper;

class DivTag extends AbstractHelper
{
    public function __construct(
        string $siteKey,
        StringService\Escape $escapeService
    ) {
        $this->siteKey       = $siteKey;
        $this->escapeService = $escapeService;
    }

    public function __invoke()
    {
        return '<div class="g-recaptcha" data-sitekey="'
             . $this->escapeService->escape($this->siteKey)
             . '"></div>';
    }
}
