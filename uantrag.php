<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "./meta.html";
include_once './f_function.php';
checkStatus();
?>

<body>
    <form id="uantragForm" method="POST">
        <div class="main_content">
            <div class="calendar-container">
                <label for="aurlaub" class="calendar-label">Urlaubsbeginn:</label>
                <input type="date" id="aurlaub" name="ubeginn" class="calendar-input">

                <label for="eurlaub" class="calendar-label">Urlaubsende:</label>
                <input type="date" id="eurlaub" name="uende" class="calendar-input">
            </div>
            <button type="submit" name="uantrag" id="submit_uantrag">Urlaub beantragen</button>
        </div>
    </form>
</body>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ubeginn"]) && isset($_POST["uende"])) {
            urlaubsantrag($_SESSION['personal_id'], $_POST["ubeginn"], $_POST["uende"]);
        }
        ?>