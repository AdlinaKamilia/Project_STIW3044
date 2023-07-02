<?php 
    require_once 'dbconnect.php';
    if (isset($_GET['staff_id'])) {
        $staff_id = $_GET['staff_id']; 
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (isset($_POST['confirmation'])&& $_POST['confirmation'] === 'yes') {
            $parcelOwner = $_POST['parcelOwner']; 
            $trackingNumber = $_POST['trackingNumber'];
            $dateArrived = $_POST['date'];
            $staffId =$_POST['staffId'];
            $description = $_POST['description'];
            $query = $connection->prepare('INSERT INTO parcel (parcel_owner, pstaff_id, pdate_arrived, ptracking_number, parcel_status, parcel_payment, parcel_description, pdate_pickup) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $result = $query->execute([$parcelOwner, $staffId, $dateArrived, $trackingNumber, "In Hub", "Outstanding", $description, ""]);
            if ($result) {
                echo '<script>';
                echo 'alert("Entry saved successfully.");';
                echo 'setTimeout(function(){ window.location.href = "parcels.php?staff_id=' . $staff_id . '"; }, 500);';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'alert("Failed to save entry.");';
                echo 'setTimeout(function(){ window.location.href = "parcels.php?staff_id=' . $staff_id . '"; }, 500);';
                echo '</script>';
            }
        }   
    }
    
    $today = new DateTime();
    $today->setTimezone(new DateTimeZone('Asia/Kuala_Lumpur'));
    $dateOption = $today->format('d-m-Y');

?>
<!DOCTYPE html>
<html>
<head>
    <script>
        function confirmation() {
            return confirm("Do you want to add a new parcel?");
        }
        window.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addParcelForm').addEventListener('submit', function(event) {
                if (!confirmation()) {
                    event.preventDefault(); // Prevent the form submission
                }
            });
        });
    </script>
    <title>ShipWave Mainpage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navigationStyle.css">
    <link rel="stylesheet" href="css/addParcelStyle.css">

</head>
<body>
    <header class="header">
        <h2 class="shipwave-text" style ="font-weight: bold;">
            ShipWave
        </h2>
        <div class="navigation-bar">
            <a href="mainpage.php?staff_id=<?php echo $staff_id?>" >Mainpage</a>
            <a href="parcels.php?staff_id=<?php echo $staff_id?>" >Parcel</a>
            <a href="#" class="active">Add Parcel</a>
            <a href="#" class="logout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </header>
    
    
    <div style="padding: 20px;">
        <h1>Add Parcel</h1>
        <hr>
        <div class="forForm">
            <form method="post" id="addParcelForm" >
                <pre style="margin: 0;">
     <label>Parcel Owner:</label> <input type="text" id="parcelOwner" name="parcelOwner" placeholder="Matrics Number" class="rounded-rectangle2" size = "100" maxlength="6" minLength="6" required><br>
<label>Tracking Number:</label> <input type="text" id="trackingNumber" name="trackingNumber" placeholder="xxxxx-xxx-xxxxx" class="rounded-rectangle2"  size="100" required><br>
       <label>Description:</label> <input type="text" id="description" name="description" class="rounded-rectangle2"  size="100" ><br>
      <label>Date Arrived:</label> <input type="text" id="date" name="date" value= <?php echo $dateOption?> class="rounded-rectangle2" size="100" readonly ><br>
           <label>Staff Id:</label> <select id="staffId" name="staffId" style="height:25px; font-size:20px"><option>1</option></select><br>
           <input type="hidden" name="confirmation" value="yes">
                                                      <button type="submit" class="rounded-rectangle2" style="border-color: #7b1034; background-color:#7b1034; color: white; font-weight:bold; font-size:15px; margin-bottom:0 ; border-color: white;">Add Parcel</button>
                </pre>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('trackingNumber').addEventListener('input', function() {
            var inputValue = this.value;
            var isValidFormat = /^[0-9]{5}-[0-9]{3}-[0-9]{5}$/.test(inputValue);

            if (!isValidFormat) {
            this.setCustomValidity('Invalid format. Please use xxxxxx-xxx-xxxxx format.');
            } else {
            this.setCustomValidity('');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</body>
</html>
