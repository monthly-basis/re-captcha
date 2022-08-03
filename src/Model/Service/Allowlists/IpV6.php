<?php
namespace MonthlyBasis\ReCaptcha\Model\Service\Allowlists;

use MonthlyBasis\IpAddress\Model\Service as IpAddressService;
use MonthlyBasis\ReCaptcha\Model\Entity as ReCaptchaEntity;

class IpV6
{
    public function __construct(
        IpAddressService\V6\FirstFourSegments $firstFourSegmentsService,
        ReCaptchaEntity\Config $configEntity
    ) {
        $this->firstFourSegmentsService = $firstFourSegmentsService;
        $this->configEntity             = $configEntity;
    }

    public function isIpV6InAllowlists(string $ipV6): bool
    {
        $ipV6Allowlist = $this->configEntity['service']['allowlists']['ip-v6'] ?? [];
        $firstFourSegmentsList = $ipV6Allowlist['first-four-segments'] ?? [];

        if (empty($firstFourSegmentsList)) {
            return false;
        }

        $firstFourSegments = $this->firstFourSegmentsService->getFirstFourSegments(
            $ipV6
        );

        return in_array($firstFourSegments, $firstFourSegmentsList);
    }
}
