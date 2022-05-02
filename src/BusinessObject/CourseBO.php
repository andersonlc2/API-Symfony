<?php

namespace App\BusinessObject;

use App\DataAccessObject\CourseDAO;
use App\Entity\Course;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class CourseBO
{

	private CourseDAO $courseDAO;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->courseDAO = new CourseDAO($entityManager);
	}

	public function findAllCourses(): ?array
	{
		return $this->courseDAO->findAll();
	}

	public function findById(int $id): ?Course
	{
		return $this->courseDAO->findById($id);
	}

	public function findByName($nome): ?array
	{
		return $this->courseDAO->findByName($nome);
	}

	public function save(array $data, int $id = null): void
	{
		if ($id === null) {
			$course = new Course();
			$course->setName($data['name']);
			$course->setDescription($data['description']);
			$course->setSlug($data['slug']);
		} else {
			$course = $this->findById($id);
			if (isset($data['name'])) $course->setName($data['name']);
			if (isset($data['description'])) $course->setDescription($data['description']);
			if (isset($data['slug'])) $course->setSlug($data['slug']);
		}
		$this->courseDAO->save($course);
	}

	public function remove(int $id): void
	{
		$course = $this->findById($id);
		$this->courseDAO->remove($course);
	}
}
