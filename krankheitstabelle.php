<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}

include_once "./meta.html";
include_once './f_function.php';

$conn = connServer();
?>
<h1>Registrierte AU-Fälle:</h1>

<?php if (!empty($krankheiten)) : ?>
    <table border='1'>
        <tr>
            <th>kid</th>
            <th>pid</th>
            <th>Beginn</th>
            <th>Ende</th>
            <th>Gesamt</th>
            <th>Aktionen</th>
        </tr>
        <?php foreach ($krankheiten as $krankheit) : ?>
            <tr>
                <td><?= htmlspecialchars($krankheit['kid']); ?></td>
                <td><?= htmlspecialchars($krankheit['pid']); ?></td>
                <td><?= htmlspecialchars($krankheit['kanfang']); ?></td>
                <td><?= htmlspecialchars($krankheit['kende']); ?></td>
                <td><?= htmlspecialchars($krankheit['kgesamt']); ?></td>
                <td>
                    <form action="./edit_krankheit.php" method="post" style="display: inline;">
                        <input type="hidden" name="kid" value="<?= $krankheit['kid']; ?>">
                        <input type="submit" id="edit" value="Bearbeiten">
                    </form>
                    <form action="./delete_eintrag.php" method="post" style="display: inline;">
                        <input type="hidden" name="kid" value="<?= $krankheit['kid']; ?>">
                        <input type="submit" id="delete" value="Löschen" onclick="return confirm('Sind Sie sicher, dass Sie diesen Krankheitseintag möchten?');">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>Keine Daten gefunden.</p>
<?php endif;?>
