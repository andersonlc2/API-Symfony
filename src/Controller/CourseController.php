<?php

namespace App\Controller;

use App\BusinessObject\CourseBO;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/courses", name="course_")
 */
class CourseController extends AbstractController
{
    private CourseBO $courseBO;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->courseBO = new CourseBO($entityManager);
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index() : Response
    {
        $courses = $this->courseBO->findAllCourses();
        if (count($courses) == 0) {
            throw new NotFoundHttpException('Nenhum curso não encontrado');
        }
        return $this->json(['data' => $courses]);
    }

    /**
     * @Route("/{courseId}", name="show", methods={"GET"})
     */
    public function show($courseId) : Response
    {
        if (is_numeric($courseId)) {
            $course = $this->courseBO->findById($courseId);
            if ($course == null) {
                throw new NotFoundHttpException('Curso não encontrado');
            }

            return $this->json(['data' => $course]);
        } else {
            throw new BadRequestException('$course deve ser um INTEIRO');
        }

    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */   
    public function create(Request $request) : Response
    {
        $data = $request->request->all();
        $this->courseBO->save($data);
        return $this->json([
            'data' => 'Curso criado com sucesso!'
        ]);
    }

    /**
     * @Route("/{courseId}", name="update", methods={"PUT", "PATCH"})
     */
    public function update($courseId, Request $request) : Response
    {
        if (is_numeric($courseId)) {
            $data = $request->request->all();
            $this->courseBO->save($data, $courseId);

            return $this->json(['data' => 'Curso atualizado com sucesso!']);
        } else {
            throw new BadRequestException('$course deve ser um INTEIRO');
        }

    }

    /**
     * @Route("/{courseId}", name="delete", methods={"DELETE"})
     */
    public function delete($courseId) : Response
    {
        if (is_numeric($courseId)) {

            $this->courseBO->remove($courseId);
            return $this->json(['data' => 'Curso removido com sucesso!']);
        } else {
            throw new BadRequestException('$course deve ser um INTEIRO');
        }
    }

}
