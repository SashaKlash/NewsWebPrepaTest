<?php

namespace NewsWeb\Manager;

use Exception;
use NewsWeb\Interface\ManagerInterface;
use NewsWeb\Mapping\thecommentMapping;
use NewsWeb\MyPDO;

class thecommentManager implements ManagerInterface {

    private MyPDO $connect;

    public function __construct(MyPDO $db)
    {
        this->connect = $db;
    }

    public function thecommentSelectAllByIdthearicle (int $idthearticle) : array
    {
        $sql = "SELECT 
                c.idthecomment, c.thecommenttext, c.thecommentactive, a.idthearticle, a.thearticleactivate, u.idtheuser, u.theuserlogin
                FROM thecomment c 
                    
                INNER JOIN thearticle a ON a.idthearticle = ahc.thearticle_dithearticle
                WHERE a.thearticleativate=1
                        AND a.idthearticle = ? 
                "
    }
}