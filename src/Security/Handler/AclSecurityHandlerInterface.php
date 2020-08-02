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

use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Model\AclInterface;
use Symfony\Component\Security\Acl\Model\ObjectIdentityInterface;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
interface AclSecurityHandlerInterface extends SecurityHandlerInterface
{
    /**
     * Set the permissions not related to an object instance and also to be available when objects do not exist.
     */
    public function setAdminPermissions(array $permissions): void;

    /**
     * Return the permissions not related to an object instance and also to be available when objects do not exist.
     */
    public function getAdminPermissions(): array;

    /**
     * Set the permissions related to an object instance.
     */
    public function setObjectPermissions(array $permissions): void;

    /**
     * Return the permissions related to an object instance.
     */
    public function getObjectPermissions(): array;

    /**
     * Get the ACL for the passed object identity.
     */
    public function getObjectAcl(ObjectIdentityInterface $objectIdentity): ?AclInterface;

    /**
     * Find the ACLs for the passed object identities.
     *
     * @param \Traversable $oids a collection of ObjectIdentityInterface implementations
     * @param array        $sids an array of SecurityIdentityInterface implementations
     *
     * @throws \Exception
     */
    public function findObjectAcls(\Traversable $oids, array $sids = []): \SplObjectStorage;

    /**
     * Add an object owner ACE to the object ACL.
     */
    public function addObjectOwner(AclInterface $acl, ?UserSecurityIdentity $securityIdentity = null): void;

    /**
     * Add the object class ACE's to the object ACL.
     */
    public function addObjectClassAces(AclInterface $acl, array $roleInformation = []): void;

    /**
     * Create an object ACL.
     */
    public function createAcl(ObjectIdentityInterface $objectIdentity): AclInterface;

    /**
     * Update the ACL.
     */
    public function updateAcl(AclInterface $acl): void;

    /**
     * Delete the ACL.
     */
    public function deleteAcl(ObjectIdentityInterface $objectIdentity): void;

    /**
     * Helper method to find the index of a class ACE for a role.
     *
     * @return mixed index if found, FALSE if not found
     */
    public function findClassAceIndexByRole(AclInterface $acl, string $role);

    /**
     * Helper method to find the index of a class ACE for a username.
     *
     * @return mixed index if found, FALSE if not found
     */
    public function findClassAceIndexByUsername(AclInterface $acl, string $username);
}
