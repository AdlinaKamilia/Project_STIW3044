<?php
    require_once 'dbconnect.php';
    $status='';
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
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $payment = $_POST['payment']; 
            $status = $_POST['status'];
            $pickupDate = $_POST['pickupDate'];
            $description = $_POST['description'];
            
            if($payment == '' &&  $status == '')
            {
                $query = $connection->prepare('UPDATE parcel SET pdate_pickup = ?, parcel_description = ? WHERE parcel_id = ?');
                $result = $query->execute([$pickupDate, $description,  $parcel_id]);
            }
            else if($payment == ''){
                $query = $connection->prepare('UPDATE parcel SET parcel_status = ?,pdate_pickup = ?, parcel_description = ? WHERE parcel_id = ?');
                $result = $query->execute([$status, $pickupDate, $description,  $parcel_id]);
            }
            else if($status == ''){
                $query = $connection->prepare('UPDATE parcel SET parcel_payment = ?,pdate_pickup = ?, parcel_description = ? WHERE parcel_id = ?');
                $result = $query->execute([$payment, $pickupDate, $description,  $parcel_id]);
            }
            else{
                $query = $connection->prepare('UPDATE parcel SET parcel_payment = ?, parcel_status = ?, pdate_pickup = ?, parcel_description = ? WHERE parcel_id = ?');
                $result = $query->execute([$payment, $status, $pickupDate, $description,  $parcel_id]);
            }
            if ($result) {
                echo '<script>';
                echo 'alert("Entry saved successfully.");';
                echo 'setTimeout(function(){ window.location.href = "parcels.php?staff_id=' . $staff_id . '"; }, 500);';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'alert("Failed to save entry.");';
                echo 'setTimeout(function(){ window.location.href = "editParcel.php?id='.$parcel_id.'&staff_id=' . $staff_id . '"; }, 500);';
                echo '</script>';
            }
            exit;
        }
        
    }
    $today = new DateTime();
    $today->setTimezone(new DateTimeZone('Asia/Kuala_Lumpur'));
    $dateOption = $today->format('d-m-Y');
    echo $status;
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
            <a href="#" class="active">Edit Parcel</a>
            <a href="#" class="logout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </header>
    
    
    <div style="padding: 20px;">
        <h1>Edit Parcel</h1>
        <hr>
        <div class="forForm">
            <form method="post" id="addParcelForm">
                <table>
                    <tr>
                        <td><p style="margin-right: 500px">Parcel Id: <?php echo $parcel['parcel_id'] ?></p></td><td><p>Date Arrived: <?php echo $parcel['date_arrived'] ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Parcel Owner: <?php echo $parcel['parcel_owner'] ?></p></td><td><p>Staff Id: <?php echo $parcel['staff_id'] ?></p></td>
                    </tr>
                    <tr>
                        <td>
                            <label>Payment Status:</label>
                            <select id="payment" name="payment" onchange="updateParcelStatus()">
                                <option value="Paid" <?php echo ($parcel['parcel_payment'] == 'Paid') ? 'selected' : ''; ?> style="color: green;">Paid</option>
                                <option value="Outstanding" <?php echo ($parcel['parcel_payment'] == 'Outstanding') ? 'selected' : ''; ?> style="color: red;">Outstanding</option>
                            </select>
                        </td>
                        <td>
                            <label>Parcel Status:</label>
                            <select id="status" name="status" onchange="updateDate()" >
                                    <option value="Collected" style="color: green;" <?php echo ($parcel['parcel_status'] == 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                
                                    <option value="In Hub" style="color: red;" <?php echo ($parcel['parcel_status'] == 'In Hub') ? 'selected' : ''; ?>>In Hub</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <pre><br>
<label>Pickup Date          :</label> <input type="text" id="pickupDate" name="pickupDate" value="<?php echo ($parcel['parcel_status'] === 'Collected') ? $parcel['date_pickup'] : ''; ?>"  style="border-style: none; margin-bottom: 0px;font-size: 20px;" readonly>
                      <label style="font-size: 13px; margin-top: 0px;"> **To have pickup date please ensure the status of parcel is "Collected"</label><br>
<label>Tracking Number:</label> <input type="text" id="trackingNumber" name="trackingNumber" value="<?php echo ($parcel['tracking_number']); ?>" style="border-style: none;"  size="100" readonly><br>
<label>Description           :</label> <input type="text" id="description" name="description" class="rounded-rectangle2"  size="100" value ="<?php echo ($parcel['parcel_description']); ?>" ><br>
<label>Staff Id                   :</label> <select id="staffId" name="staffId" style="height:25px; font-size:20px" disabled><option>1</option></select><br>
<input type="hidden" name="confirmation" value="yes">
                                                      <button type="submit" class="rounded-rectangle2" style="border-color: #7b1034; background-color:#7b1034; color: white; font-weight:bold; font-size:15px; margin-bottom:0 ; border-color: white;">Edit Parcel</button>
                </pre>
                
            </form>
        </div>
    </div>
    <script>
        function confirmation() {
            var parcelId = '<?php echo $parcel_id; ?>';
            var confirmationText = "Are you sure you want to edit the following parcel id?\n\n";
            confirmationText += 'Parcel ID: ' + parcelId ;
            return confirm(confirmationText);   
        }
        window.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addParcelForm').addEventListener('submit', function(event) {
                if (!confirmation()) {
                    event.preventDefault(); // Prevent the form submission
                }
            });
        });
        document.getElementById('trackingNumber').addEventListener('input', function() {
            var inputValue = this.value;
            var isValidFormat = /^[0-9]{5}-[0-9]{3}-[0-9]{5}$/.test(inputValue);

            if (!isValidFormat) {
            this.setCustomValidity('Invalid format. Please use xxxxxx-xxx-xxxxx format.');
            } else {
            this.setCustomValidity('');
            }
        });
        function updateParcelStatus() {
            var paymentStatus = document.getElementById('payment').value;
            var parcelStatusSelect = document.getElementById('status');
            var parcelStatusOptions = parcelStatusSelect.getElementsByTagName('option');

            // Reset all options to be visible
            for (var i = 0; i < parcelStatusOptions.length; i++) {
                parcelStatusOptions[i].style.display = 'block';
            }

            // If payment status is 'Paid', hide 'In Hub' option
            if (paymentStatus === 'Outstanding') {
                var collectedOption = parcelStatusSelect.querySelector('option[value="Collected"]');
                collectedOption.style.display = 'none';
            }
        }
        function updateDate() {
            var statusSelect = document.getElementById('status');
            var selectedStatus = statusSelect.value;
            var pickupDateInput = document.getElementById('pickupDate');
            var dateOption = '<?php echo $dateOption; ?>';
            var originalStatus = '<?php echo $parcel['parcel_status']; ?>';

            if (originalStatus === 'Collected') {
                pickupDateInput.value = '<?php echo $parcel['date_pickup']; ?>';
            } else if (originalStatus === 'In Hub' && selectedStatus === 'Collected') {
                pickupDateInput.value = dateOption;
            } else if (originalStatus === 'In Hub' && selectedStatus === 'In Hub') {
                pickupDateInput.value = ''; // Clear the date input if neither condition is met
            }
        }

        // Call the function initially to update the parcel status based on the current payment status
        updateParcelStatus();
        
        // Disable the dropdowns if the original payment status is 'Paid' and parcel status is 'Collected'
        var originalPaymentStatus = '<?php echo $parcel['parcel_payment']; ?>';
        var originalParcelStatus = '<?php echo $parcel['parcel_status']; ?>';

        if (originalPaymentStatus === 'Paid' && originalParcelStatus === 'Collected') {
            var paymentInput = document.getElementById('payment');
            var statusInput = document.getElementById('status');
            paymentInput.disabled = true;
            statusInput.disabled = true;

        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</body>
</html>
