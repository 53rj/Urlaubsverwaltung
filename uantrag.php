<?php
include "include/meta.html";
include "include/header.html";
include "function.php";
include "f_function.php";
?>

<body>
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
    <!-- Session ID benötigt -->
    <?php urlaubsantrag($_POST[], $_POST["ubeginn"], $_POST["uende"]) ?>
</body>
<?php
include "include/footer.html";
?>