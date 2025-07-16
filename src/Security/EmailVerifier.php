<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class EmailVerifier
{
  public function __construct(
    private VerifyEmailHelperInterface $verifyEmailHelper,
    private MailerInterface $mailer,
    private EntityManagerInterface $entityManager
  ) {}

  public function sendEmailConfirmation(string $verifyEmailRouteName, Customer $Customer, TemplatedEmail $email): void
  {
    $signatureComponents = $this->verifyEmailHelper->generateSignature(
      $verifyEmailRouteName,
      (string) $Customer->getId(),
      (string) $Customer->getEmail()
    );

    $context = $email->getContext();
    $context['signedUrl'] = $signatureComponents->getSignedUrl();
    $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
    $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

    $email->context($context);

    $this->mailer->send($email);
  }

  /**
   * @throws VerifyEmailExceptionInterface
   */
  public function handleEmailConfirmation(Request $request, Customer $Customer): void
  {
    $this->verifyEmailHelper->validateEmailConfirmationFromRequest($request, (string) $Customer->getId(), (string) $Customer->getEmail());

    $Customer->setIsVerified(true);

    $this->entityManager->persist($Customer);
    $this->entityManager->flush();
  }
}