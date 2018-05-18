<?php

namespace NewsBundle\Extension\Entity;

/**
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
trait Secure
{

    /**
     * Generate secure of ID
     * 
     * @return string
     */
    public function getSecureId()
    {
        $className = get_class($this);
        $className = str_replace('Proxies\__CG__', null, $className);

        return call_user_func("{$className}Repository::secure", $this->id);
    }

    /**
     * Make hash sign of secure ID
     * 
     * @return string
     */
    public function getHashSecureId()
    {
        $hashSecureId = substr(md5($this->getSecureId()), 0, 8);
        return $hashSecureId;
    }

}
