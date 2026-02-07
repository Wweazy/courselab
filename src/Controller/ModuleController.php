<?php

namespace App\Controller;

use App\Entity\Module;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ModuleController extends AbstractController
{
    #[Route('/courses/{courseId}/module/{id}', name: 'course_module_show')]
    public function show(
        int $courseId,
        Module $module,
        PurchaseRepository $purchaseRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($module->getCourse()->getId() !== $courseId) {
            throw $this->createNotFoundException();
        }

        $purchased = $purchaseRepository->findOneByUserAndCourse($this->getUser(), $module->getCourse());
        if (!$purchased) {
            $this->addFlash('warning', 'course.buy_to_access');
            return $this->redirectToRoute('app_purchase_confirm', ['id' => $courseId]);
        }

        return $this->render('course/module.html.twig', [
            'module' => $module,
            'course' => $module->getCourse(),
        ]);
    }
}
