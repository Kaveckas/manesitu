<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Reaction;

/**
 * ReactionRepository
 */
class ReactionRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Fetches reactions counts for single post
     *
     * @param int $post
     *
     * @return array
     */
    public function getCountsByPost($post)
    {
        $dql = '
            SELECT r.type, COUNT(r.id) reaction_count
            FROM AppBundle:Reaction r
            WHERE r.post = :post
            GROUP BY r.type
        ';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('post', $post);

        $result = $query->getArrayResult();
        $reactions = [];

        foreach ($result as $item) {
            $reactions[$item['type']] = $item['reaction_count'];
        }

        foreach (Reaction::TYPES as $type) {
            if (!isset($reactions[$type])) {
                $reactions[$type] = 0;
            }
        }

        return $reactions;
    }
}
