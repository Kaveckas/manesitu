<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Comment;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    const COUNT_PER_PAGE = 10;

    /**
     * Returns list of posts by given page number.
     *
     * @param int $post
     * @param int $page
     *
     * @return array
     */
    public function getPagedList($post, $page)
    {
        $dql = '
            SELECT c
            FROM AppBundle:Comment c
            WHERE c.post = :post
        ';
        $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('post', $post);
        $query->setFirstResult($page * self::COUNT_PER_PAGE - self::COUNT_PER_PAGE);
        $query->setMaxResults(self::COUNT_PER_PAGE);

        /** @var Comment[] $comments */
        $comments = $query->getResult();
        $list = [];

        foreach ($comments as $comment) {
            $list[] = [
                'id' => $comment->getId(),
                'content' => $comment->getContent(),
                'created_at' => $comment->getCreatedAt()->format(DATE_ISO8601),
                'author' => $comment->getAuthor()->getName(),
            ];
        }

        return $list;
    }
}
