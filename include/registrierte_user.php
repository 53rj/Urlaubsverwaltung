<h1>Registrierte Benutzer:</h1>

<?php if (!empty($users)): ?>
<table border='1'>
    <tr><th>Vorname</th><th>Nachname</th><th>Status</th></tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['vorname']); ?></td>
            <td><?= htmlspecialchars($user['nachname']); ?></td>
            <td><?= htmlspecialchars($user['status']); ?></td>
            <td>
            <form action="edit_user.php" method="post" style="display: inline;"> <!-- Brauche den code für user-bearbeitung -->
                <input type="hidden" name="user_id" value="<?= $user['pid']; ?>">
                <input type="submit" value="Bearbeiten">
            </form>
            <form action="delete_user.php" method="post" style="display: inline;"> <!-- Brauche den code für user-entfernung -->
                <input type="hidden" name="user_id" value="<?= $user['pid']; ?>">
                <input type="submit" value="Löschen" onclick="return confirm('Sind Sie sicher, dass Sie diesen Benutzer löschen möchten?');">
            </form>
        </td>
        </tr>   
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>Keine Daten gefunden.</p>
<?php endif; ?>