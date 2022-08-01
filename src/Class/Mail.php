<?php

namespace App\Class;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
	private $api_key = '545da1a36b87e1b4987df323a5467453';
	private $api_key_secret = 'b00fb45c040b8e961cedf1e9e15489de';

	public function send($to_email, $to_name, $subject, $content)
	{
		$mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
		$body = [
			'Messages' => [
				[
					'From' => [
						'Email' => "boutiquevitaminee@gmail.com",
						'Name' => "La Boutique Vitaminée"
					],
					'To' => [
						[
							'Email' => $to_email,
							'Name' => $to_name
						]
					],
					'TemplateID' => 4110366,
					'TemplateLanguage' => true,
					'Subject' => $subject,
					'Variables' => [
						'content' => $content
					]
				]
			]
		];
		$response = $mj->post(Resources::$Email, ['body' => $body]);
		$response->success() && dd($response->getData());
	}
}
