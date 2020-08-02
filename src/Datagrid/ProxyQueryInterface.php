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

namespace Sonata\AdminBundle\Datagrid;

/**
 * Used by the Datagrid to build the query.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
interface ProxyQueryInterface
{
    /**
     * @return mixed
     */
    public function __call(string $name, array $args);

    /**
     * @return mixed
     */
    public function execute(array $params = [], ?int $hydrationMode = null);

    public function setSortBy(array $parentAssociationMappings, array $fieldMapping): self;

    public function getSortBy(): string;

    public function setSortOrder(string $sortOrder): self;

    public function getSortOrder(): string;

    /**
     * @return mixed
     */
    public function getSingleScalarResult();

    public function setFirstResult(?int $firstResult): self;

    /**
     * @return mixed
     */
    public function getFirstResult();

    public function setMaxResults(?int $maxResults): self;

    public function getMaxResults(): ?int;

    public function getUniqueParameterId(): int;

    public function entityJoin(array $associationMappings): string;
}
