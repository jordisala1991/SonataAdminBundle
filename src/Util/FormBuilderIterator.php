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

namespace Sonata\AdminBundle\Util;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
final class FormBuilderIterator extends \RecursiveArrayIterator
{
    /**
     * @var FormBuilderInterface
     */
    private $formBuilder;

    /**
     * @var bool|string
     */
    private $prefix;

    /**
     * @var \ArrayIterator
     */
    private $iterator;

    /**
     * @param bool|string $prefix
     */
    public function __construct(FormBuilderInterface $formBuilder, $prefix = false)
    {
        parent::__construct();
        $this->formBuilder = $formBuilder;
        $this->prefix = $prefix ? $prefix : $formBuilder->getName();
        $this->iterator = new \ArrayIterator(self::getKeys($formBuilder));
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
    }

    public function valid()
    {
        return $this->iterator->valid();
    }

    public function key()
    {
        $name = $this->iterator->current();

        return sprintf('%s_%s', $this->prefix, $name);
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function current()
    {
        return $this->formBuilder->get($this->iterator->current());
    }

    public function getChildren()
    {
        return new self($this->formBuilder->get($this->iterator->current()), $this->current());
    }

    public function hasChildren()
    {
        return \count(self::getKeys($this->current())) > 0;
    }

    private static function getKeys(FormBuilderInterface $formBuilder): array
    {
        return array_keys($formBuilder->all());
    }
}
