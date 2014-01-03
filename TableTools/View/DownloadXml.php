<?php

namespace Lw\Contentory\Agent\TableTools\View;
use Lw\Contentory\Library\View\View as View;

class DownloadXml extends View
{
    protected $view;

    public function __construct()
    {
        parent::__construct();
    }
    
    public function downloadXml($xml, $type)
    {
        if ($type == 'data') {
            $filename = date('YmdHis') . "_exportData.xml";
        } else {
            $filename = date('YmdHis') . "_exportStructure.xml";
        }

        $mimeType = \lw_io::getMimeType("xml");
        if (strlen($mimeType) < 1) {
            $mimeType = "application/octet-stream";
        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: " . $mimeType);
        header("Content-disposition: attachment; filename=\"" . $filename . "\"");
        die($xml);
        exit();
    }
}