<?php

namespace Lw\Contentory\Agent\TableTools\SubController;

use \Lw\Contentory\Library\Controller\Controller as BaseController;
use \Lw\Contentory\Library\I18n as I18n;
use \Lw\Contentory\Agent\TableTools\Repository\Repository as Repository;

class Exporter extends BaseController
{

    protected $Request;
    protected $Transporter;
    protected $Array;
    protected $Response;
    protected $I18n;

    public function __construct($Id, $Configuration, $Language)
    {
        parent::__construct($Configuration, $Language);
        $this->I18n = I18n::getInstance($Language, "Lw/Contentory/Agent/TableTools/View/I18n/");

        $this->ObjectIdentifier = 'tabletools';
        $this->Agent = 'TableTools';

        $this->Request = \lw_registry::getInstance()->getEntry("request");
        $this->Transporter = new \lw_db_transporter();
    }

    public function execute()
    {
        $this->init();

        if ($this->Request->getInt("export") == 1 && $this->Request->getInt("download") && count($this->Request->getRaw("tables")) > 0) {
            $this->xmlDownload();
        }

        $this->Response->SetOutputByKey('navigation', $this->showNavigation());
        $this->Response->SetOutputByKey('main', $this->showXml() . $this->showTableList());

        return $this->Response;
    }

    private function init()
    {
        $this->Array = array(
            "tables" => $this->prefixFilter($this->Transporter->getAllTables(), $this->Request->getRaw("prefix_filter")),
            "filter" => $this->Request->getRaw("prefix_filter"),
            "selectedTables" => $this->Request->getRaw("tables"),
            "tableLines" => $this->getLineCountForEachTable()
        );
    }

    private function showTableList()
    {
        $view = $this->getView('ShowList');
        $view->setI18n($this->I18n);
        $view->init($this->Array);
        return $view->render();
    }

    private function showXml()
    {
        if ($this->Request->getInt("export") == 1) {
            $view = $this->getView('ShowXml');
            $view->setXml($this->getXML());
            return $view->render();
        }
    }

    private function showNavigation()
    {
        $view = $this->getView('Navigation');
        $view->setCmd($this->Request->getAlnum("cmd"));
        return $view->render();
    }

    private function xmlDownload()
    {
        $view = $this->getView('DownloadXml');
        $view->downloadXml($this->getXML(), $this->Request->getAlnum("type"));
    }

    private function prefixFilter($tables, $prefix_filter)
    {
        if ($prefix_filter) {
            $temp = $tables;
            foreach ($temp as $key => $value) {
                $prefix = substr($value, 0, strlen($prefix_filter));
                if ($prefix != $prefix_filter) {
                    unset($tables[$key]);
                }
            }
        }
        return $tables;
    }

    private function getLineCountForEachTable()
    {
        $repository = new Repository();

        $tables = $this->Transporter->getAllTables();
        $array = array();

        foreach ($tables as $table) {
            $array[$table] = $repository->getLineCountByTableName($table);
        }

        return $array;
    }

    private function getXML()
    {
        if (count($this->Request->getRaw("tables")) > 0) {
            if ($this->Request->getAlnum("type") == 'data') {
                $xml = $this->Transporter->exportData($this->Request->getRaw("tables"));
            } else {
                $xml = $this->Transporter->exportTables($this->Request->getRaw("tables"));
            }

            return $xml;
        }
    }

}