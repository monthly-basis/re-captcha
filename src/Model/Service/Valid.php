<?php
namespace MonthlyBasis\ReCaptcha\Model\Service;

class Valid
{
    public function __construct(
        string $secretKey
    ) {
        $this->secretKey = $secretKey;
    }

    public function isValid(): bool
    {
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
