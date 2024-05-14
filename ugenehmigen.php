<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "./meta.html";
include_once './f_function.php';
checkStatus();
?>
<h1>Nicht bearbeitete Urlaubsanträge:</h1>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Beginn</th>
                <th>Ende</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody id="pending-requests">
            <tr>
                <?php
                kommende_urlaube_anzeigen();
                $pid = $_SESSION['personal_id'];
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['uannehmen'])) {
                        if (isset($_POST['uid'])) {
                            urlaubsgenehmigung($pid, $_POST['uid']);
                        }
                    } elseif (isset($_POST['uablehnen'])) {
                        if (isset($_POST['uid'])) {
                            urlaubsablehnung($_POST['uid']);
                        }
                    }
                }
                ?>
            </tr>
        </tbody>
    </table>

</div>
<?php
include_once "./footer.html";
?>