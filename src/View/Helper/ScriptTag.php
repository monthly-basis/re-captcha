<?php
namespace MonthlyBasis\ReCaptcha\View\Helper;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use Laminas\View\Helper\AbstractHelper;

class ScriptTag extends AbstractHelper
{
    public function __construct(
        ReCaptchaService\Allowlists\IpV4 $ipV4Service
    ) {
        $this->ipV4Service = $ipV4Service;
    }

    public function __invoke()
    {
        if ($this->ipV4Service->isIpV4InAllowlists($_SERVER['REMOTE_ADDR'])) {
            return '<!-- The script tag was omitted because your IPv4 is in the allowlist. -->';
        }

        return '<script src="https://www.google.com/recaptcha/api.js"></script>';
    }
}
