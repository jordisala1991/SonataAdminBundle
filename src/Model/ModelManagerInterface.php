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

use Doctrine\Common\Collections\Collection;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\Exporter\Source\SourceIteratorInterface;

/**
 * A model manager is a bridge between the model classes and the admin functionality.
 */
interface ModelManagerInterface extends DatagridManagerInterface
{
    public function getNewFieldDescriptionInstance(string $class, string $name, array $options = []): FieldDescriptionInterface;

    /**
     * @throws ModelManagerException
     */
    public function create(object $object): void;

    /**
     * @throws ModelManagerException
     */
    public function update(object $object): void;

    /**
     * @throws ModelManagerException
     */
    public function delete(object $object): void;

    public function findBy(string $class, array $criteria = []): array;

    public function findOneBy(string $class, array $criteria = []): ?object;

    /**
     * @param mixed $id
     */
    public function find(string $class, $id): ?object;

    /**
     * @throws ModelManagerException
     */
    public function batchDelete(string $class, ProxyQueryInterface $queryProxy): void;

    public function createQuery(string $class, string $alias = 'o'): ProxyQueryInterface;

    /**
     * Get the identifiers of this model class.
     *
     * This returns an array to handle cases like a primary key that is
     * composed of multiple columns. If you need a string representation,
     * use getNormalizedIdentifier resp. getUrlSafeIdentifier
     */
    public function getIdentifierValues(object $model): array;

    /**
     * Get a list of the field names models of the specified class use to store
     * the identifier.
     */
    public function getIdentifierFieldNames(?string $class): array;

    /**
     * Get the identifiers for this model class as a string.
     */
    public function getNormalizedIdentifier(object $model): string;

    /**
     * Get the identifiers as a string that is safe to use in a url.
     *
     * This is similar to getNormalizedIdentifier but guarantees an id that can
     * be used in a URL.
     */
    public function getUrlSafeIdentifier(object $model): string;

    /**
     * Create a new instance of the model of the specified class.
     */
    public function getModelInstance(string $class): object;

    public function getModelCollectionInstance(string $class): Collection;

    /**
     * Removes an element from the collection.
     */
    public function collectionRemoveElement(array &$collection, object &$element): bool;

    /**
     * Add an element from the collection.
     */
    public function collectionAddElement(array &$collection, object &$element): bool;

    /**
     * Check if the element exists in the collection.
     */
    public function collectionHasElement(array &$collection, object &$element): bool;

    /**
     * Clear the collection.
     */
    public function collectionClear(array &$collection): void;

    public function modelReverseTransform(string $class, array $array = []): object;

    public function modelTransform(string $class, object $instance): object;

    /**
     * @param mixed $query
     *
     * @return mixed
     */
    public function executeQuery($query);

    public function getDataSourceIterator(
        DatagridInterface $datagrid,
        array $fields,
        ?int $firstResult = null,
        ?int $maxResult = null
    ): SourceIteratorInterface;

    public function getExportFields(string $class): array;

    public function addIdentifiersToQuery(string $class, ProxyQueryInterface $query, array $idx): void;
}
