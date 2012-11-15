<?php

namespace Difane\Bundle\ContentPartBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ContentPartRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContentPartRepository extends EntityRepository implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    
    public function getContentPart($name)
    {
        try
        {
            $result = $this->getEntityManager()->createQuery('
                SELECT t FROM DifaneContentPartBundle:ContentPart t
                WHERE t.name = :name
            ')
            ->setParameter('name', $name)
            ->getSingleResult();

            $result->setFormatterPool($this->getFormatterPool());
            return $result;
        }
        catch (\Doctrine\ORM\NoResultException $e)
        {
            return null;
        }
    }

    public function getContentParts(array $names)
    {
        try
        {
            $qb = $this->getEntityManager()->createQueryBuilder();

            $qb->select('cp')
                ->from('DifaneContentPartBundle:ContentPart', 'cp')
                ->where($qb->expr()->in('cp.name', $names))
            ;

            $results = $qb->getQuery()->getResult();

            foreach ($results as $result)
            {
                $result->setFormatterPool($this->getFormatterPool());
            }

            return $results;
        }
        catch (\Doctrine\ORM\NoResultException $e)
        {
            return null;
        }
    }
    
    /**
     * Returns formatter pool
     *
     * @return \Sonata\FormatterBundle\Formatter\Pool
     */
    public function getFormatterPool()
    {
        return $this->container->get('sonata.formatter.pool');
    }
    
    /**
     * Sets the Container
     *
     * @param ContainerInterface $container A ContainerInterface instance
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
