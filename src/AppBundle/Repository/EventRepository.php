<?php

/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/17/17
 * Time: 7:25 PM
 */
namespace  AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EventRepository extends  EntityRepository
{

    public function findByFilters($filters)
    {
        $params = [];
        $qb = $this->createQueryBuilder('e');
        if (count($filters['tags'])) {
            $qb->innerJoin('e.event_tags', 't')
                ->add('where', $qb->expr()->orX($qb->expr()->in('t.id', $filters['tags'])));
        }
        if (count($filters['country'])) {
            $qb->innerJoin('e.country', 'c')->andWhere('c.name =:country');
            $params['country'] = $filters['country']->getName();
        }
        if (count($filters['membersRanges'])) {
            if (preg_match('/-/', $filters['membersRanges'])) {
                $ranges = explode('-',$filters['membersRanges']);
                $qb->andWhere($qb->expr()->between('e.people_needed', ':member1', ':member2'));
                $params['member1'] = trim(array_shift($ranges));
                $params['member2'] = trim(array_shift($ranges));
            } elseif (preg_match('/>/', $filters['membersRanges'])) {
                $members = (int)substr($filters['membersRanges'], strpos($filters['membersRanges'], ">") + 1);
                $qb->andWhere('e.people_needed > :members');
                $params['members'] = $members;
            } elseif (preg_match('/</', $filters['membersRanges'])) {
                $members = (int)substr($filters['membersRanges'], strpos($filters['membersRanges'], ">") + 1);
                $qb->andWhere('e.people_needed < :members');
                $params['members'] = $members;
            }
        }
        if (count($filters['startRanges'])) {
            $options['startRanges'] = ['1-3 дня' => '< 3', 'месяц' => '3-30', 'более' => '>30'];
            if (preg_match('/-/', $filters['startRanges'])) {
                $ranges = explode('-',$filters['startRanges']);
                $qb->andWhere($qb->expr()->between('e.event_date_time', ':date1', ':date2'));
                $now = new \DateTime();
                $params['date1'] = new \DateTime();
                $params['date2'] = $now->add(new \DateInterval("P30D"));//trim(array_shift($ranges));
            } elseif (preg_match('/>/', $filters['startRanges'])) {
                $days = (int)substr($filters['startRanges'], strpos($filters['startRanges'], ">") + 1);
                $qb->andWhere('e.event_date_time > :date');
                $interval = "P".$days."D";
                $now = new \DateTime();
                $params['date'] = $now->add(new \DateInterval($interval));
            } elseif (preg_match('/</', $filters['startRanges'])) {
                $days = (int)substr($filters['startRanges'], strpos($filters['startRanges'], ">") + 1);
                $qb->andWhere($qb->expr()->between('e.event_date_time', ':date1', ':date2'));
                $interval = "P".$days."D";
                $now = new \DateTime();
                $params['date1'] = new \DateTime();
                $params['date2'] = $now->add(new \DateInterval($interval));
            }
        }
        if (count($filters['textSearch'])) {
            $qb->andWhere('e.title like :text');
            $qb->orWhere('e.text like :text2');

            $params['text'] = '%'.$filters['textSearch'].'%';
            $params['text2'] = '%'.$filters['textSearch'].'%';
        }

        return $qb->setParameters($params)
            ->orderBy('e.id','desc')
            ->getQuery()
            ->getResult();
    }
}

