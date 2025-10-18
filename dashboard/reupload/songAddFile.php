<?php
session_start();
include "../../incl/lib/connection.php";
require_once "../incl/dashboardLib.php";
require_once __DIR__ . "/../../incl/lib/mainLib.php";
$dl = new dashboardLib();
$gs = new mainLib();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['songfile'])) {
    $customName = isset($_POST['name']) ? trim($_POST['name']) : "";
    $result = $gs->songReuploadFile($_FILES['songfile'], $customName);
    if (is_numeric($result) && $result > 0) {
        $dl->printBox("<h1>".$dl->getLocalizedString("songAdd")."</h1>
            <p>Song uploaded! ID: $result</p>
            <a class='btn btn-primary btn-block' href='".$_SERVER["REQUEST_URI"]."'>".$dl->getLocalizedString("songAddAnotherBTN")."</a>","reupload");
    } else {
        $errText = "Upload error: $result";
        switch ($result) {
            case "-2": $errText = "Upload failed or no file received."; break;
            case "-3": $errText = "Failed to move uploaded file."; break;
            case "-4": $errText = "Invalid audio type."; break;
            case "-5": $errText = "File too large."; break;
            case "-6": $errText = "Server error creating storage folder."; break;
            case "-7": $errText = "This file already exists in the database."; break;
        }
        $dl->printBox("<h1>".$dl->getLocalizedString("songAdd")."</h1>
            <p>$errText</p>
            <a class='btn btn-primary btn-block' href='".$_SERVER["REQUEST_URI"]."'>".$dl->getLocalizedString("tryAgainBTN")."</a>","reupload");
    }
} else {
    $dl->printBox('<h1>'.$dl->getLocalizedString("songAdd").'</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fileField">Audio file</label>
                <input type="file" class="form-control" id="fileField" name="songfile" accept="audio/*" required>
            </div>
            <div class="form-group">
                <label for="nameField">Song name</label>
                <input type="text" class="form-control" id="nameField" name="name" placeholder="Leave empty to use filename">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Upload</button>
        </form>',"reupload");
}
?>