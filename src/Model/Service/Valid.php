<?php
namespace MonthlyBasis\ReCaptcha\Model\Service;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;

class Valid
{
    public function __construct(
        ReCaptchaService\Allowlists\IpV4 $ipV4Service,
        string $secretKey
    ) {
        $this->ipV4Service = $ipV4Service;
        $this->secretKey   = $secretKey;
    }

    public function isValid(): bool
    {
        if ($this->ipV4Service->isIpV4InAllowlists($_SERVER['REMOTE_ADDR'])) {
            return true;
        }

        if (empty($_POST['g-recaptcha-response'])) {
            return false;
        }

        $postData = [
            'secret'   => $this->secretKey,
            'response' => $_POST['g-recaptcha-response'],
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ];

        $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $jsonResponseString = curl_exec($curl);
        curl_close($curl);

        $json = json_decode($jsonResponseString);
        return (bool) $json->success;
    }
}
