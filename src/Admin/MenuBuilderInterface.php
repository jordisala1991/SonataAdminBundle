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

namespace Sonata\AdminBundle\Admin;

use Knp\Menu\ItemInterface;

/**
 * This interface can be implemented by admins that need to build menus.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
interface MenuBuilderInterface
{
    /**
     * Build the tab menu related to the current action.
     *
     * @return ItemInterface|bool
     */
    public function buildTabMenu(string $action, ?AdminInterface $childAdmin = null);
}
