<?php 
    require_once 'dbconnect.php';
    if (isset($_GET['id'], $_GET['staff_id'])) {
        $parcel_id = $_GET['id'];
        $staff_id = $_GET['staff_id'];
        $query = $connection->prepare('DELETE FROM parcel WHERE parcel_id = ?');
        $query->execute([$parcel_id]);
        header('Location: parcels.php?staff_id=' . $staff_id);
        exit;
    }
    
?>
