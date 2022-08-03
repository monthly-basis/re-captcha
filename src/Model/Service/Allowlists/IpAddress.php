<?php
namespace MonthlyBasis\ReCaptcha\Model\Service\Allowlists;

use MonthlyBasis\IpAddress\Model\Service as IpAddressService;
use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;

class IpAddress
{
    public function __construct(
        IpAddressService\Version $versionService,
        ReCaptchaService\Allowlists\IpV4 $ipV4Service,
        ReCaptchaService\Allowlists\IpV6 $ipV6Service
    ) {
        $this->versionService = $versionService;
        $this->ipV4Service    = $ipV4Service;
        $this->ipV6Service    = $ipV6Service;
    }

    public function isIpAddressInAllowlists(string $ipAddress): bool
    {
        $version = $this->versionService->getVersion($ipAddress);

        return ($version == 4)
            ? $this->ipV4Service->isIpV4InAllowlists($ipAddress)
            : $this->ipV6Service->isIpV6InAllowlists($ipAddress);
    }
}
