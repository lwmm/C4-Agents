<?php

namespace Lw\Contentory\Agent\TableTools\SubController;

use \Lw\Contentory\Library\Controller\Controller as BaseController;
use \Lw\Contentory\Library\I18n as I18n;

class Importer extends BaseController
{

    protected $Request;
    protected $Response;
    protected $Transporter;
    protected $Array;

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
        if ($this->Request->getInt("import") == 1) {
            $this->import();
        }

        $this->Response->SetOutputByKey('navigation', $this->showNavigation());
        $this->Response->SetOutputByKey('main', $this->showImportInfo() . $this->showImportForm());

        return $this->Response;
    }

    private function showImportForm()
    {
        $view = $this->getView('ShowImportForm');
        $view->setI18n($this->I18n);
        $view->init($this->Array);
        return $view->render();
    }

    private function showImportInfo()
    {
        if ($this->Request->getInt("import") == 1) {
            $view = $this->getView('ShowImportInfo');
            $view->setI18n($this->I18n);
            $view->init($this->Array);
            return $view->render();
        }
    }

    private function showNavigation()
    {
        $view = $this->getView('Navigation');
        $view->setCmd($this->Request->getAlnum("cmd"));
        return $view->render();
    }

    private function import()
    {
        $this->Transporter->setDebug($this->Request->getInt("debug"));
        $file = $this->Request->getFileData("xmlFile");

        if ($file["tmp_name"] && $file["type"] == "text/xml") {
            $xml = file_get_contents($file["tmp_name"]);
        } else if ($this->Request->getRaw("xmlText")) {
            $xml = $this->Request->getRaw("xmlText");
        }

        $str = $this->Transporter->importXML($xml);

        $this->Array["debug"] = $this->Request->getInt("debug");
        $this->Array["debugOutput"] = $str;
        $this->Array["xml"] = $xml;
    }

}
