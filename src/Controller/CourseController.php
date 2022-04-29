<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
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
    public function index(EntityManagerInterface $entityManager) : Response
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();

        return $this->json([
            'data' => $courses
        ]);
    }

    /**
     * @Route("/{courseId}", name="show", methods={"GET"})
     */
    public function show(int $courseId, EntityManagerInterface $entityManager) : Response
    {
        $course = $entityManager->getRepository(Course::class)->find($courseId);

        return $this->json([
            'data' => $course
        ]);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */   
    public function create(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $data = $request->request->all();

        $course = new Course();
        $course->setName($data['name']);
        $course->setDescription($data['description']);
        $course->setSlug($data['slug']);

        $entityManager->persist($course);
        $entityManager->flush();

        return $this->json([
            'data' => 'Curso criado com sucesso!'
        ]);

    }

    /**
     * @Route("/{courseId}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(int $courseId, Request $request, EntityManagerInterface $entityManager) : Response
    {
        $data = $request->request->all();

        $course = $entityManager->getRepository(Course::class)->find($courseId);
        if (isset($data['name'])) $course->setName($data['name']);
        if (isset($data['description'])) $course->setDescription($data['description']);
        if (isset($data['slug'])) $course->setSlug($data['slug']);

        $entityManager->persist($course);
        $entityManager->flush();

        return $this->json([
            'data' => 'Curso atualizado com sucesso!'
        ]);
    }

    /**
     * @Route("/{courseId}", name="delete", methods={"DELETE"})
     */
    public function delete(int $courseId, EntityManagerInterface $entityManager) : Response
    {
        $course = $entityManager->getRepository(Course::class)->find($courseId);

        $entityManager->remove($course);
        $entityManager->flush();


        return $this->json([
            'data' => 'Curso removido com sucesso!'
        ]);
    }

}
