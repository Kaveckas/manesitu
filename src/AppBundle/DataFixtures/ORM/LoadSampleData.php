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

use AppBundle\Entity\AccessToken;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\Reaction;
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
            ->setEmotion('Sad')
            ->setCreatedAt(new \DateTime());
        $manager->persist($post1);

        $post2 = new Post();
        $post2
            ->setContent('Sample post 2')
            ->setAuthor($userTomas)
            ->setEmotion('Angry')
            ->setCreatedAt(new \DateTime());
        $manager->persist($post2);

        $comment1 = new Comment();
        $comment1
            ->setContent('Comment 1')
            ->setAuthor($userTomas)
            ->setPost($post1)
            ->setCreatedAt(new \DateTime());
        $manager->persist($comment1);

        $reaction1 = new Reaction();
        $reaction1
            ->setType(Reaction::TYPE_HUG)
            ->setPost($post1)
            ->setUser($userTomas)
            ->setCreatedAt(new \DateTime());
        $manager->persist($reaction1);

        $reaction2 = new Reaction();
        $reaction2
            ->setType(Reaction::TYPE_SUPPORT)
            ->setPost($post1)
            ->setUser($userTomas)
            ->setCreatedAt(new \DateTime());
        $manager->persist($reaction2);

        $accessToken1 = new AccessToken();
        $accessToken1
            ->setToken('abc')
            ->setUser($userTomas)
            ->setCreatedAt(new \DateTime());
        $manager->persist($accessToken1);

        $manager->flush();
    }
}
