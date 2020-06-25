<?php
/**
 * @file SubmissionGridCellProvider.inc.php
 */
import('lib.pkp.classes.controllers.grid.GridCellProvider');

class SubmissionGridCellProvider extends GridCellProvider {

	/**
	 * Asign content for each column cell
	 * @return Label string
	 */
	function getTemplateVarsFromRowColumn($row, $column) {
		$submission = $row->getData();

		$submissionId = $submission->getId();

		switch ($column->getId()) {
			case 'select':
				$component = '<input type="checkbox" name="selectedSubmissions[]" value="' .$submissionId. '" />';
			return array('label' => $component);
			case 'article':
			return array('label' => $submission->getLocalizedTitle(null));
			case 'status':
			$data = $submission->getAllData();
			if (array_key_exists('depositUUID', $data)) {
					$status = '<span class="dot dot-deposited"></span>';
			}else{
				$status = '<span class="dot dot-not-deposited "></span>';
			}

			return array('label' => $status);
		}
		assert(false);
	}
}
