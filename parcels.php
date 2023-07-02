<?php
    require_once 'dbconnect.php';
    $status='';
    $payment='';
    if (isset($_GET['staff_id'])) {
        $staff_id = $_GET['staff_id']; 
    }
    $parcelList = array();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $dateF = date('d/m/Y', strtotime($_POST['date']));
        $date = DateTime::createFromFormat('d/m/Y', $dateF)->format('d/m/Y');
        $search = $_POST['search'];
        $status = $_POST['status'];
        $payment = $_POST['payment'];
       
        if($search != '' && $date == "01/01/1970" && $status =='' && $payment == '')
        {
            //masukkan take dta based on search only
            $query = $connection->query('SELECT * FROM parcel WHERE ptracking_number LIKE "%' . $search . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if($date != "01/01/1970" && $status == '' && $payment == '' &&  $search == ''){
            //masukkan based on date only
            $query = $connection->query('SELECT * FROM parcel WHERE pdate_arrived LIKE "%' . $date . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if($status !='' && $payment == '' && $date == "01/01/1970" && $search == '')
        {   
            $query = $connection->query('SELECT * FROM parcel WHERE parcel_status LIKE "%' . $status . '%"' );
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if( $payment != ''&& $status =='' && $date == "01/01/1970"&&  $search == '')
        {
            $query = $connection->query('SELECT * FROM parcel WHERE parcel_payment LIKE "%' . $payment . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($search != '' &&  $date != "01/01/1970") && ($status =='' && $payment == '')){
            $query = $connection->query('SELECT * FROM parcel WHERE ptracking_number LIKE "%' . $search . '%" AND pdate_arrived LIKE "%' . $date . '%" ');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(( $search != '' && $status !='') && ($date == "01/01/1970" && $payment == '')){
            $query = $connection->query('SELECT * FROM parcel WHERE ptracking_number LIKE "%' . $search . '%" AND parcel_status LIKE "%' . $status . '%" ');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($search != '' && $payment != '') && ($status =='' && $date == "01/01/1970"))
        {
            $query = $connection->query('SELECT * FROM parcel WHERE parcel_payment LIKE "%' . $payment . '%" AND ptracking_number LIKE "%' . $search . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($date != "01/01/1970" && $status !='') && ($search == '' && $payment == '')){
            $query = $connection->query('SELECT * FROM parcel WHERE pdate_arrived LIKE "%' . $date . '%" AND parcel_status LIKE "%' . $status . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($date != "01/01/1970" && $payment != '') && ($search == '' && $status =='')){
            $query = $connection->query('SELECT * FROM parcel WHERE parcel_payment LIKE "%' . $payment . '%" AND pdate_arrived LIKE "%' . $date . '%" ');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($status !='' && $payment != '') && ($search == '' &&  $date == "01/01/1970")){
            $query = $connection->query('SELECT * FROM parcel WHERE parcel_payment LIKE "%' . $payment . '%" AND parcel_status LIKE "%' . $status . '%" ');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($search != '' && $date != "01/01/1970" && $status !='') && $payment == '')
        {
            $query = $connection->query('SELECT * FROM parcel WHERE ptracking_number LIKE "%' . $search . '%" AND pdate_arrived LIKE "%' . $date . '%" AND parcel_status LIKE "%' . $status . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($search != '' && $date != "01/01/1970" && $payment != '')&&  $status == ''){
            $query = $connection->query('SELECT * FROM parcel WHERE ptracking_number LIKE "%' . $search . '%" AND pdate_arrived LIKE "%' . $date . '%" AND parcel_payment LIKE "%' . $payment . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($status !='' && $date != "01/01/1970" && $payment != '') && $search == ''){
            $query = $connection->query('SELECT * FROM parcel WHERE parcel_status LIKE "%' . $status . '%" AND pdate_arrived LIKE "%' . $date . '%" AND parcel_payment LIKE "%' . $payment . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else if(($search != '' && $status !='' && $payment != '') && $date == "01/01/1970"){
            $query = $connection->query('SELECT * FROM parcel WHERE parcel_status LIKE "%' . $status . '%" AND ptracking_number LIKE "%' . $search . '%" AND parcel_payment LIKE "%' . $payment . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }else if(($search != '' && $status !='' && $payment != '' && $date != "01/01/1970")){
            $query = $connection->query('SELECT * FROM parcel WHERE parcel_status LIKE "%' . $status . '%" AND ptracking_number LIKE "%' . $search . '%" AND parcel_payment LIKE "%' . $payment . '%" AND pdate_arrived LIKE "%' . $date . '%"');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            $query = $connection->query('SELECT * FROM parcel');
            $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }else{
        $query = $connection->query('SELECT * FROM parcel');
        $parcel_entries = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    if (count($parcel_entries) > 0) {
        foreach ($parcel_entries as $row) {  // Iterate through each booking entry
            $parcel = array();
            $parcel['parcel_id'] = $row['parcel_id'];
            $parcel['parcel_owner'] = $row['parcel_owner'];
            $parcel['staff_id'] = $row['pstaff_id'];
            $parcel['date_arrived'] = $row['pdate_arrived'];
            $parcel['date_pickup'] = $row['pdate_pickup'];
            $parcel['tracking_number'] = $row['ptracking_number'];
            $parcel['parcel_status'] = $row['parcel_status'];
            $parcel['parcel_payment'] = $row['parcel_payment'];
            $parcel['parcel_description'] = $row['parcel_description'];
            $parcelList[] = $parcel;  // Add the booking entry to the array
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <script>
        function confirmDelete(parcelId, staff_id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "deleteParcel.php?id=" + parcelId + "&staff_id=" + staff_id;
            }
        }
        function goToDetail(parcelId, staff_id) {
                window.location.href = "displayParcel.php?id=" + parcelId + "&staff_id=" + staff_id;
        }
        function goToEdit(parcelId, staff_id) {
                window.location.href = "editParcel.php?id=" + parcelId + "&staff_id=" + staff_id;
        }
    </script>
    <title>ShipWave Mainpage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navigationStyle.css">
    <link rel="stylesheet" href="css/parcelListStyle.css">

</head>
<body>
    <header class="header">
        <h2 class="shipwave-text" style ="font-weight: bold;">
            ShipWave
        </h2>
        <div class="navigation-bar">
            <a href="mainpage.php?staff_id=<?php echo $staff_id?>" >Mainpage</a>
            <a href="#" class="active">Parcel</a>
            <a href="#" class="logout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </header>
    <div class="section">
        <form method="post">
            <div style = "padding-top: 10px ; padding-bottom:10px ; justify-content: center;display: flex;">
                <pre><label for="search">Search parcel: </label> <input type="text" id="search" name="search" placeholder="Enter Parcel Tracking Number"> <label for="date">Date: </label> <input type="date" name="date"> <label for="status">Status: </label> <select id="status" name="status"><option value="" <?php echo ($status == '') ? 'selected' : ''; ?>>Default</option><option value="Collected" style="color: green;" <?php echo ($status == 'Collected') ? 'selected' : ''; ?> >Collected</option><option value="In Hub" style="color: #D10A0A;" <?php echo ($status == 'In Hub') ? 'selected' : ''; ?>>In Hub</option></select> <label for="payment">Payment: </label><select id="payment" name="payment"><option value="" <?php echo ($payment == '') ? 'selected' : ''; ?>>Default</option><option value="Paid" <?php echo ($payment == 'Paid') ? 'selected' : ''; ?> style="color: green;">Paid</option><option value="Outstanding" <?php echo ($payment == 'Outstanding') ? 'selected' : ''; ?> style="color: #D10A0A;">Outstanding</option></select> <input type="submit" value="Filter" style="background-color: #7b1034;color: white;padding-left: 20px;padding-right: 20px;border-radius: 40px; border-color: white; font-weight: bold;"> </pre>  
            </div>
        </form>
        <table>
            <thead>
              <tr>
                <th>Parcel Date</th>
                <th>Parcel ID</th>
                <th>Parcel Owner</th>
                <th>Tracking Number</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php
                    for($i=0; $i<count($parcelList); $i++){
                        echo "<tr>";
                        echo "<td>" . $parcelList[$i]['date_arrived'] . "</td>";
                        echo "<td>" . $parcelList[$i]['parcel_id'] . "</td>";
                        echo "<td>" . $parcelList[$i]['parcel_owner'] . "</td>";
                        echo "<td>" . $parcelList[$i]['tracking_number'] . "</td>";
                        $paymentStatus = $parcelList[$i]['parcel_payment'];
                        $paymentColor = ($paymentStatus == 'Outstanding') ? '#D10A0A' : 'green';
                        echo "<td style='color: $paymentColor; font-weight: bold;'>" . $paymentStatus . "</td>";
                        $parcelStatus = $parcelList[$i]['parcel_status'];
                        $statusColor = ($parcelStatus == 'In Hub') ? '#D10A0A' : 'green';
                        echo "<td style='color: $statusColor; font-weight: bold;'>" . $parcelStatus . "</td>";
                        echo '<td>
                        <div class="action-container">
                            <button class="click-container" style="background-color: #252F9C; border-color: white;" onClick= "goToDetail('. $parcelList[$i]['parcel_id'] .',' . $staff_id .')";>
                                <div>
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <p>Details</p>
                                </div>
                            </button>
                            <button class="click-container" style=" background-color: #7b1034; border-color: white;" onClick= "goToEdit('. $parcelList[$i]['parcel_id'] .',' . $staff_id .')">
                                <div>
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div>
                                    <p>Edit</p>
                                </div>
                            </button>
                            <button class="click-container" style="background-color: #D10A0A; border-color: white;" onClick= "confirmDelete('. $parcelList[$i]['parcel_id'] .',' . $staff_id .')";>
                                <div>
                                    <i class="fas fa-trash"></i>
                                </div>
                                <div>
                                    <p>Delete</p>
                                </div>
                            </button>
                        </div>
                    </td>';
                        echo "</tr>";  
                    }
                ?>
            </tbody>
        </table>     
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <footer style="position: fixed;">
        <div class="add-parcel-button">
            <a href = "addParcel.php?staff_id=<?php echo $staff_id?>">
                <button>Add Parcel</button>
            </a>
            
        </div>
    </footer>
</body>
</html>