<?php
//    MyDMS. Document Management System
//    Copyright (C) 2002-2005  Markus Westphal
//    Copyright (C) 2006-2008 Malcolm Cowe
//    Copyright (C) 2010 Matteo Lucarelli
//    Copyright (C) 2011 Matteo Lucarelli
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

include("../inc/inc.Version.php");
include("../inc/inc.Settings.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.Language.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.Authentication.php");

if (!$user->isAdmin()) {
	UI::exitError(getMLText("admin_tools"),getMLText("access_denied"));
}

if(!$settings->_enableFullSearch) {
	UI::exitError(getMLText("admin_tools"),getMLText("fulltextsearch_disabled"));
}

if(!empty($settings->_luceneClassDir))
	require_once($settings->_luceneClassDir.'/Lucene.php');
else
	require_once('LetoDMS/Lucene.php');

$index = LetoDMS_Lucene_Indexer::open($settings->_luceneDir);
if(!$index) {
	UI::exitError(getMLText("admin_tools"),getMLText("no_fulltextindex"));
}

$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user, 'luceneclassdir'=>$settings->_luceneClassDir, 'lucenedir'=>$settings->_luceneDir, 'index'=>$index));
if($view) {
	$view->show();
	exit;
}

?>
