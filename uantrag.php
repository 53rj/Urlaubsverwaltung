<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "include/meta.php";
include "f_function.php";
checkStatus();
?>

<body>
    <form id="uantragForm" method="POST">
        <div class="main_content">
            <br>
            <div class="calendar-container">
                <label for="aurlaub" class="calendar-label">Urlaubsbeginn:</label>
                <input type="date" id="aurlaub" name="ubeginn" class="calendar-input">

                <label for="eurlaub" class="calendar-label">Urlaubsende:</label>
                <input type="date" id="eurlaub" name="uende" class="calendar-input">
                <br>
            </div>
            <button type="submit" name="uantrag" id="submit">Urlaub beantragen</button>

        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ubeginn"]) && isset($_POST["uende"])) {
            urlaubsantrag($_SESSION['personal_id'], $_POST["ubeginn"], $_POST["uende"]);
            echo $_SESSION['personal_id'], $_POST["ubeginn"], $_POST["uende"];
        }
        ?>
</body>
<?php
include "include/footer.html";
?>