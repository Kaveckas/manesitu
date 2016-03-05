<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class AccessTokenAuthenticator implements SimplePreAuthenticatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function createToken(Request $request, $providerKey)
    {
        $accessToken = $request->headers->get('access-token');

        if (!$accessToken) {
            throw new BadCredentialsException('No API key found.');
        }

        return new PreAuthenticatedToken(
            'anon.',
            $accessToken,
            $providerKey
        );
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof AccessTokenUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of AccessTokenUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $accessToken = $token->getCredentials();
        $user = $userProvider->getUserByAccessToken($accessToken);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Invalid access token.');
        }

        return new PreAuthenticatedToken(
            $user,
            $accessToken,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }
}
