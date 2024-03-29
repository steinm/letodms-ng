<?php
/**
 * Implementation of CategoryChooser view
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
require_once("class.BlueStyle.php");

/**
 * Class which outputs the html page for CategoryChooser view
 *
 * @category   DMS
 * @package    LetoDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class LetoDMS_View_DropFolderChooser extends LetoDMS_Blue_Style {

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$dropfolderfile = $this->params['dropfolderfile'];
		$form = $this->params['form'];
		$dropfolderdir = $this->params['dropfolderdir'];

		$this->htmlStartPage(getMLText("choose_target_file"));
		$this->globalBanner();
		$this->pageNavigation(getMLText("choose_target_file"));
?>

<script language="JavaScript">
var targetName = opener.document.<?php echo $form?>.dropfolderfile<?php print $form ?>;
</script>
<?php
		$this->contentContainerStart();

		$dir = $dropfolderdir.'/'.$user->getLogin();
		if(is_dir($dir)) {
			$d = dir($dir);
			echo "<table>\n";
			while (false !== ($entry = $d->read())) {
				if($entry != '..' && $entry != '.') {
					if(!is_dir($entry)) {
						echo "<tr><td><span style=\"cursor: pointer;\" onClick=\"targetName.value = '".$entry."'; window.close();\">".$entry."</span></td><td>".filesize($dir.'/'.$entry)."</td></tr>\n";
					}
				}
			}
			echo "</table>\n";
		}

		$this->contentContainerEnd();
		$this->htmlEndPage();
	} /* }}} */
}
?>
