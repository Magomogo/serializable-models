<?php

namespace Upgrade;

interface MapperInterface 
{
    /**
     * @param \PersistedInterface $previousVersion
     * @return \PersistedInterface $currentVersion
     */
    public function map($previousVersion);
}