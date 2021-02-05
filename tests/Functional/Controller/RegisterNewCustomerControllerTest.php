<?php

namespace Functional\Controller;

use App\Controller\RegisterNewCustomerController;
use App\Model\Customer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests for {@see RegisterNewCustomerController}.
 *
 * @author Twan Haverkamp <twan@mailcampaigns.nl>
 */
class RegisterNewCustomerControllerTest extends WebTestCase
{
    /**
     * @dataProvider getTranslatedFormLabels
     */
    public function testInvokeReturnsFormWithTranslatedLabels(
        string $translatedUrl,
        array $expectedTranslatedLabels
    ): void {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, $translatedUrl);

        $formNode = $crawler->filterXPath('//form[contains(@name, "register_new_customer")]');
        foreach ($formNode->filter('label') as $key => $labelNode) {
            $this->assertEquals($expectedTranslatedLabels[$key], $labelNode->nodeValue);
        }
    }

    /**
     * @dataProvider getValidFormData
     */
    public function testInvokeWithValidFormDataWillRedirect(
        string $translatedUrl,
        string $translatedRedirectUrl,
        string $translatedButtonValue,
        array $formData
    ): void {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, $translatedUrl);

        $form = $crawler->selectButton($translatedButtonValue)
            ->form($formData);

        $client->submit($form);

        $this->assertResponseRedirects($translatedRedirectUrl, Response::HTTP_FOUND);
    }

    /**
     * @dataProvider getInvalidFormData
     */
    public function testInvokeWithInvalidFormDataWillReturnWithErrorMessages(
        string $translatedUrl,
        string $translatedButtonValue,
        array $formData,
        array $expectedErrorMessages
    ): void {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, $translatedUrl);

        $form = $crawler->selectButton($translatedButtonValue)
            ->form($formData);

        $crawler = $client->submit($form);

        foreach ($expectedErrorMessages as $expectedErrorMessage) {
            $this->assertStringContainsString($expectedErrorMessage, $crawler->text());
        }
    }

    public function getTranslatedFormLabels(): iterable
    {
        yield [
            'translatedUrl' => '/en/register-new-customer',
            'expectedTranslatedLabels' => [
                'Gender',
                'Male',
                'Female',
                'First name',
                'Last name',
                'E-mail address',
                'Date of birth',
            ],
        ];

        yield [
            'translatedUrl' => '/nl/registreren-nieuwe-klant',
            'expectedTranslatedLabels' => [
                'Geslacht',
                'Man',
                'Vrouw',
                'Voornaam',
                'Achternaam',
                'E-mailadres',
                'Geboortedatum',
            ],
        ];
    }

    public function getValidFormData(): iterable
    {
        yield [
            'translatedUrl' => '/en/register-new-customer',
            'translatedRedirectUrl' => '/en/registration-new-customer-confirmed',
            'translatedButtonValue' => 'Register',
            'formData' => [
                'register_new_customer[gender]' => Customer::GENDER_MALE,
                'register_new_customer[firstName]' => 'John',
                'register_new_customer[lastName]' => 'Doe',
                'register_new_customer[emailAddress]' => 'john.doe@example.com',
                'register_new_customer[dateOfBirth][day]' => 1,
                'register_new_customer[dateOfBirth][month]' => 1,
                'register_new_customer[dateOfBirth][year]' => 1970,
            ],
        ];

        yield [
            'translatedUrl' => '/nl/registreren-nieuwe-klant',
            'translatedRedirectUrl' => '/nl/registratie-nieuwe-klant-bevestigd',
            'translatedButtonValue' => 'Registreren',
            'formData' => [
                'register_new_customer[gender]' => Customer::GENDER_FEMALE,
                'register_new_customer[firstName]' => 'Jane',
                'register_new_customer[lastName]' => 'Doe',
                'register_new_customer[emailAddress]' => 'jane.doe@example.com',
                'register_new_customer[dateOfBirth][day]' => 31,
                'register_new_customer[dateOfBirth][month]' => 12,
                'register_new_customer[dateOfBirth][year]' => 1970,
            ],
        ];
    }

    public function getInvalidFormData(): iterable
    {
        yield [
            'translatedUrl' => '/en/register-new-customer',
            'translatedButtonValue' => 'Register',
            'formData' => [
                'register_new_customer[firstName]' => 'J0hn',
                'register_new_customer[lastName]' => 'Do€',
                'register_new_customer[emailAddress]' => 'malformed-email-address',
            ],
            'expectedErrorMessages' => [
                'First name contains invalid characters',
                'Last name contains invalid characters',
                'E-mail address is invalid',
            ],
        ];

        yield [
            'translatedUrl' => '/nl/registreren-nieuwe-klant',
            'translatedButtonValue' => 'Registreren',
            'formData' => [
                'register_new_customer[firstName]' => 'J@ne',
                'register_new_customer[lastName]' => 'Doe_1',
                'register_new_customer[emailAddress]' => 'malformed-email-address',
            ],
            'expectedErrorMessages' => [
                'Voornaam bevat ongeldige tekens',
                'Achternaam bevat ongeldige tekens',
                'E-mailadres is ongeldig',
            ],
        ];
    }
}
