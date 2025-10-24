<?php
http_response_code(403);
echo "This page is temporarily unavailable.";
exit;
?>

<?php
session_start();
// error_reporting(0);

include "../../incl/lib/connection.php";
require_once "../incl/dashboardLib.php";
require_once "../../incl/lib/mainLib.php";

$dl = new dashboardLib();
$gs = new mainLib();

if (!empty($_POST['url']) || isset($_POST['name'])) {
    $customName = isset($_POST['name']) ? trim($_POST['name']) : '';
    $songID = $gs->songReupload($_POST['url'], $customName);

    if (is_array($songID) && isset($songID['duplicate']) && $songID['duplicate'] === true) {
        $existingId = $songID['id'];
        $dl->printBox(
            "<h1>" . $dl->getLocalizedString('songAdd') . "</h1>
            <p>This song already exists. Song ID: {$existingId}</p>
            <a class=\"btn btn-primary btn-block\" href=\"" . $_SERVER['REQUEST_URI'] . "\">" .
                $dl->getLocalizedString('songAddAnotherBTN') . "</a>",
            'reupload'
        );
    } elseif ($songID < 0) {
        $errorDesc = $dl->getLocalizedString("songAddError{$songID}");
        $dl->printBox(
            '<h1>' . $dl->getLocalizedString('songAdd') . "</h1>
            <p>" . $dl->getLocalizedString('errorGeneric') . " $songID ($errorDesc)</p>
            <a class=\"btn btn-primary btn-block\" href=\"" . $_SERVER['REQUEST_URI'] . "\">" .
                $dl->getLocalizedString('tryAgainBTN') . "</a>",
            'reupload'
        );
    } else {
        $dl->printBox(
            "<h1>" . $dl->getLocalizedString('songAdd') . "</h1>
            <p>Song uploaded! ID: $songID</p>
            <a class=\"btn btn-primary btn-block\" href=\"" . $_SERVER['REQUEST_URI'] . "\">" .
                $dl->getLocalizedString('songAddAnotherBTN') . "</a>",
            'reupload'
        );
    }
} else {
    $dl->printBox(
        '<h1>' . $dl->getLocalizedString('songAdd') . '</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="urlField">' . $dl->getLocalizedString('songAddUrlFieldLabel') . '</label>
                <input type="text" class="form-control" id="urlField" name="url" placeholder="' . $dl->getLocalizedString('songAddUrlFieldPlaceholder') . '">
            </div>
            <div class="form-group">
                <label for="nameField">Song name</label>
                <input type="text" class="form-control" id="nameField" name="name" placeholder="Leave empty to use filename">
            </div>
            <button type="submit" class="btn btn-primary btn-block">' . $dl->getLocalizedString('reuploadBTN') . '</button>
        </form>',
        'reupload'
    );
}
?>