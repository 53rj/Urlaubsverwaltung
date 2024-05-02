<?php
include "include/meta.html";
include "include/header.html";
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
</body>
<?php
include "include/footer.html";
?>