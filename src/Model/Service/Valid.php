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
        $data = [
            'secret'   => $this->secretKey,
            'response' => $_POST['g-recaptcha-response'],
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ];
		$curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);

        $json = json_decode($response);
		return $json->success;
    }
}
