<?php

/*
 * This file is part of Monsieur Biz' menu plugin for Sylius.
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusMenuPlugin\Repository;

use MonsieurBiz\SyliusMenuPlugin\Entity\MenuInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository implements MenuRepositoryInterface
{
    public function findOneByLocaleAndCode(string $localeCode, string $code): ?MenuInterface
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->addSelect('item')
            ->addSelect('item_translation')
            ->innerJoin('o.items', 'item')
            ->innerJoin('item.translations', 'item_translation', 'WITH', 'item_translation.locale = :locale')
            ->where('o.code = :code')
            ->setParameter('locale', $localeCode)
            ->setParameter('code', $code)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
