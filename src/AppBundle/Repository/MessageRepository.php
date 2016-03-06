<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Message;

/**
 * MessageRepository
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
    const COUNT_PER_PAGE = 10;

    /**
     * Returns list of posts by given page number.
     *
     * @param int $receiverId
     * @param int $page
     *
     * @return array
     */
    public function getList($receiverId, $page)
    {
        $dql = '
            SELECT m, s
            FROM AppBundle:Message m
            INNER JOIN m.sender s
            WHERE m.receiver = :user
        ';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('user', $receiverId);
        $query->setFirstResult($page * self::COUNT_PER_PAGE - self::COUNT_PER_PAGE);
        $query->setMaxResults(self::COUNT_PER_PAGE);

        $result = $query->getResult();
        $messages = [];

        /** @var Message $message */
        foreach ($result as $message) {
            $messages[] = [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'created_at' => $message->getCreatedAt()->format(DATE_ISO8601),
                'sender' => [
                    'id' => $message->getSender()->getId(),
                    'name' => $message->getSender()->getName(),
                ],
            ];
        }

        return $messages;
    }
}
