<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Security\Handler;

use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
final class RoleSecurityHandler implements SecurityHandlerInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var string[]
     */
    private $superAdminRoles = [];

    /**
     * @param string[] $superAdminRoles
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker, array $superAdminRoles)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->superAdminRoles = $superAdminRoles;
    }

    public function isGranted(AdminInterface $admin, $attributes, $object = null): bool
    {
        if (!\is_array($attributes)) {
            $attributes = [$attributes];
        }

        foreach ($attributes as $pos => $attribute) {
            $attributes[$pos] = sprintf($this->getBaseRole($admin), $attribute);
        }

        $allRole = sprintf($this->getBaseRole($admin), 'ALL');

        try {
            return $this->isAnyGranted($this->superAdminRoles)
                || $this->isAnyGranted($attributes, $object)
                || $this->isAnyGranted([$allRole], $object);
        } catch (AuthenticationCredentialsNotFoundException $e) {
            return false;
        }
    }

    public function getBaseRole(AdminInterface $admin): string
    {
        return sprintf('ROLE_%s_%%s', str_replace('.', '_', strtoupper($admin->getCode())));
    }

    public function buildSecurityInformation(AdminInterface $admin): array
    {
        return [];
    }

    public function createObjectSecurity(AdminInterface $admin, object $object): void
    {
    }

    public function deleteObjectSecurity(AdminInterface $admin, object $object): void
    {
    }

    /**
     * @param string[] $attributes
     * @param mixed|null $subject
     */
    private function isAnyGranted(array $attributes, $subject = null): bool
    {
        foreach ($attributes as $attribute) {
            if ($this->authorizationChecker->isGranted($attribute, $subject)) {
                return true;
            }
        }

        return false;
    }
}
