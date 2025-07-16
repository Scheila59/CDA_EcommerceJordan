<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier) {}

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $CustomerPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $Customer = new Customer();
        $form = $this->createForm(RegistrationFormType::class, $Customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $Customer->setPassword($CustomerPasswordHasher->hashPassword($Customer, $plainPassword));

            $Customer->setRoles(['ROLE_User']);

            $entityManager->persist($Customer);
            $entityManager->flush();

            // generate a signed url and email it to the Customer
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $Customer,
                (new TemplatedEmail())
                    ->from(new Address('scheila59@gmail.com', 'JordanPierre'))
                    ->to((string) $Customer->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            $this->addFlash('success', 'Votre inscription a bien été prise en compte. Un email de confirmation vient de vous être envoyé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyverifyCustomerEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets Customer::isVerified=true and persists
        try {
            /** @var Customer $Customer */
            $Customer = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $Customer);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_home');
    }
}