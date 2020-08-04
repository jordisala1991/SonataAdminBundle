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

namespace Sonata\AdminBundle\Filter;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
interface FilterInterface
{
    public const CONDITION_OR = 'OR';

    public const CONDITION_AND = 'AND';

    /**
     * Apply the filter to the QueryBuilder instance.
     *
     * @param mixed[] $value
     */
    public function filter(ProxyQueryInterface $queryBuilder, string $alias, string $field, array $value): void;

    /**
     * @param mixed $value
     */
    public function apply(ProxyQueryInterface $queryBuilder, $value): void;

    /**
     * Returns the filter name.
     */
    public function getName(): ?string;

    /**
     * Returns the filter form name.
     */
    public function getFormName(): string;

    /**
     * Returns the label name.
     *
     * @return string|bool
     */
    public function getLabel();

    public function setLabel(string $label): void;

    /**
     * @return array<string, mixed>
     */
    public function getDefaultOptions(): array;

    /**
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getOption(string $name, $default = null);

    /**
     * @param mixed $value
     */
    public function setOption(string $name, $value): void;

    /**
     * @param array<string, mixed> $options
     */
    public function initialize(string $name, array $options = []): void;

    public function getFieldName(): ?string;

    /**
     * @return array<string, string> array of mappings
     */
    public function getParentAssociationMappings(): array;

    /**
     * @return array<string, string> field mapping
     */
    public function getFieldMapping(): array;

    /**
     * @return array<string, string>  association mapping
     */
    public function getAssociationMapping(): array;

    /**
     * @return array<string, mixed>
     */
    public function getFieldOptions(): array;

    /**
     * Get field option.
     *
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getFieldOption(string $name, $default = null);

    /**
     * Set field option.
     *
     * @param mixed $value
     */
    public function setFieldOption(string $name, $value): void;

    public function getFieldType(): string;

    /**
     * Returns the main widget used to render the filter.
     *
     * @return array{0: string, 1: array<string, mixed>}
     */
    public function getRenderSettings(): array;

    /**
     * Returns true if filter is active.
     */
    public function isActive(): bool;

    /**
     * Set the condition to use with the left side of the query : OR or AND.
     */
    public function setCondition(string $condition): void;

    public function getCondition(): ?string;

    public function getTranslationDomain(): ?string;
}
