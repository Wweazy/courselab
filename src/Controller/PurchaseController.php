<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PurchaseController extends AbstractController
{
    #[Route('/purchase/{id}', name: 'app_purchase_confirm')]
    public function confirm(Course $course, PurchaseRepository $purchaseRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($purchaseRepository->findOneByUserAndCourse($this->getUser(), $course)) {
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('purchase/confirm.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/purchase/{id}/success', name: 'app_purchase_success')]
    public function success(Course $course, EntityManagerInterface $entityManager, PurchaseRepository $purchaseRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($purchaseRepository->findOneByUserAndCourse($this->getUser(), $course)) {
            return $this->redirectToRoute('app_profile');
        }

        $purchase = new Purchase();
        $purchase->setUser($this->getUser());
        $purchase->setCourse($course);
        $purchase->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($purchase);
        $entityManager->flush();

        return $this->render('purchase/success.html.twig', [
            'course' => $course,
        ]);
    }
}
