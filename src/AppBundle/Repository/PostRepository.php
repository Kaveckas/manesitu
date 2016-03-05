<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 */
class PostRepository extends EntityRepository
{
    const COUNT_PER_PAGE = 10;

    /**
     * Returns list of posts by given page number.
     *
     * @param $page
     *
     * @return array
     */
    public function getPagedList($page)
    {
        $dql = '
            SELECT p post, (SELECT COUNT(c.id) FROM AppBundle:Comment c WHERE c.post = p) comment_count
            FROM AppBundle:Post p
            INNER JOIN p.author a
        ';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setFirstResult($page * self::COUNT_PER_PAGE - self::COUNT_PER_PAGE);
        $query->setMaxResults(self::COUNT_PER_PAGE);

        $result = $query->getResult();
        $list = [];

        foreach ($result as $item) {
            /** @var Post $post */
            $post = $item['post'];
            $list[] = [
                'id' => $post->getId(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format(DATE_ISO8601),
                'author' => $post->getAuthor()->getName(),
                'emotion' => $post->getEmotion(),
                'comments' => $item['comment_count'],
            ];
        }

        return $list;
    }
}
