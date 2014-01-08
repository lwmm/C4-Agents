<?php

namespace Lw\Contentory\Agent\UserProfil\Repository;

use Lw\Contentory\Agent\UserProfil\Repository\QueryHandler as QueryHandler;
use Lw\Contentory\Agent\UserProfil\Repository\StorageHandler as StorageHandler;

class Repository
{

    protected $QueryHandler;
    protected $StorageHandler;

    public function __construct()
    {
        $this->QueryHandler = new QueryHandler(\lw_registry::getInstance()->getEntry("db"), \lw_registry::getInstance()->getEntry("auth"));
        $this->StorageHandler = new StorageHandler(\lw_registry::getInstance()->getEntry("db"), \lw_registry::getInstance()->getEntry("auth"));
    }

    public function getShortcuts()
    {
        return $this->QueryHandler->getShortcuts();
    }

    public function getUser()
    {
        return $this->QueryHandler->getUser();
    }

    public function getVersion()
    {
        return $this->QueryHandler->getVersion();
    }

    public function isNameExisting($name)
    {
        return $this->QueryHandler->isNameExisting($name);
    }

    public function saveUser($dto)
    {
        $this->StorageHandler->saveUser($dto);
        $this->StorageHandler->logAction('user', $dto->getValueByKey("id"), 'update', 'Userprofile for user ' . $dto->getValueByKey("id") . ' updated (' . $dto->getValueByKey("name") . ') ');
        return true;
    }

}
