<?php
//    MyDMS. Document Management System
//    Copyright (C) 2010 Matteo Lucarelli
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

include("../inc/inc.Settings.php");
include("../inc/inc.LogInit.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.Language.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.Authentication.php");

/* Check if the form data comes for a trusted request */
if(!checkFormKey('removelog')) {
	UI::exitError(getMLText("admin_tools"),getMLText("invalid_request_token"));
}

if (!$user->isAdmin()) {
	UI::exitError(getMLText("admin_tools"),getMLText("access_denied"));
}

if (!isset($_POST["logname"]) || !file_exists($settings->_contentDir.$_POST["logname"]) ) {
	UI::exitError(getMLText("admin_tools"),getMLText("unknown_id"));
}

if (@readlink($settings->_contentDir."current.log")==$settings->_contentDir.$_POST["logname"]){
	UI::exitError(getMLText("admin_tools"),getMLText("access_denied"));
}

if (!LetoDMS_Core_File::removeFile($settings->_contentDir.$_POST["logname"])) {
	UI::exitError(getMLText("admin_tools"),getMLText("error_occured"));
}

add_log_line("?logname=".$_POST["logname"]);

header("Location:../out/out.LogManagement.php");

?>
