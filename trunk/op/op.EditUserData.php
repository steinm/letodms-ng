<?php
//    MyDMS. Document Management System
//    Copyright (C) 2002-2005  Markus Westphal
//    Copyright (C) 2006-2008 Malcolm Cowe
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
include("../inc/inc.ClassPasswordStrength.php");
include("../inc/inc.ClassPasswordHistoryManager.php");

if ($user->isGuest()) {
	UI::exitError(getMLText("edit_user_details"),getMLText("access_denied"));
}

if (!$user->isAdmin() && ($settings->_disableSelfEdit)) {
	UI::exitError(getMLText("edit_user_details"),getMLText("access_denied"));
}

$fullname = $_POST["fullname"];
$email    = $_POST["email"];
$comment  = $_POST["comment"];
$current_pwd  = $_POST["currentpwd"];

if($user->getPwd() != md5($current_pwd)) {
	UI::exitError(getMLText("edit_user_details"),getMLText("password_wrong"));
}

if (isset($_POST["pwd"]) && ($_POST["pwd"] != "")) {
	if($settings->_passwordStrength) {
		$ps = new Password_Strength();
		$ps->set_password($_POST["pwd"]);
		$ps->calculate();
		$score = $ps->get_score();
		if($score > $settings->_passwordStrength) {
			if($settings->_passwordHistory > 0) {
				$phm = new LetoDMS_PasswordHistoryManager($db);
				$oldpwd = $phm->search($user, md5($_POST["pwd"]));
				if($oldpwd) {
					UI::exitError(getMLText("set_password"),getMLText("password_already_used"));
				} else {
					$phm->add($user, md5($_POST["pwd"]));
				}
			}
			$user->setPwd(md5($_POST["pwd"]));
			$user->setPwdExpiration(date('Y-m-d H:i:s', time()+$settings->_passwordExpiration*86400));
		} else {
			UI::exitError(getMLText("set_password"),getMLText("password_strength_insuffient"));
		}
	} else {
		if($settings->_passwordHistory > 0) {
			$phm = new LetoDMS_PasswordHistoryManager($db);
			$oldpwd = $phm->search($user, md5($_POST["pwd"]));
			if($oldpwd) {
				UI::exitError(getMLText("set_password"),getMLText("password_already_used"));
			} else {
				$phm->add($user, md5($_POST["pwd"]));
			}
		}
		$user->setPwd(md5($_POST["pwd"]));
		$user->setPwdExpiration(date('Y-m-d H:i:s', time()+$settings->_passwordExpiration*86400));
	}
}

if ($user->getFullName() != $fullname)
	$user->setFullName($fullname);

if ($user->getEmail() != $email)
	$user->setEmail($email);

if ($user->getComment() != $comment)
	$user->setComment($comment);

if (is_uploaded_file($_FILES["userfile"]["tmp_name"]) && $_FILES["userfile"]["size"] > 0 && $_FILES['userfile']['error']==0)
{
	$lastDotIndex = strrpos(basename($_FILES["userfile"]["name"]), ".");
	$fileType = substr($_FILES["userfile"]["name"], $lastDotIndex);
	if ($fileType != ".jpg" && $filetype != ".jpeg") {
		UI::exitError(getMLText("user_info"),getMLText("only_jpg_user_images"));
	}
	//verkleinern des Bildes, so dass es 150 Pixel hoch ist
	// Originalbild einlesen
	$origImg = imagecreatefromjpeg($_FILES["userfile"]["tmp_name"]);
	$width = imagesx($origImg);
	$height = imagesy($origImg);
	// Thumbnail im Speicher erzeugen
	$newHeight = 150;
	$newWidth = ($width/$height) * $newHeight;
	$newImg = imagecreatetruecolor($newWidth, $newHeight);
	// Verkleinern
	imagecopyresized($newImg, $origImg, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
	// In File speichern 
	imagejpeg($newImg, $_FILES["userfile"]["tmp_name"]);
	// Aufr�umen
	imagedestroy($origImg);
	imagedestroy($newImg);
	$user->setImage($_FILES["userfile"]["tmp_name"], $_FILES["userfile"]["type"]);
}

add_log_line("?user=".$user->getLogin());

header("Location:../out/out.MyAccount.php");

?>