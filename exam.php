<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = mysqli_connect('localhost', 'root', '', 'rent');


$qry = "CREATE TABLE IF NOT EXISTS `car` (
    `booking_id` int(11) NOT NULL PRIMARY KEY,
    `rent_date` date NOT NULL,
    `no_of_seat` varchar(50) NOT NULL,
    `rent_rate` int(20) NOT NULL
    
  )";

$create_table = mysqli_query($db, $qry);

$err_msg = $succ_msg = '';



if (isset($_POST['add_car'])) {
    $booking = $_POST['bid'];
    $rentdate = $_POST['rd'];
    $seat = $_POST['seat'];
    $rate = $_POST['rr'];
  

    $err_msg .= (empty($booking)) ? '<p>Please enter  booking id</p>' : '';
    $err_msg .= (empty($rentdate)) ? '<p>Please enter  date of rent</p>' : '';
    $err_msg .= (empty($seat)) ? '<p>Please enter  no of seats</p>' : '';
    $err_msg .= (empty($rate)) ? '<p>Please enter rate of rent</p>' : '';
  

    if (strlen($err_msg) == 0) {
        $insert_car = "INSERT INTO car (booking_id, rent_date,no_of_seat,rent_rate) VALUES ('$booking','$rentdate','$seat','$rate')";
        $insert_result = mysqli_query($db, $insert_car);

        if ($insert_result)
            $succ_msg = "<p>Successfully added data</p>";
        else
            $err_msg = "<p>Could not add data</p>";
    }
}


if (isset($_POST['search_car'])) {
    $date = '%'. $_POST['date'] . '%';
    $search_qry = "SELECT * from car where rent_date LIKE '$date'";
    $srch = mysqli_query($db, $search_qry);
}


?>

<title>Rent Car</title>

<body>

    <center>
        <b><h4>CAR RENTAL SYSTEM</h4></b>
    </center>

    <div class="container">

        <div>

            <form method="post">
                <input type="date" name="date" id="date" placeholder="Enter date to search ...">
                <input type="submit" name="search_car" value="Search">
            </form>

            <?php if (isset($_POST['search_car'])) {
            ?>
                <table>
                    <thead>
                        <tr>
                            <th>Booking_Id</th>
                            <th>Rent_Date</th>
                            <th>No of Seat</th>
                            <th>Rent Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                         while ($cars = mysqli_fetch_array($srch)) {
                    ?>
                        <tr>
                            <td><?= $cars['booking_id'] ?></td>
                            <td><?= $cars['rent_date'] ?></td>
                            <td><?= $cars['no_of_seat'] ?></td>
                            <td><?= $cars['rent_rate'] ?></td>

                        </tr>
                    <?php }  ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>


      

        <div class="alert alert-error" id="error_message" style="display: none;">
            </div>

            <?php if (strlen($err_msg > 0)) : ?>


                <div class="alert alert-error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $err_msg ?>
                </div>


            <?php endif; ?>

            <?php if (strlen($succ_msg > 0)) : ?>


                <div class="alert alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $succ_msg ?>
                </div>



            <?php endif; ?>



            <form method="post" onsubmit="return check_validation()">
                <label for="fname">Booking Id</label>
                <input type="number" id="bid" name="bid" required>



                <label for="lname">Rent Date</label>
                <input type="date" id="rd" name="rd" required>


                <label for="lname">No Of Seats</label>
                <input type="number" id="seat" name="seat" required>


                <label for="lname">Rent Rate</label>
                <input type="text" id="rr" name="rr" required>


                



                <input type="submit" name="add_car" value="Add">
            </form>
        </div>



    </div>
</body>
<script>
function check_validation() {
        var seat= document.getElementById("seat").value;
        var rate= document.getElementById("rr").value;
        


        var error_message = document.getElementById("error_message");

        var err_msg = "";
        if (seat > 7 )
            err_msg += "<p>Not applicable</p>";
            
            if (rate > 5000 )
            err_msg += "<p>cannot accept rate</p>";
        

       
        if (err_msg.length == 0)
            return true;



        error_message.style.display = 'block';
        error_message.innerHTML = err_msg;
        return false;
    }
</script>


<style>
    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 8px;
    }


 
    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #cd5c5c;
        color: white;
    }



    input[type=text],
    input[type=date],
    input[type=time],
    input[type=number],
    textarea,
    select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[name=search_car] {
        background-color: #d2691e !important;
    }

    input[type=submit] {
        width: 30%;
        background-color: #008080;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #5f9ea0;
    }

    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }

    .col-3 {
        width: 50%;
    }

    .alert {
        padding: 20px;
        background-color: #f44336;
        color: #fff;
        margin-bottom: 2%;
    }

    .alert-error {
        background-color: #f44336;
    }

    .alert-success {
        background-color: #2eb885;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>