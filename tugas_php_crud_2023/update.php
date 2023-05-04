<?php 
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : '';
        $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : ''; 

        // Update the rocord
        $stmt = $pdo->prepare('UPDATE tlb_kontak SET id = ?, nama = ?, email = ?, notelp = ?, pekerjaan = ? WHERE id = ?');
        $stmt->execute([$id, $nama, $email, $notelp, $pekerjaan, $_GET['id']]);
        $msg = 'Update Succesfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM tbl_kontak WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>