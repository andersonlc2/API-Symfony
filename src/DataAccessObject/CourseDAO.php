<?php

namespace App\DataAccessObject;

use App\Entity\Course;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class CourseDAO
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function findAll() : ?array
    {
        return $this->entityManager->getRepository(Course::class)->findAll();
    }

    public function findById(int $id) : ?Course
    {
        return $this->entityManager->getRepository(Course::class)->find($id);
    }

    public function save(Course $course) : void
    {
        $this->entityManager->persist($course);
        $this->entityManager->flush();
    }

    public function remove(Course $course) : void
    {
        $this->entityManager->remove($course);
        $this->entityManager->flush();
    }
}