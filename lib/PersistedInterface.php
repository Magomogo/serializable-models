<?php

interface PersistedInterface extends Serializable
{
    /**
     * @return integer
     */
    public function id();

    /**
     * @param integer $id
     * @return self
     */
    public function persisted($id);
}