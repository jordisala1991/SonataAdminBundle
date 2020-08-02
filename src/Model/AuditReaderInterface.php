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

namespace Sonata\AdminBundle\Model;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
interface AuditReaderInterface
{
    public function find(string $className, int $id, ?int $revision): ?object;

    public function findRevisionHistory(string $className, int $limit = 20, int $offset = 0): array;

    public function findRevision(string $classname, int $revision): object;

    public function findRevisions(string $className, int $id): array;

    public function diff(string $className, int $id, int $oldRevision, int $newRevision): array;
}
