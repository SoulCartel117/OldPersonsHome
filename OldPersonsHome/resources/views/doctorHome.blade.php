<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('doctorHome.css') }}">
    <title>Doctor Home</title>
</head>
<body>
    <p> <h1>Doctor Home</h1> </p>

    <section class="search">
        <form class="example" action="/doctorHome" method="get">
            <label for="search" name="nameSearch"  class="searchAtt">Search by attribute</label>
            <select name="searchAttribute" id="search" class="dropdown">
                <option value="" disabled selected>Search by attribute...</option>
                <option value="1">First Name</option>
                <option value="2">Last Name</option>
                <option value="3">Comment</option>
            </select>

            <input type="text" value="" name="searchText">

            <input type="submit" class="button">
        </form>
    </section><br>

    <section class="doctorSection">
        <table class="doctorInfo">
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>
            @foreach ($oldAppts as $x)
                <tr>
                    <td class="dataRows"><?php echo $x['FName']." ".$x['LName'] ?></td>
                    <td class="dataRows"><?php echo date("m-d-Y", strtotime($x['date'])) ?></td>
                    <td class="dataRows"><?php echo $x['comment']?></td>

                    <?php 
                        if($x['morningMed'] == 1){
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
                        }elseif($medicationTaken[0]['afternoonMed'] == 1){
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
                </tr>
            @endforeach

        </table>
    </section><br>

    <section class="apptSection">
        <form action="">
            <label for="date" class="apptDate" >Appointments</label>
            <input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>" class="input">
            <input type="submit" class="submit" value="Submit">
        </form>
    </section><br>

    <section class="patient">
    <table class="patientInfo">
            <tr>
                <th>Patient</th>
                <th>Date</th>
            </tr>
            <?php 
                if(!isset($upcomingAppts)){
                    echo 
                    "<tr>
                        <td>Enter date for upcoming appointment</td>
                        <td></td>
                    </tr>";
                } else {
                    foreach ($upcomingAppts as $y){
                        echo
                        "<tr>
                            <td class='dataRows'>". $y['FName']." ".$y['LName']."</td>
                            <td class='dataRows'>". date("m-d-Y", strtotime($y['date']))."</td>
                        </tr>";
                    }
                }
            ?>
        
        </table>
    </section>
    <div>
        <form action="goBack" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="submit" value="Homepage">
        </form>
    </div>
    </body>
</html>
