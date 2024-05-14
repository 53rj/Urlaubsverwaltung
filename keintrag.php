<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "include/meta.php";
include "f_function.php";
checkStatus();
?>

<body>
    <form id="keintragForm" method="POST">
        <div class="main_content">
            <br>
            <div class="calendar-container">
                <label for="akrankheit" class="calendar-label">Krankheitsbeginn:</label>
                <input type="date" id="akrankheit" name="kbeginn" class="calendar-input">

                <label for="ekrankheit" class="calendar-label">Krankheitsende:</label>
                <input type="date" id="ekrankheit" name="kende" class="calendar-input">
                <br>
            </div>
            <button type="submit" name="keintrag" id="submit">AU eintragen</button>

        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["kbeginn"]) && isset($_POST["kende"])) {
            urlaubsantrag($_SESSION['personal_id'], $_POST["kbeginn"], $_POST["kende"]);
            echo $_SESSION['personal_id'], $_POST["kbeginn"], $_POST["kende"];
        }
        ?>
</body>
<?php
include "include/footer.html";
?>