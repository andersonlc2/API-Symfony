<?php

namespace App\DataAccessObject;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\ManagerRegistry;


class CourseDAO
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	public function findAll(): ?array
	{
		return $this->entityManager->getRepository(Course::class)->findAll();
	}

	public function findById(int $id): ?Course
	{
		return $this->entityManager->getRepository(Course::class)->find($id);
	}

	public function findByName($nome): ?array
	{
        return $this->entityManager->getRepository(Course::class)->findBy(['name' => $nome]);
	}

	public function save(Course $course): void
	{
		$this->entityManager->persist($course);
		$this->entityManager->flush();
	}

	public function remove(Course $course): void
	{
		$this->entityManager->remove($course);
		$this->entityManager->flush();
	}
}
