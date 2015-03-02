<?php
require_once ("../../../../../../library/fckeditor/fckeditor.php");
$editor = new FCKeditor("txtDescricao");
$editor->BasePath = "../../../../../../library/fckeditor/";
$editor->Width = "100%";
$editor->Height = "500";
$editor->Create();
?>