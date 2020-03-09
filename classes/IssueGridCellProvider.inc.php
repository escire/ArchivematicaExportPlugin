<?php
/**
 * @file IssueGridCellProvider.inc.php
 */

import('lib.pkp.classes.controllers.grid.GridCellProvider');

class IssueGridCellProvider extends GridCellProvider {

	var $issueDao;

	/**
	 * Constructor
	 */
	function __construct(){
		$this->issueDao = DAORegistry::getDAO('IssueDAO');
	}


	/**
	 * Action for each row, manage the article deposit's by issue 
	 * @return LinkAction
	 */
	function getCellActions($request, $row, $column, $position = GRID_ACTION_POSITION_DEFAULT) {
		if ($column->getId() == 'export_articles_button') {
			$issue = $row->getData();
			assert(is_a($issue, 'Issue'));
			$router = $request->getRouter();
			import('lib.pkp.classes.linkAction.request.AjaxModal');

			$url = explode('/', $request->_requestPath);
			unset($url[count($url) - 1]);
			return array(
				new LinkAction(
					'edit',
					new AjaxModal(
						implode('/', $url) . '/articles?issueId=' . $issue->getId()
						,
						__('editor.issues.editIssue', array('issueIdentification' => $issue->getIssueIdentification())),
						'modal_edit',
						true
					),
					'<input type="button" value="' . __("plugins.importexport.archivematica.exportSelectedArticles") . '" class="pkp_button submitFormButton" id="openModalArticles" />'
				)
			);
		}
		return array();
	}


	/**
	 * Asign content for each column cell
	 */
	function getTemplateVarsFromRowColumn($row, $column) {
		$issue = $row->getData();
		$issueId = $issue->getId();
		$issueCount = ArchivematicaExportPlugin::getDepositedFilesByIsisueId($issueId);


		switch ($column->getId()) {
			case 'select':
			$component = '<input type="checkbox" name="selectedIssues[]" value="' . $issueId . '" />';
			return array('label' => $component);
			case 'export_articles_button':
			return array('label' => '');

			case 'number':
			return array('label' => $issue->getIssueIdentification());
			case 'article':

			$numArticles = $this->issueDao->getNumArticles($issueId);

			return array('label' => $issueCount .' / ' . $numArticles);
			
			case 'status':
			$numArticles = $this->issueDao->getNumArticles($issueId);

			if($issueCount != 0){
				if($issueCount != $numArticles){
					$status = '<span class="dot dot-not-all"></span>';
				}
				else{
					$status = '<span class="dot dot-deposited"></span>';
				}
			}else{
				$status = '<span class="dot dot-not-deposited"></span>';
			}

			return array('label' => $status);
		}
		assert(false);
	}
}

