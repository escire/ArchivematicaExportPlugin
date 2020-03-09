<?php

/**
 * @file DepositWrapper.inc.php
 *
 * @class DepositWrapper
 * @brief Override OJSSwordDeposit class to generate custom deposit
 */

import('plugins.generic.sword.classes.OJSSwordDeposit');
import('plugins.importexport.archivematica.classes.PackageWrapper');

class DepositWrapper extends OJSSwordDeposit{

	protected $_package = null;
	protected $_outPath = null;

	/**
	 * Constructor
	 * @param $submission Submission object
	 *
	 */
	public function __construct($submission) {
		$this->_article = $submission;

 		// Create a directory for deposit contents
		$this->_outPath = tempnam('/tmp', 'sword');
		unlink($this->_outPath);
		mkdir($this->_outPath);
		mkdir($this->_outPath . '/files');

		// Create a package
		$this->_package = new PackageWrapper(
			$this->_outPath,
			'files',
			$this->_outPath,
			'deposit.zip'
		);


		$journalDao = DAORegistry::getDAO('JournalDAO');
		$this->_context = $journalDao->getById($submission->getContextId());

		$sectionDao = DAORegistry::getDAO('SectionDAO');
		$this->_section = $sectionDao->getById($submission->getSectionId());

		$publishedArticleDao = DAORegistry::getDAO('PublishedArticleDAO');
		$publishedArticle = $publishedArticleDao->getByArticleId($submission->getId());

		$issueDao = DAORegistry::getDAO('IssueDAO');
		if ($publishedArticle) {
			$this->_issue = $issueDao->getById($publishedArticle->getIssueId());
			$this->_article = $publishedArticle;
		}
	}


	/**
	 * Get reference to the package
	 * @return PackageWrapper
	 */
	function getPackage(){
		return $this->_package;
	}


	/**
	 * Create the package and put costum data
	 */
	function createPackage() {
		$submission = $this->_article;

		$package = $this->getPackage();
        // Write the metadata (mets) file
		$fh = @fopen($package->sac_root_in . '/' . $package->sac_dir_in . '/' . $package->sac_metadata_filename, 'w');
		if (!$fh) {
			throw new Exception("Error writing metadata file (" . 
				$package->sac_root_in . '/' . $package->sac_dir_in . '/' . $package->sac_metadata_filename . ")");
		}

		$label = 'journalId-' .  $submission->getData("journalId") . '--' .'issueId-' .  $submission->getData("issueId") . '--' . 'articleId' . $submission->getData("id");
		$package->setLabel($label);
		$package->writeHeader($fh);
		$package->writeDmdSec($fh);
		$package->writeFileGrp($fh);
		$package->writeStructMap($fh);
		$package->writeFooter($fh);    
		fclose($fh);

        // Create the zipped package (force an overwrite if it already exists)
		$zip = new ZipArchive();
		$zip->open($package->sac_root_out . '/' . $package->sac_file_out, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
		$zip->addFile($package->sac_root_in . '/' . $package->sac_dir_in . '/mets.xml', 
			'mets.xml');
		for ($i = 0; $i < $package->sac_filecount; $i++) {
			$zip->addFile($package->sac_root_in . '/' . $package->sac_dir_in . '/' . $package->sac_files[$i], 
				$package->sac_files[$i]);
		}
		$zip->close();
	}


	/**
	 * Init curl
	 * @param $sac_url URL of Archivematica Storage service
	 * @param $sac_user Username
	 * @param $sac_password Password
	 */
	function curl_init($sac_url, $sac_user, $sac_password) {
		$sac_curl = curl_init();

		curl_setopt($sac_curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($sac_curl, CURLOPT_URL, $sac_url);

		if(!empty($sac_user) && !empty($sac_password)) {
			curl_setopt($sac_curl, CURLOPT_USERPWD, $sac_user . ":" . $sac_password);
		}

		return $sac_curl;
	}

}
