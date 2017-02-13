<?php

namespace DimadUserBundle;
use \FOS\UserBundle\FOSUserBundle;

class DimadUserBundle extends FOSUserBundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}