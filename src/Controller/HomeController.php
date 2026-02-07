<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CourseRepository $courseRepository): Response
    {
        $featuredCourses = $courseRepository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('home/index.html.twig', [
            'featuredCourses' => $featuredCourses,
        ]);
    }
}
