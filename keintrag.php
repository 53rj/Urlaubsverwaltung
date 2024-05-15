<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['status'] !== 'Abteilungsleiter') {
    echo "Zugriff verweigert!";
    exit;
}

include_once "./meta.html";
include_once './f_function.php';

checkStatus();
?>

<body>
    <form id="keintragForm" method="POST">
        <div class="main_content">
            <div class="calendar-container">
                <label for="pid" id="pid_label">Personal-ID:</label>
                <input type="int" id="pid_eintrag" name="pid" required>
                <label for="akrankheit" class="calendar-label">Krankheitsbeginn:</label>
                <input type="date" id="akrankheit" name="kbeginn" class="calendar-input">

                <label for="ekrankheit" class="calendar-label">Krankheitsende:</label>
                <input type="date" id="ekrankheit" name="kende" class="calendar-input">
            </div>
            <button type="submit" name="keintrag" id="submit_keintrag">AU eintragen</button>
        </div>
    </form>
</body>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["kbeginn"]) && isset($_POST["kende"])) {
            krankheitseintrag($_POST['pid'], $_POST["kbeginn"], $_POST["kende"]);
        }
        ?>
