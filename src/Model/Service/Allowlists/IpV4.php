<?php
namespace MonthlyBasis\ReCaptcha\Model\Service\Allowlists;

use MonthlyBasis\ReCaptcha\Model\Entity as ReCaptchaEntity;

class IpV4
{
    public function __construct(
        ReCaptchaEntity\Config $configEntity
    ) {
        $this->configEntity = $configEntity;
    }

    public function isIpV4InAllowlists(string $ipV4): bool
    {
        $ipV4Allowlist = $this->configEntity['service']['allowlists']['ip-v4'] ?? [];

        return in_array($ipV4, $ipV4Allowlist);
    }
}
