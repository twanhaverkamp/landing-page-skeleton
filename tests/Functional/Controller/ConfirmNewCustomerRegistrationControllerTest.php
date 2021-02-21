<?php

namespace Functional\Controller;

use App\Controller\ConfirmNewCustomerRegistrationController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests for {@see ConfirmNewCustomerRegistrationController}.
 *
 * @author Twan Haverkamp <twan@mailcampaigns.nl>
 */
class ConfirmNewCustomerRegistrationControllerTest extends WebTestCase
{
    /**
     * @dataProvider getTranslatedUrls
     */
    public function testInvokeReturnsHttpOkResponse(string $translatedUrl): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, $translatedUrl);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function getTranslatedUrls(): iterable
    {
        return [
            'A confirmed English registrant' => [
                'translatedUrl' => '/en/registration-new-customer-confirmed',
            ],
            'A confirmed Dutch registrant' => [
                'translatedUrl' => '/nl/registratie-nieuwe-klant-bevestigd',
            ],
        ];
    }
}
