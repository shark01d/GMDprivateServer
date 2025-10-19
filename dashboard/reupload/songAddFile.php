<?php
session_start();

include __DIR__ . "/../../incl/lib/connection.php";
require_once __DIR__ . "/../incl/dashboardLib.php";
require_once __DIR__ . "/../../incl/lib/mainLib.php";

$dl = new dashboardLib();
$gs = new mainLib();

if (empty($_SESSION['upload_token'])) {
    try {
        $_SESSION['upload_token'] = bin2hex(random_bytes(16));
    } catch (Exception $e) {
        $_SESSION['upload_token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['songfile'])) {
    $postedToken = isset($_POST['upload_token']) ? $_POST['upload_token'] : '';
    if ($postedToken === '' || !hash_equals($_SESSION['upload_token'], $postedToken)) {
        $err = urlencode("-8");
        header("Location: " . strtok($_SERVER['REQUEST_URI'], '?') . "?upload_error={$err}");
        exit;
    }
    unset($_SESSION['upload_token']);

    $customName = isset($_POST['name']) ? trim($_POST['name']) : "";
    $result = $gs->songReuploadFile($_FILES['songfile'], $customName);

    if (is_numeric($result) && $result > 0) {
        $id = (int)$result;
        header("Location: " . strtok($_SERVER['REQUEST_URI'], '?') . "?uploaded=" . $id);
        exit;
    } else {
        $errCode = urlencode((string)$result);
        header("Location: " . strtok($_SERVER['REQUEST_URI'], '?') . "?upload_error=" . $errCode);
        exit;
    }
} else {
    if (isset($_GET['uploaded'])) {
        $resultId = (int)$_GET['uploaded'];
        $dl->printBox(
            "<h1>" . $dl->getLocalizedString("songAdd") . "</h1>
             <p>Song uploaded! ID: {$resultId}</p>
             <a class='btn btn-primary btn-block' href='" . strtok($_SERVER["REQUEST_URI"], '?') . "'>" .
                $dl->getLocalizedString("songAddAnotherBTN") .
             "</a>",
            "reupload"
        );
        exit;
    }

    if (isset($_GET['upload_error'])) {
        $result = $_GET['upload_error'];
        $errText = "Upload error: $result";
        switch ($result) {
            case "-2":
                $errText = "Upload failed or no file received.";
                break;
            case "-3":
                $errText = "Failed to move uploaded file.";
                break;
            case "-4":
                $errText = "Invalid audio type.";
                break;
            case "-5":
                $errText = "File too large.";
                break;
            case "-6":
                $errText = "Server error creating storage folder.";
                break;
            case "-7":
                $errText = "This file already exists in the database.";
                break;
            case "-8":
                $errText = "Invalid or missing form token.";
                break;
        }

        $dl->printBox(
            "<h1>" . $dl->getLocalizedString("songAdd") . "</h1>
             <p>$errText</p>
             <a class='btn btn-primary btn-block' href='" . strtok($_SERVER["REQUEST_URI"], '?') . "'>" .
                $dl->getLocalizedString("tryAgainBTN") .
             "</a>",
            "reupload"
        );
        exit;
    }

    try {
        $_SESSION['upload_token'] = bin2hex(random_bytes(16));
    } catch (Exception $e) {
        $_SESSION['upload_token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }

    $tokenEsc = htmlspecialchars($_SESSION['upload_token'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    $dl->printBox(
        '<h1>' . $dl->getLocalizedString("songAdd") . '</h1>
         <form action="" method="post" enctype="multipart/form-data">
             <input type="hidden" name="upload_token" value="' . $tokenEsc . '">
             <div class="form-group">
                 <label for="fileField">Audio file</label>
                 <input type="file" class="form-control" id="fileField" name="songfile" accept="audio/*" required>
             </div>
             <div class="form-group">
                 <label for="nameField">Song name</label>
                 <input type="text" class="form-control" id="nameField" name="name" placeholder="Leave empty to use filename">
             </div>
             <button type="submit" class="btn btn-primary btn-block">Upload</button>
         </form>',
        "reupload"
    );
}