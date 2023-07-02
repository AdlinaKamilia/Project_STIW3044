<?php 
    $today = new DateTime();
    $today->setTimezone(new DateTimeZone('Asia/Kuala_Lumpur'));
    $dateOption = $today->format('d-m-Y');
    require_once 'dbconnect.php';
    if (isset($_GET['staff_id'])) {
        $staff_id = $_GET['staff_id']; 
    }

    $query2 = $connection->query('SELECT * FROM tbl_staff WHERE id = ' . $staff_id);
    $staff_entries = $query2->fetchAll(PDO::FETCH_ASSOC);
    

    if(count($staff_entries)!== 0){
        $staff = array();
        foreach ($staff_entries as $row) {  // Iterate through each booking entry
            $staff['staff_id'] = $row['id'];
            $staff['staff_name'] = $row['name'];
            $staff['staff_phone'] = $row['phone'];
            $staff['staff_email'] = $row['email'];
            $staff['staff_ic'] = $row['ic_number'];
            $staff['staff_address'] = $row['address'];
            $staff['staff_position'] = $row['position'];
        } 
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>ShipWave Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/addParcelStyle.css">
    <link rel="stylesheet" href="css/navigationStyle.css">
</head>
<body>
    <header class="header">
        <h2 class="shipwave-text" style ="font-weight: bold;">
            ShipWave
        </h2>
        <div class="navigation-bar">
            <a href="mainpage.php?staff_id=<?php echo $staff_id?>" >Mainpage</a>
            <a href="#" class="active">Profile</a>
            <a href="#" class="logout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </header>
    <div style="padding: 20px;">
        <h1>Profile</h1>
        <hr>
        <div class="forForm">
            <form method="post" id="addParcelForm" >
                <pre style="margin: 0;">
        <label>Staff Id:</label> <input type="text" id="staffId" name="staffId" class="rounded-rectangle2" size = "100" maxlength="6" minLength="6" value="<?php echo $staff['staff_id']?>" readonly><br>
    <label>Staff Name:</label> <input type="text" id="staffName" name="staffName" class="rounded-rectangle2" size = "100" value="<?php echo $staff['staff_name']?>" readonly><br>
<label>Phone Number:</label> <input type="text" id="phoneNum" name="phoneNum" class="rounded-rectangle2"  size="30" value="<?php echo $staff['staff_phone']?>" readonly>     <label>Ic Number:</label> <input type="text" id="IcNum" name="IcNum" class="rounded-rectangle2"  size="30" value="<?php echo $staff['staff_ic']?>" readonly><br>
          <label>Email:</label> <input type="text" id="staffEmail" name="staffEmail" class="rounded-rectangle2"  size="100" value="<?php echo $staff['staff_email']?>" readonly><br>
       <label>Position:</label> <input type="text" id="position" name="position" value= <?php echo $staff['staff_position']?> class="rounded-rectangle2" size="100" readonly ><br>
       <label>Address:</label> <input type="text" id="address" name="address" value= <?php echo $staff['staff_address']?> class="rounded-rectangle2" size="100" readonly ><br>
                                                        <a href="mainpage.php?staff_id=<?php echo $staff_id?>" class="rounded-rectangle2" style="border-color: #7b1034; background-color:#7b1034; color: white; font-weight:bold; font-size:15px; margin-bottom:0 ; border-color: white; text-decoration: none; display: inline-block; padding: 10px 20px;">Back</a>
                </pre>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</body>
</html>
