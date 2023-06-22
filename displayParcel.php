<?php
    require_once 'dbconnect.php';
    $parcel = array();
    if (isset($_GET['staff_id'], $_GET['id'])) {
        $staff_id = $_GET['staff_id']; 
        $parcel_id = $_GET['id'];
        $query = $connection->query('SELECT * FROM parcel WHERE parcel_id = ' . $parcel_id);
        $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($parcel_entries) > 0) {
            foreach ($parcel_entries as $row) {  // Iterate through each booking entry
                $parcel['parcel_id'] = $row['parcel_id'];
                $parcel['parcel_owner'] = $row['parcel_owner'];
                $parcel['staff_id'] = $row['pstaff_id'];
                $parcel['date_arrived'] = $row['pdate_arrived'];
                $parcel['date_pickup'] = $row['pdate_pickup'];
                $parcel['tracking_number'] = $row['ptracking_number'];
                $parcel['parcel_status'] = $row['parcel_status'];
                $parcel['parcel_payment'] = $row['parcel_payment'];
                $parcel['parcel_description'] = $row['parcel_description'];
            }
        }
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>ShipWave Mainpage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navigationStyle.css">
    <link rel="stylesheet" href="css/halfContainerStyle.css">
    <link rel="stylesheet" href="css/addParcelStyle.css">

</head>
<body>
    <header class="header">
        <h2 class="shipwave-text" style ="font-weight: bold;">
            ShipWave
        </h2>
        <div class="navigation-bar">
            <a href="#">Mainpage</a>
            <a href="#">Parcel</a>
            <a href="#" class="active">Details</a>
            <a href="#" class="logout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </header>
    
    
    <div style="padding: 20px;">
        <h1>Parcel Details</h1>
        <hr>
        <div class =" section" style="margin-bottom: 10px;">
            <div class="main-section">
                <div class="left-section">
                    <p>Parcel Id: <?php echo $parcel['parcel_id'] ?></p>
                    <p>Parcel Owner: <?php echo $parcel['parcel_owner'] ?></p>
                    <p>Tracking Number: <?php echo $parcel['tracking_number'] ?></p>
                    <p>Parcel Status: <?php echo $parcel['parcel_status'] ?></p>
                    <p>Payment Status: <?php echo $parcel['parcel_payment'] ?></p>
                    <p>Description: <?php echo $parcel['parcel_description'] ?></p>
                </div>
                <div class="right-section" style="justify-content: center; align-items: flex-start; ">
                    <p>Date Arrived: <?php echo $parcel['date_arrived'] ?></p>
                    <p>Staff Id: <?php echo $parcel['staff_id'] ?></p>
                    <p>Pickup Date: <?php echo $parcel['date_pickup'] ?></p>
                </div>
            </div>
            
            
        </div>
        <div style="display: flex; justify-content:center; align-items: center">
            <button onclick="goBack()" style="margin-right: 10px; background-color: #f9aa98; color: #7b1034; border-color: #f9aa98 ;" class="rounded-rectangle">Back</button>
            <button onclick="goToMainpage()" style="border-color: #7b1034;"class="rounded-rectangle">Mainpage</button>
        </div>
    </div>
    <script>
        function goBack() {
            // Go back to the previous page
            window.history.back();
        }
        
        function goToMainpage() {
            // Redirect to the mainpage
            window.location.href = "mainpage.php";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</body>
</html>
