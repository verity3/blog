<?php

namespace BlogBundle\Extension\Entity;

use BlogBundle\Extension\Entity\ShortId;

/**
 * SecureRepository
 *
 * 
 */
trait SecureRepository {

    protected static $cache_ttl = 3600;

    // protected static $secure_code = 'my_secure_code';

    /**
     * Encrypt ID
     *
     * @param  integer $id
     * @return string
     */
    public static function secure($id) {
        return ShortId::parse($id, false, 6, static::$secure_code);
        ;
    }

    /**
     * Decrypt ID
     *
     * @param  string  $id
     * @return integer
     */
    public static function unsecure($id) {
        return ShortId::parse($id, true, 6, static::$secure_code);
    }

    /**
     * get query for secure ID
     *
     * @param  integer     $id
     * @return object|null
     */
    public function getQueryBySecureId($id) {
        $query = $this->createQueryBuilder('t')
                ->where('t.id = :id')
                ->setParameter('id', static::unsecure($id));

        return $query;
    }

    /**
     * Find all by secure ids
     *
     * @param  array $ids
     * @return array
     */
    public function findBySecureIds(array $ids = null) {
        foreach ($ids as $key => $id) {
            $ids[$key] = static::unsecure($id);
        }

        $result = $this->createQueryBuilder('t')
                ->where('t.id IN (:ids)')
                ->setParameter('ids', $ids)
                ->setMaxResults(2500)
                ->getQuery()
                ->getResult();

        return $result;
    }

    /**
     * find single company language by secure ID
     *
     * @param  integer     $id
     * @return object|null
     */
    public function findOneBySecureId($id) {
        $result = $this->getQueryBySecureId($id)
                ->getQuery()
                ->getOneOrNullResult();

        return $result;
    }

   

}
