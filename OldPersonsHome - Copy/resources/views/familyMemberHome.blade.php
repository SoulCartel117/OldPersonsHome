<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('familyMemberHome.css') }}">
    <title>Family Member's Home</title>
</head>
<body>
    <p> <h1>Family Member's Home</h1> </p>

    <div class="dateDiv">
        <form action="/familyMemberHome" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <label for="date">Date</label>
            <input type="date" name="date" id="frmDate" value="<?php echo date("Y-m-d"); ?>"><br><br>
            
            <label for="">Family code (For Patient Family Member)</label>
            <input type="text" name="fcid" id="" value=""><br>

            <label for="">Patient ID (For Patient Family Member)</label>
            <input type="text" name="pid" id="" value="">
            <input type="submit" value="Ok">
        </form>
    </div><br><br>
    <div class="error"> {{ $FCError }}  </div>
    <?php   ?>
    <div class="buttonDiv">
        <input type="submit" value="Submit">
        <input type="submit" value="Cancel">
    </div><br>

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
    <div><button type="button" class="cancelbtn" name="Logout"><a href="/login"</a>Logout</div>

</body>
</html>
