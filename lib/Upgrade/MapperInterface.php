<?php

namespace Upgrade;

interface MapperInterface 
{
    /**
     * @param object $previousVersion
     * @return object $currentVersion
     */
    public function map($previousVersion);
}