<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSampleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userTomas = new User();
        $userTomas
            ->setName('Tomas')
            ->setEmail('tomas@tomas')
            ->setPassword('demo')
            ->setCreatedAt(new \DateTime());
        $manager->persist($userTomas);

        $post1 = new Post();
        $post1
            ->setContent('Sample post 1')
            ->setAuthor($userTomas)
            ->setCreatedAt(new \DateTime());
        $manager->persist($post1);

        $post2 = new Post();
        $post2
            ->setContent('Sample post 2')
            ->setAuthor($userTomas)
            ->setCreatedAt(new \DateTime());
        $manager->persist($post2);

        $comment1 = new Comment();
        $comment1
            ->setContent('Comment 1')
            ->setAuthor($userTomas)
            ->setPost($post1)
            ->setCreatedAt(new \DateTime());
        $manager->persist($comment1);

        $manager->flush();
    }
}
