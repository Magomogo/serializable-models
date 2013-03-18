<?php

interface PersistedInterface
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

    /**
     * @return array key words
     */
    public function meta();
}