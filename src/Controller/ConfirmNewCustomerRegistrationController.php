<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Twan Haverkamp <twan@mailcampaigns.nl>
 *
 * @Route({
 *     "en": "/registration-confirmed",
 *     "nl": "/registratie-bevestigd",
 * }, name="confirm_new_customer_registration", methods={"GET"})
 */
final class ConfirmNewCustomerRegistrationController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('confirm_new_customer_registration.html.twig');
    }
}
