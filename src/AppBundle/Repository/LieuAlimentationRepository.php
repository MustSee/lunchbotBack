<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\LieuAlimentation;


class LieuAlimentationRepository extends EntityRepository
{
    public function findAllPlacesToEat () {
        $q = $this->getEntityManager()->createQuery('
        SELECT l.denomination, l.positionLongitude, l.positionLatitude, l.adresse, l.codePostal FROM AppBundle:LieuAlimentation l
        ');
        return $q->getResult();
    }

    public function findAllByChars($param) {
        $q = $this->getEntityManager()->createQuery('
            SELECT l.denomination FROM AppBundle:LieuAlimentation l WHERE l.denomination LIKE :param
        ');
        $q->setParameters([
            'param' => "%".$param."%"
        ]);
        return $q->getResult();
    }

    public function findOnePlace($param) {
        $q = $this->getEntityManager()->createQuery('
            SELECT l.denomination, l.adresse, l.codePostal FROM AppBundle:LieuAlimentation l WHERE l.denomination = :param
        ');
        $q->setParameters([
            'param' => $param
        ]);
        return $q->getResult();
    }
}
