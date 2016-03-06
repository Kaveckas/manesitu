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
     * @param int $user
     *
     * @return array
     */
    public function getCountsByPost($post, $user)
    {
        $dql = '
            SELECT r.type, COUNT(r.id) reaction_count, COUNTIF(r.user, :user) given
            FROM AppBundle:Reaction r
            WHERE r.post = :post
            GROUP BY r.type
        ';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('post', $post);
        $query->setParameter('user', $user);

        $result = $query->getArrayResult();
        $reactions = [];

        foreach ($result as $item) {
            $reactions[$item['type']] = [
                'count' => $item['reaction_count'],
                'given' => $item['given'],
            ];
        }

        foreach (Reaction::TYPES as $type) {
            if (!isset($reactions[$type])) {
                $reactions[$type] = [
                    'count' => 0,
                    'given' => false,
                ];
            }
        }

        return $reactions;
    }
}
