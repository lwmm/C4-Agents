<?php

namespace Lw\Contentory\Agent\UserProfil\Repository;

use \Lw\Library\DTO as DTO;

class StorageHandler extends \Lw\Contentory\Repository\QueryHandler
{

    protected $db;

    public function __construct($db, $auth)
    {
        parent::__construct($db, $auth);
    }

    public function logAction($item, $item_id, $action, $data = false)
    {
        $this->db->setStatement('INSERT INTO t:lw_slog (user_id, item_type, item_id, action, timestamp, lw_date, browser, ip_address, data) VALUES (:user_id, :item_type, :item_id, :action, :timestamp, :lw_date, :browser, :ip_address, :data)');
        $this->db->bindParameter('user_id', 'i', $this->auth->getUserdata('id'));
        $this->db->bindParameter('item_type', 's', $item);
        $this->db->bindParameter('item_id', 's', $item_id);
        $this->db->bindParameter('action', 's', $action);
        $this->db->bindParameter('timestamp', 'i', time());
        $this->db->bindParameter('lw_date', 'i', date('YmdHis'));
        $this->db->bindParameter('browser', 's', $_SERVER['HTTP_USER_AGENT']);
        $this->db->bindParameter('ip_address', 's', $this->getRealIP());
        $this->db->bindParameter('data', 's', $data);
        return $this->db->pdbquery();
    }

    private function getRealIP()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $IP = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $IP = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $IP = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $IP = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $IP = getenv('HTTP_FORWARDED');
        } else {
            $IP = $_SERVER['REMOTE_ADDR'];
        }
        return $IP;
    }

    public function saveUser(DTO $dto)
    {
        $pass = $dto->getValueByKey("password");

        if (strlen($pass) >= 5) {
            $this->db->setStatement("UPDATE t:lw_user SET name = :name, password = :password, firstname = :firstname, email = :email, shortcut1 = :shortcut1, shortcut2 = :shortcut2, shortcut3 = :shortcut3, shortcut4 = :shortcut4, shortcut5 = :shortcut5, lw_version = :lw_version WHERE id = :id ");
            $this->db->bindParameter("password", "s", md5(trim($dto->getValueByKey("password"))));
        } else {
            $this->db->setStatement("UPDATE t:lw_user SET name = :name, firstname = :firstname, email = :email, shortcut1 = :shortcut1, shortcut2 = :shortcut2, shortcut3 = :shortcut3, shortcut4 = :shortcut4, shortcut5 = :shortcut5, lw_version = :lw_version WHERE id = :id ");
        }
        $this->db->bindParameter("id", "i", $dto->getValueByKey("id"));
        $this->db->bindParameter("name", "s", $dto->getValueByKey("name"));
        $this->db->bindParameter("firstname", "s", $dto->getValueByKey("firstname"));
        $this->db->bindParameter("lastname", "s", $dto->getValueByKey("lastname"));
        $this->db->bindParameter("email", "s", $dto->getValueByKey("email"));
        $this->db->bindParameter("shortcut1", "i", $dto->getValueByKey("shortcut1"));
        $this->db->bindParameter("shortcut2", "i", $dto->getValueByKey("shortcut2"));
        $this->db->bindParameter("shortcut3", "i", $dto->getValueByKey("shortcut3"));
        $this->db->bindParameter("shortcut4", "i", $dto->getValueByKey("shortcut4"));
        $this->db->bindParameter("shortcut5", "i", $dto->getValueByKey("shortcut5"));
        $this->db->bindParameter("lw_version", "i", $dto->getValueByKey("lw_version") + 1);

        return $this->db->pdbquery();
    }

}
