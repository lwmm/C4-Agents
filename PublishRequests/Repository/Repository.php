<?php

namespace Lw\Contentory\Agent\PublishRequests\Repository;

use Lw\Contentory\Agent\PublishRequests\Repository\QueryHandler as QueryHandler;

class Repository
{

    public function __construct()
    {
        $this->QueryHandler = new QueryHandler(\lw_registry::getInstance()->getEntry("db"), \lw_registry::getInstance()->getEntry("auth"));
    }

    public function getAllPagesWithPublishRequests()
    {
        return $this->QueryHandler->getAllPagesWithPublishRequests();
    }

}
