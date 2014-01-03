<?php

namespace Lw\Contentory\Agent\PageComments\Repository;

use Lw\Contentory\Agent\PageComments\Repository\QueryHandler as QueryHandler;

class Repository
{

    public function __construct()
    {
        $this->QueryHandler = new QueryHandler(\lw_registry::getInstance()->getEntry("db"), \lw_registry::getInstance()->getEntry("auth"));
    }

    public function getAllPagesWithComments()
    {
        return $this->QueryHandler->getAllPagesWithComments();
    }

}
