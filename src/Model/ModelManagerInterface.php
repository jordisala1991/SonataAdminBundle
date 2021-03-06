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
    /**
     * @param string $class
     * @param string $name
     *
     * @return FieldDescriptionInterface
     */
    public function getNewFieldDescriptionInstance($class, $name, array $options = []);

    /**
     * @param object $object
     *
     * @throws ModelManagerException
     */
    public function create($object);

    /**
     * @param object $object
     *
     * @throws ModelManagerException
     */
    public function update($object);

    /**
     * @param object $object
     *
     * @throws ModelManagerException
     */
    public function delete($object);

    /**
     * @param string $class
     *
     * @return array all objects matching the criteria
     */
    public function findBy($class, array $criteria = []);

    /**
     * @param string $class
     *
     * @return object|null an object matching the criteria or null if none match
     */
    public function findOneBy($class, array $criteria = []);

    /**
     * @param string $class
     * @param mixed  $id
     *
     * @return object|null the object with id or null if not found
     */
    public function find($class, $id);

    /**
     * @param string $class
     *
     * @throws ModelManagerException
     */
    public function batchDelete($class, ProxyQueryInterface $queryProxy);

    /**
     * @param string $class
     * @param string $alias
     *
     * @return ProxyQueryInterface
     */
    public function createQuery($class, $alias = 'o');

    /**
     * Get the identifiers of this model class.
     *
     * This returns an array to handle cases like a primary key that is
     * composed of multiple columns. If you need a string representation,
     * use getNormalizedIdentifier resp. getUrlSafeIdentifier
     *
     * @param object $model
     *
     * @return array list of all identifiers of this model
     */
    public function getIdentifierValues($model);

    /**
     * Get a list of the field names models of the specified class use to store
     * the identifier.
     *
     * @param string $class fully qualified class name
     *
     * @return array
     */
    public function getIdentifierFieldNames($class);

    /**
     * Get the identifiers for this model class as a string.
     *
     * @param object $model
     *
     * @return string a string representation of the identifiers for this
     *                instance
     */
    public function getNormalizedIdentifier($model);

    /**
     * Get the identifiers as a string that is safe to use in a url.
     *
     * This is similar to getNormalizedIdentifier but guarantees an id that can
     * be used in a URL.
     *
     * @param object $model
     *
     * @return string string representation of the id that is safe to use in a url
     */
    public function getUrlSafeIdentifier($model);

    /**
     * Create a new instance of the model of the specified class.
     *
     * @param string $class
     *
     * @return object
     */
    public function getModelInstance($class);

    /**
     * @param string $class
     *
     * @return array|\ArrayAccess
     */
    public function getModelCollectionInstance($class);

    /**
     * Removes an element from the collection.
     *
     * @param array  $collection
     * @param object $element
     */
    public function collectionRemoveElement(&$collection, &$element);

    /**
     * Add an element from the collection.
     *
     * @param array  $collection
     * @param object $element
     */
    public function collectionAddElement(&$collection, &$element);

    /**
     * Check if the element exists in the collection.
     *
     * @param array  $collection
     * @param object $element
     *
     * @return bool
     */
    public function collectionHasElement(&$collection, &$element);

    /**
     * Clear the collection.
     *
     * @param array $collection
     */
    public function collectionClear(&$collection);

    /**
     * @param string $class
     *
     * @return object
     */
    public function modelReverseTransform($class, array $array = []);

    /**
     * @param string $class
     * @param object $instance
     *
     * @return object
     */
    public function modelTransform($class, $instance);

    /**
     * @param mixed $query
     */
    public function executeQuery($query);

    /**
     * @param int|null $firstResult
     * @param int|null $maxResult
     *
     * @return SourceIteratorInterface
     */
    public function getDataSourceIterator(
        DatagridInterface $datagrid,
        array $fields,
        $firstResult = null,
        $maxResult = null
    );

    /**
     * @param string $class
     *
     * @return string[]
     */
    public function getExportFields($class);

    /**
     * @param string $class
     */
    public function addIdentifiersToQuery($class, ProxyQueryInterface $query, array $idx);
}
