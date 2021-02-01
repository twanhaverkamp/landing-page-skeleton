<?php

namespace App\Controller;

use App\Form\CustomerType;
use App\Model\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Twan Haverkamp <twan@mailcampaigns.nl>
 *
 * @Route({
 *     "en": "/register",
 *     "nl": "/registreren",
 * }, name="register_new_customer", methods={"GET", "POST"})
 */
final class RegisterNewCustomerController extends AbstractController
{
    public function __invoke(
        Request $request,
        FormFactoryInterface $formFactory,
        HttpClientInterface $client
    ): Response {
        $form = $formFactory->createNamed('register_new_customer', CustomerType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'customer.submit.register_new',
            ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() === true && $form->isValid() === true) {
            /** @var Customer $customer */
            $customer = $form->getData();

            // TODO: Implement the handling of the registration by eg. calling your own API.
            // TODO: $client->request(Request::METHOD_POST, $_ENV['BASE_URI'] . '/customer', []);

            return $this->redirectToRoute('confirm_new_customer_registration');
        }

        return $this->render('register_new_customer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
