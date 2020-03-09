<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/plugins/generic/sword/libs/swordappv2/packager_mets_swap.php';


/**
 * @file PackageWrapper.inc.php
 *
 * @class PackageWrapper
 * @brief Override PackagerMetsSwap class
 */

class PackageWrapper extends PackagerMetsSwap{



	var $label = "";

	function setLabel($label){
		$this->label = $label;
	}

	function getLabel(){
		return $this->label;
	}

    /**
     * Create the package and put costum data
      @param $fh File to write
     */
      function writeHeader($fh) {
        fwrite($fh, "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"no\" ?" . ">\n");
        fwrite($fh, "<mets ID=\"sort-mets_mets\" OBJID=\"sword-mets\" LABEL=\"" . $this->getLabel() . "\" PROFILE=\"DSpace METS SIP Profile 1.0\" xmlns=\"http://www.loc.gov/METS/\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.loc.gov/METS/ http://www.loc.gov/standards/mets/mets.xsd\">\n");
        fwrite($fh, "\t<metsHdr CREATEDATE=\"2008-09-04T00:00:00\">\n");
        fwrite($fh, "\t\t<agent ROLE=\"CUSTODIAN\" TYPE=\"ORGANIZATION\">\n");
        if (isset($this->sac_custodian)) { fwrite($fh, "\t\t\t<name>$this->sac_custodian</name>\n"); }
        else { fwrite($fh, "\t\t\t<name>Unknown</name>\n"); }
        fwrite($fh, "\t\t</agent>\n");
        fwrite($fh, "\t</metsHdr>\n");
    }


}