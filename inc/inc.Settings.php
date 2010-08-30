<?php
//    MyDMS. Document Management System
//    Copyright (C) 2002-2005  Markus Westphal
//    Copyright (C) 2006-2008 Malcolm Cowe
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

class Settings
{
	// Name of site -- used in the page titles. Default: MyDMS
	var $_siteName = "letoDMS";

	// Message to display at the bottom of every page.
	var $_footNote = "letoDMS free document management system - www.letodms.com";
	
	// if true the disclaimer message the lang.inc files will be print on the bottom of the page
	var $_printDisclaimer = true;	

	// Default page on login. Defaults to out/out.ViewFolder.php
	var $_siteDefaultPage = "";

	// IDs of admin-user, guest-user and root-folder (no need to change)
	var $_adminID = 1;
	var $_guestID = 2;
	var $_rootFolderID = 1;

	// If you want anybody to login as guest, set the following line to true
	// note: guest login should be used only in a trusted environment
	var $_enableGuestLogin = false;

	// Restricted access: only allow users to log in if they have an entry in
	// the local database (irrespective of successful authentication with LDAP).
	var $_restricted = true;

	// Strict form checking. If set to true, then all fields in the form will
	// be checked for a value. If set to false, then (most) comments and
	// keyword fields become optional. Comments are always required when
	// submitting a review or overriding document status.
	var $_strictFormCheck = false;

	// path to where mydms is located
	var $_rootDir = "/var/www/letoDMS-1.10/";

	// The relative path in the URL, after the domain part. Do not include the
	// http:// prefix or the web host name. e.g. If the full URL is
	// http://www.example.com/mydms/, set $_httpRoot = "/mydms/".
	// If the URL is http://www.example.com/, set $_httpRoot = "/".
	var $_httpRoot = "/letoDMS-1.10/";

	// Where the uploaded files are stored (best to choose a directory that
	// is not accessible through your web-server)
	var $_contentDir = "/var/www/letoDMS-1.10/data/";

	// To work around limitations in the underlying file system, a new 
	// directory structure has been devised that exists within the content 
	// directory ($_contentDir). This requires a base directory from which 
	// to begin. Usually leave this to the default setting, 1048576, but can 
	// be any number or string that does not already exist within $_contentDir.	
	var $_contentOffsetDir = "1048576";

	// Maximum number of sub-directories per parent directory. Default: 32700.
	var $_maxDirID = 32700;

	// default language (name of a subfolder in folder "languages")
	var $_language = "English";

	// users are notified about document-changes that took place within the last $_updateNotifyTime seconds
	var $_updateNotifyTime = 86400; //means 24 hours

	// files with one of the following endings can be viewed online (USE ONLY LOWER CASE CHARACTERS)
	// to disable: var $_viewOnlineFileTypes = array();
	var $_viewOnlineFileTypes = array(".txt", ".text", ".html", ".htm", ".pdf", ".gif", ".png", ".jpg", ".jpeg");

	// enable/disable converting of files
	var $_enableConverting = true;

	// default style (name of a subfolder in folder "styles")
	var $_theme = "clean";

	// Workaround for page titles that go over more than 2 lines.
	var $_titleDisplayHack = true;

	// enable/disable automatic email notification
	var $_enableEmail = true;
	
	// enable/disable group and user view for all users
	var $_enableUsersView = true;
	
	// false to don't list administrator as reviewer/approver
	var $_enableAdminRevApp = false;
	
	// the name of the versioning info file created by the backup tool
	var $_versioningFileName = "versioning_info.txt";
	
	// set false to disable log system
	var $_logFileEnable = true;
	
	// the log file rotation (h=hourly, d=daily, m=monthly)
	var $_logFileRotation = "d";
	
	// enable users images
	var $_enableUserImage = false;
	
	// enable calendar
	var $_enableCalendar = true;
	
	// first day of the week (0=sunday, 6=saturday)
	var $_firstDayOfWeek = 0;
	
	// false to don't show the folder tree
	var $_enableFolderTree = true;

	// -------------------------------- Database-Setup --------------------------------------------

	//Path to adodb
	var $_ADOdbPath = "/var/www/letoDMS-1.10/adodb/";

	//DB-Driver used by adodb (see adodb-readme)
	var $_dbDriver = "mysql";

	//DB-Server
	var $_dbHostname = "localhost";

	//database where the tables for mydms are stored (optional - see adodb-readme)
	var $_dbDatabase = "letodms";

	//username for database-access
	var $_dbUser = "letodms";

	//password for database-access
	var $_dbPass = "letodms";

	// -------------------------------- LDAP Authentication Setup --------------------------------------------

	// var $_ldapHost = ""; // URIs are supported, e.g.: ldaps://ldap.host.com
	// var $_ldapPort = 389; // Optional.
	// var $_ldapBaseDN = "";

	function Settings()
	{
		//files with one of the following endings will be converted with the given commands
		//for windows users
		$this->_convertFileTypes = array(".doc" => "cscript \"" . $this->_rootDir."op/convert_word.js\" {SOURCE} {TARGET}",
										 ".xls" => "cscript \"".$this->_rootDir."op/convert_excel.js\" {SOURCE} {TARGET}",
										 ".ppt" => "cscript \"".$this->_rootDir."op/convert_pp.js\" {SOURCE} {TARGET}");
		// For linux users
		// $this->_convertFileTypes = array(".doc" => "mswordview -o {TARGET} {SOURCE}");
	}
}

$settings = new Settings();

?>
