<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CourseController extends AbstractController
{
    #[Route('/courses', name: 'courses_index')]
    public function index(
        CourseRepository $courseRepository,
        CategoryRepository $categoryRepository,
        Request $request
    ): Response {
        $categoryId = $request->query->getInt('category');
        $categories = $categoryRepository->findAll();
        $courses = $courseRepository->findByCategoryId($categoryId);

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
        ]);
    }

    #[Route('/courses/{id}', name: 'courses_show')]
    public function show(int $id, CourseRepository $courseRepository): Response
    {
        $course = $courseRepository->find($id);

        if (!$course) {
            throw $this->createNotFoundException('Сourse not found');
        }

        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }
}
