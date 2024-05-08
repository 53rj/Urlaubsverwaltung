<?php

if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}
$conn = connServer();
if (!$conn) {
    die("Datenbankverbindung konnte nicht hergestellt werden.");
}
?>
<h1>Registrierte Krankheiten:</h1>

<?php if (!empty($krankheiten)): ?>
<table border='1'>
    <tr>
        <th>kid</th
        ><th>pid</th>
        <th>Beginn</th>
        <th>Ende</th>
        <th>Gesamt</th>
    </tr>
    <?php foreach ($krankheiten as $krankheit): ?>
        <tr>
            <td><?= htmlspecialchars($krankheit['kid']); ?></td>
            <td><?= htmlspecialchars($krankheit['pid']); ?></td>
            <td><?= htmlspecialchars($krankheit['kanfang']); ?></td>
            <td><?= htmlspecialchars($krankheit['kende']); ?></td>
            <td><?= htmlspecialchars($krankheit['kgesamt']); ?></td>
            <td>
                <form action="edit_krankheit.php" method="post" style="display: inline;">
                    <input type="hidden" name="kid" value="<?= $krankheit['kid']; ?>">
                    <input type="submit" value="Bearbeiten">
                </form>
                <form action="delete_krankheit.php" method="post" style="display: inline;">
                    <input type="hidden" name="kid" value="<?= $krankheit['kid']; ?>">
                    <input type="submit" value="Löschen" onclick="return confirm('Sind Sie sicher, dass Sie diesen Krankheitseintag möchten?');">
                </form>
            </td>
        </tr>   
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>Keine Daten gefunden.</p>
<?php endif; ?>