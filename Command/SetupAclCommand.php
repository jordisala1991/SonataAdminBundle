<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

use Symfony\Component\Security\Acl\Model\AclInterface;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Sonata\AdminBundle\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Exception\AclAlreadyExistsException;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

class SetupAclCommand extends Command
{
    public function configure()
    {
        $this->setName('sonata:admin:setup-acl');
        $this->setDescription('Install ACL for Admin Classes');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $aclProvider = $this->container->get('security.acl.provider');

        $output->writeln('Starting ACL AdminBundle configuration');

        $builder = new MaskBuilder();
        foreach ($this->container->get('sonata.admin.pool')->getAdminServiceIds() as $id) {
            $output->writeln(sprintf(' > install ACL for %s', $id));

            try {
                $admin = $this->container->get($id);
            } catch (\Exception $e) {
                $output->writeln('<error>Warning : The admin class cannot be initiated from the command line</error>');
                $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
                continue;
            }

            $objectIdentity = ObjectIdentity::fromDomainObject($admin);
            try {
                $acl = $aclProvider->findAcl($objectIdentity);
            } catch(AclNotFoundException $e) {
                $acl = $aclProvider->createAcl($objectIdentity);
            }

            $this->configureACL($output, $acl, $builder, $admin->getAclInformation());

            $aclProvider->updateAcl($acl);
        }
    }

    public function configureACL(OutputInterface $output, AclInterface $acl, MaskBuilder $builder, array $aclInformations = array())
    {
        foreach ($aclInformations as $name => $masks) {
            foreach ($masks as $mask) {
                $builder->add($mask);
            }

            $acl->insertClassAce(new RoleSecurityIdentity($name), $builder->get());

            $output->writeln(sprintf('   - add role: %s, ACL: %s', $name, json_encode($masks)));

            $builder->reset();
        }
    }
}