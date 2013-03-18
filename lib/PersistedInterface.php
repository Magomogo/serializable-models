<?php

interface PersistedInterface
{
    public function id();

    public function persisted($id);
}