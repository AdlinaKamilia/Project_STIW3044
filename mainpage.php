<?php 
    $today = new DateTime();
    $today->setTimezone(new DateTimeZone('Asia/Kuala_Lumpur'));
    $dateOption = $today->format('d-m-Y');
    require_once 'dbconnect.php';
    if (isset($_GET['staff_id'])) {
        $staff_id = $_GET['staff_id']; 
    }
    $query = $connection->query('SELECT * FROM parcel');
    $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);

    
    
    $parcelList = array();
    $counter = count($parcel_entries);
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
            $parcelList[] = $parcel;
        } 
    }
    $counteradd = 0;
    $counteravail = 0;
    $counterpickup = 0;
    foreach ($parcelList as $parcel){
        if(stripos($parcel['date_arrived'], $dateOption) !== FALSE){
            $counteradd = $counteradd + 1;
            
        }
        if(stripos($parcel['parcel_status'], "In Hub") !== FALSE){
            $counteravail = $counteravail + 1;
            
        }
        if(stripos($parcel['date_pickup'], $dateOption) !== FALSE){
            $counterpickup = $counterpickup + 1;
            
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
    <link rel="stylesheet" href="css/halfContainerStyle.css">
    <link rel="stylesheet" href="css/navigationStyle.css">
</head>
<body>
    <header class="header">
        <h2 class="shipwave-text" style ="font-weight: bold;">
            ShipWave
        </h2>
        <div class="navigation-bar">
            <a href="#" class="active">Mainpage</a>
            <a href="#">Admin</a>
            <a href="#" class="logout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </header>
    <div class =" section">
        <div class="main-section">
            <div class="left-section">
                <h1 style ="font-weight:bold;">
                    Hello, Azanin
                </h1>
                <div class="rounded-rectangle " style = " background-color: rgba(123, 16, 52, 0.25)">
                    <div class="custom-div">
                        <div class="div1">
                            <h2 style="color: #7640a3;">Total Parcel:</h2>
                        </div>
                        <div class="div2">
                            <p style =" color: black;"><?php  echo $counter?></p>
                            <p style ="padding-top: 0%; color: black; font-size: 12px; font-weight: normal;">As of today: <?php echo $dateOption ?></p>
                        </div>
                    </div>
                </div>
                <div class="rounded-rectangle">
                    <div class="custom-div">
                        <div class="div1">
                            <h2>New Parcel:</h2>
                        </div>
                        <div class = "div2">
                            <p><?php  echo $counteradd ?></p>   
                            <p style ="padding-top: 0%; font-size: 12px; font-weight: normal;">On <?php echo $dateOption ?></p> 
                        </div>
                    </div>
                </div>
                <div class="rounded-rectangle">
                    <div class="custom-div">
                        <div class="div1">
                            <h2>Parcel Pickup:</h2>
                        </div>
                        <div class="div2">
                            <p><?php  echo $counterpickup ?></p>    
                            <p style ="padding-top: 0%; font-size: 12px; font-weight: normal;">On <?php echo $dateOption ?></p> 
                        </div>
                    </div>
                </div>
                <div class="rounded-rectangle">
                    <div class="custom-div">
                        <div class="div1">
                            <h2>Available Parcel:</h2>
                        </div>
                        <div class="div2">
                            <p><?php echo $counteravail ?></p>    
                            <p style ="padding-top: 0%; font-size: 12px; font-weight: normal;">In Hub</p>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="right-section">
                <div class="container-grid">
                    <a href="" style="text-decoration: none;">
                        <div class="click-container">
                            <div class="icon-container">                        
                                <i class="fas fa-user-cog" style="font-size: 80px;"></i>
                            </div>
                            <div class="rounded-rectangle">              
                                <p style ="font-size: 20px; font-weight: bold;">Admin</p>
                            </div>
                        </div>
                    </a>
                    <a href="your_customer_page_link" style="text-decoration: none;">
                        <div class="click-container">
                          <div class="icon-container">
                            <i class="fas fa-users" style="font-size: 80px;"></i>
                          </div>
                          <div class="rounded-rectangle">
                            <p style="font-size: 20px; font-weight: bold;">Customer</p>
                          </div>
                        </div>
                    </a>
                    <a href="parcels.php?staff_id=<?php echo $staff_id?>" style="text-decoration: none;">
                        <div class="click-container">
                          <div class="icon-container">
                            <i class="fas fa-box" style="font-size: 80px;"></i>
                          </div>
                          <div class="rounded-rectangle">
                            <p style="font-size: 20px; font-weight: bold;">Parcels</p>
                          </div>
                        </div>
                     </a>
                     <a href="profilePage.php?staff_id=<?php echo $staff_id?>" style="text-decoration: none;">
                        <div class="click-container">
                          <div class="icon-container">
                            <i class="fas fa-user" style="font-size: 80px;"></i>
                          </div>
                          <div class="rounded-rectangle">
                            <p style="font-size: 20px; font-weight: bold;">Profile</p>
                          </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</body>
</html>
