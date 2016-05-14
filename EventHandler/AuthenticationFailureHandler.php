<?php

namespace Loamok\Sf2securityBundle\EventHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;

class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler {
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        if (null !== $this->logger && null !== $request->getClientIp()) {
            $this->logger->error(sprintf('Authentication failure for IP: %s', $request->getClientIp()));
        }

        return parent::onAuthenticationFailure($request, $exception);
    }
}

