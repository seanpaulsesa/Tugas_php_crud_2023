<?php
    include 'functions.php';
    $pdo = pdo_connect_mysql();
    $msg = '';
    // Check that the contact ID exists
    if (isset($_GET['id'])) {
        // select the record that is going to be deleted
        $stmt = $pdo->prepare('SELECT * FROM tbl_kontak WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        if (!$contact) {
            exit('Contact doesn\'t exist with that ID!');
        } 
        // Make sure the user confirms beore deletion
        if (isset($_GET['confirm'])) {
            if ($_GET['confirm'] == 'yes') {
                // User clicked the "Yes" button, delete record
                $stmt = $pdo->prepare('DELETE FROM tbl_kontak WHERE id = ?');
                $stmt->execute([$_GET['id']]);
                $msg = 'You heve delete the contact!';
            } else {
                // User clicked the "No" button, redirect them back to the read page
                header('location: read.php');
                exit;
            }
        } 
    } else {
        exit('No ID specified!');
    }
?>

<?=template_header('Delete')?>

<div class="contect delete">
    <h2>Delete Contact #<?=$contact['id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php else: ?>
            <p>Are you sure you want to delete contact #<?=$contact['id']?></p>
            <div class="yesno">
                <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">Yes</a>
                <a href="delete.php?id=<?=$contact['id']?>&confirm=no">No</a>
            </div>
            <?php endif; ?>
</div>

<?=template_footer()?>