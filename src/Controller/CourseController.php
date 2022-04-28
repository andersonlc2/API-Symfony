<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Course;
use DateTime;
use DateTimeZone;

/**
 * @Route("/courses", name="course_")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();

        return $this->json([
            'data' => $courses
        ]);
    }

    /**
     * @Route("/{courseID}", name="show", methods={"GET"})
     */
    public function show(int $courseId)
    {

    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */   
    public function create(Request $request)
    {
        $data = $request->request->all();

        $course = new Course();
        $course->setName($data['name']);
        $course->setDescription($data['description']);
        $course->setSlug($data['slug']);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($course);
        $doctrine->flush();

        return $this->json([
            'data' => 'Curso criado com sucesso!'
        ]);

    }

    /**
     * @Route("/{courseId}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(int $courseId)
    {

    }

    /**
     * @Route("/{courseId}", name="delete", methods={"DELETE"})
     */
    public function delete(int $courseId)
    {

    }

}
