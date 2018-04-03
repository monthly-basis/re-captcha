<?php
namespace LeoGalleguillos\ReCaptcha\Model\Service;

class Valid
{
    public function __construct(
        string $secretKey
    ) {
        $this->secretKey = $secretKey;
    }

    public function isValid()
    {

    }
}
