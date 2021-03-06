<?php

namespace Noona\StockBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ReassortRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VenteRepository extends EntityRepository
{
    public function findAllByDate($page,$nbrParPage)
    {
        $qb =$this->createQueryBuilder('v')
                    ->orderBy('v.dateVente','DESC')
                    ->addOrderBy('v.id','DESC')
                    ->setFirstResult(($page-1)*$nbrParPage)
                    ->setMaxResults($nbrParPage);

        return new Paginator($qb);
    }
}
