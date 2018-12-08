<?php

namespace BalticRobo\Api\Repository\Competition;

use BalticRobo\Api\Entity\Competition\Competition;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @method Competition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competition[]    findAll()
 * @method Competition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Competition::class);
    }

    public function getTotal(): int
    {
        return $this->count([]);
    }

    public function getRecordsByYear(int $year): Collection
    {
        return new ArrayCollection($this->findBy(['year' => $year]));
    }

    public function save(Competition $competition): void
    {
        $this->getEntityManager()->persist($competition);
        $this->getEntityManager()->flush();
    }
}
