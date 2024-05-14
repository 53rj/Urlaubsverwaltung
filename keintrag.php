<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "./meta.html";
include_once './f_function.php';

checkStatus();
?>

<body>
    <form id="keintragForm" method="POST">
        <div class="main_content">
            <div class="calendar-container">
                <br>
                <label for="pid">Personal-ID:</label>
                <br>
                <input type="int" id="pid" name="pid" required>
                <br>
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
            krankheitseintrag($_POST['pid'], $_POST["kbeginn"], $_POST["kende"]);
            echo $_POST['pid'], $_POST["kbeginn"], $_POST["kende"];
        }
        ?>
</body>
<?php
include_once "./footer.html";
?>