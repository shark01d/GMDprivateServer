<?php
session_start();
//error_reporting(0);
include "../../incl/lib/connection.php";
require_once "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();

if (!empty($_POST['uploadFile']) && !empty($_FILES['songfile'])) {
    $songID = $gs->songUploadFile($_FILES['songfile']);
    if ($songID < 0) {
        $errorDesc = $dl->getLocalizedString("songAddError$songID");
        $dl->printBox(
            '<h1>' . $dl->getLocalizedString("songAdd") . "</h1>
            <p>" . $dl->getLocalizedString("errorGeneric") . " $songID ($errorDesc)</p>
            <a class=\"btn btn-primary btn-block\" href=\"" . $_SERVER["REQUEST_URI"] . "\">" . $dl->getLocalizedString("tryAgainBTN") . "</a>",
            "reupload"
        );
    } else {
        $dl->printBox(
            "<h1>" . $dl->getLocalizedString("songAdd") . "</h1>
            <p>Song Uploaded: $songID</p>
            <a class='btn btn-primary btn-block' href='" . $_SERVER["REQUEST_URI"] . "'>" . $dl->getLocalizedString("songAddAnotherBTN") . "</a>",
            "reupload"
        );
    }
} else {
    $dl->printBox(
        '<h1>' . $dl->getLocalizedString("songAdd") . '</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" class="form-control" id="fileField" name="songfile" accept="audio/*" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="uploadFile">' . $dl->getLocalizedString("reuploadBTN") . '</button>
        </form>',
        "reupload"
    );
}
?>