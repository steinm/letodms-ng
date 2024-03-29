<?php
/**
 * Implementation of IndexInfo view
 *
 * @category   DMS
 * @package    LetoDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("class.Bootstrap.php");

/**
 * Class which outputs the html page for IndexInfo view
 *
 * @category   DMS
 * @package    LetoDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class LetoDMS_View_IndexInfo extends LetoDMS_Bootstrap_Style {

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$luceneclassdir = $this->params['luceneclassdir'];
		$lucenedir = $this->params['lucenedir'];
		$index = $this->params['index'];

		$this->htmlStartPage(getMLText('fulltext_info'));
		$this->globalNavigation();
		$this->contentStart();
		$this->pageNavigation(getMLText("admin_tools"), "admin_tools");
		$this->contentHeading(getMLText("fulltext_info"));
		$this->contentContainerStart();

		$numDocs = $index->count();
		echo "<pre>";
		for ($id = 0; $id < $numDocs; $id++) {
			if (!$index->isDeleted($id)) {
				$hit = $index->getDocument($id);
				echo $hit->document_id.": ".htmlspecialchars($hit->title)."\n";
			}
		}
		echo "</pre>";

		$terms = $index->terms();
		echo "<p>".count($terms)." Terms</p>";
		echo "<pre>";
		foreach($terms as $term) {
			echo htmlspecialchars($term->field).":".htmlspecialchars($term->text)."\n";
		}
		echo "</pre>";

		$this->contentContainerEnd();
		$this->htmlEndPage();
	} /* }}} */
}
?>
