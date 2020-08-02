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

namespace Sonata\AdminBundle\Form\DataTransformer;

use Sonata\AdminBundle\Model\ModelManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
final class ModelToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ModelManagerInterface
     */
    private $modelManager;

    /**
     * @var string
     */
    private $className;

    public function __construct(ModelManagerInterface $modelManager, string $className)
    {
        $this->modelManager = $modelManager;
        $this->className = $className;
    }

    public function reverseTransform($newId)
    {
        if (empty($newId) && !\in_array($newId, ['0', 0], true)) {
            return null;
        }

        return $this->modelManager->find($this->className, $newId);
    }

    public function transform($model)
    {
        if (empty($model)) {
            return null;
        }

        return $this->modelManager->getNormalizedIdentifier($model);
    }
}
