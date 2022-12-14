
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('patientHome.css') }}">
    <title>Patient's Home</title>
</head>
<body>
    <p> <h1>Patient's Home</h1> </p>


    <div class="mainDiv">
        <div class="leftDiv">
            <form action="/patientHome" method="GET">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid" value="<?php echo $_SESSION['user1'][0]['ID'] ;?> " disabled><br><br>

                <label for="date">Date</label>
                <input type="date" name="date" required id="frmDate" value="<?php echo $date ?>"><br><br>
                <input type="submit"><br><br>
               
            </form>
        </div>
            <p></p>
        <div class="rightDiv">
            <label for="pid">Patient Name</label>
            <input type="text" id="name" name="pid" value=" <?php echo $_SESSION['user1'][0]['FName'].' '. $_SESSION['user1'][0]['LName'] ?>" disabled><br><br>
        </div>
    </div>
  
    <section class="bottom">
        <table class="patientInfo">
            <tr>
                <th>Doctor's Name</th>
                <th>Doctor's Appointment</th>
                <th>Caregiver's Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
            <tr>
            <?php
                if(!isset($doctor)){
                    echo "<td></td>";
                } elseif($doctor == null) {
                    echo "<td></td>";
                }else {
                    echo "<td>".$doctor[0]['FName']." ".$doctor[0]['LName']."</td>";
                }
            ?>
            
            <?php 
                if(!isset($apptDate)){
                    echo "<td class='unchecked'>
                    <input id='checkbox-1' type='checkbox' unchecked disabled />
                    </td>";
                }elseif($apptDate == $date){
                    echo "<td class='checked'>
                    <input id='checkbox-1' type='checkbox' checked disabled />
                    </td>";
                }else {
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }
            ?>
                
            <?php 
                if(!isset($caregiver)){
                    echo "<td></td>";
                }else{
                    echo "<td>".$caregiver[0]['FName']." ".$caregiver[0]['LName']."</td>"; 
                }
            ?>

            <?php 
                if(!isset($medicationTaken)){
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }elseif($medicationTaken[0]['morningMed'] == 1){
                    echo "<td class='checked'>
                    <input id='checkbox-1' type='checkbox' checked disabled />
                    </td>";
                } else {
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }
            ?>

            <?php 
                if(!isset($medicationTaken)){
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }elseif($medicationTaken[0]['nightMed'] == 1){
                    echo "<td class='checked'>
                    <input id='checkbox-1' type='checkbox' checked disabled />
                    </td>";
                } else {
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }
            ?>

            <?php 
                if(!isset($medicationTaken)){
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }elseif($medicationTaken[0]['nightMed'] == 1){
                    echo "<td class='checked'>
                    <input id='checkbox-1' type='checkbox' checked disabled />
                    </td>";
                } else {
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }
            ?>

            <?php 
                if(!isset($meals)){
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }elseif($meals[0]['breakfast'] == 1){
                    echo "<td class='checked'>
                    <input id='checkbox-1' type='checkbox' checked disabled />
                    </td>";
                } else {
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }
            ?>

            <?php 
                if(!isset($meals)){
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }elseif($meals[0]['lunch'] == 1){
                    echo "<td class='checked'>
                    <input id='checkbox-1' type='checkbox' checked disabled />
                    </td>";
                } else {
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }
            ?>

            <?php 
                if(!isset($meals)){
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }elseif($meals[0]['dinner'] == 1){
                    echo "<td class='checked'>
                    <input id='checkbox-1' type='checkbox' checked disabled />
                    </td>";
                } else {
                    echo "<td class='unchecked'> <input id='checkbox-1' type='checkbox' disabled /> </td>";
                }
            ?>
                
            </tr>
        </table>
    </section>
    <div><button type="button" class="cancelbtn" name="Logout"><a href="/login"></a>Logout</div>
</body>
</html>