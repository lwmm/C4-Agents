<?php

namespace Lw\Contentory\Agent\UserProfil\Repository;

class QueryHandler extends \Lw\Contentory\Repository\QueryHandler
{

    protected $db;
    protected $Auth;

    public function __construct($db, $auth)
    {
        parent::__construct($db, $auth);
        $this->Auth = $auth;
    }

    public function getShortcuts()
    {
        $config = \lw_registry::getInstance()->getEntry("config");

        if ($config['custom']['staticshortcuts'] == "1") {
            $array[] = array("id" => 1, "name" => "Benutzer", "shortcut" => "user", "rights" => "user");
            $array[] = array("id" => 2, "name" => "Benutzerprofil", "shortcut" => "userprofil", "rights" => "all");
            $array[] = array("id" => 3, "name" => "Content Objekte", "shortcut" => "cobject", "rights" => "cbox");
            $array[] = array("id" => 4, "name" => "Elemente", "shortcut" => "items", "rights" => "all");
            $array[] = array("id" => 5, "name" => "Projekte", "shortcut" => "projects", "rights" => "project");
            $array[] = array("id" => 6, "name" => "Rollen", "shortcut" => "roles", "rights" => "admin");
            $array[] = array("id" => 7, "name" => "Seitenkategorien", "shortcut" => "pagecats", "rights" => "pagecats");
            $array[] = array("id" => 8, "name" => "Seitenkommentare", "shortcut" => "pagecomments", "rights" => "all");
            $array[] = array("id" => 9, "name" => "Seitentypen", "shortcut" => "types", "rights" => "pagetypes");
            $array[] = array("id" => 10, "name" => "Vorlagen", "shortcut" => "template", "rights" => "layout");
        } else {
            $this->db->setStatement("SELECT * FROM t:lw_functions WHERE visible = 1 ORDER BY name ");
            $array = $this->db->pselect();
        }
        foreach ($array as $single) {
            $rights = explode(",", $single['rights']);
            $ok = false;
            foreach ($rights as $right) {
                if ($this->auth->isAllowed($right) || $right == "all") {
                    $ok = true;
                }
            }
            if ($ok) {
                $out[] = $single;
            }
        }
        return $out;
    }

    public function getUser()
    {
        $this->db->setStatement("SELECT id, name, firstname, lastname, email, shortcut1, shortcut2, shortcut3, shortcut4, shortcut5, lw_version FROM t:lw_user WHERE id = :id ");
        $this->db->bindParameter("id", "i", $this->Auth->getUserdata("id"));

        return $this->db->pselect1();
    }

    public function getVersion()
    {
        $this->db->setStatement("SELECT lw_version FROM t:lw_user WHERE id = :id ");
        $this->db->bindParameter("id", "i", $this->Auth->getUserdata("id"));

        $result = $this->db->pselect1();
        return $result["lw_version"];
    }

    public function isNameExisting($name)
    {
        $this->db->setStatement("SELECT * FROM t:lw_user WHERE name = :name ");
        $this->db->bindParameter("name", "s", $name);

        $result = $this->db->pselect1();

        if (empty($result)) {
            return false;
        }
        return true;
    }

}
