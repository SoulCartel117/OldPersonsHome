<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('caregiverHome.css') }}">
    <title>Caregiver's Home</title>
</head>
<body>
    <p> <h1>Caregiver's Home</h1> </p>

    <section class="apptSection">
        <div class="apptDiv">
            <p>List of Patient's Duty Today</p>
        </div>
    </section><br><br>

    <section class="bottom">
        <table class="patientInfo">
            <tr>
                <th>Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
            
            @foreach ($Group1 as $group1)
            <form action="/caregiverHome" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <tr>
                    <td><input name="PID" value="{{$group1->patientID}}" style="visibility: hidden;">{{$group1->FName}} {{$group1->LName}}</td>
                    {{-- <td><input name="checkbox-1" type="checkbox"  /></td>
                    <td><input name="checkbox-2" type="checkbox"  /></td>
                    <td><input name="checkbox-3" type="checkbox"  /></td> --}}
                    <?php 
                    if ($group1->morningMed == 1) {
                        echo '<td><input name="checkbox-1" type="checkbox" checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-1" type="checkbox"  /></td>';
                    }
                    if ($group1->afternoonMed == 1) {
                        echo '<td><input name="checkbox-2" type="checkbox" checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-2" type="checkbox"  /></td>';
                    }
                    if ($group1->nightMed == 1) {
                        echo '<td><input name="checkbox-3" type="checkbox" checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-3" type="checkbox"  /></td>';
                    }
                    if ($group1->breakfast == 1) {
                        echo '<td><input name="checkbox-4" type="checkbox" checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-4" type="checkbox"  /></td>';
                    }
                    if ($group1->lunch == 1) {
                        echo '<td><input name="checkbox-5" type="checkbox" checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-5" type="checkbox"  /></td>';
                    }
                    if ($group1->dinner == 1) {
                        echo '<td><input name="checkbox-6" type="checkbox" checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-6" type="checkbox"  /></td>';
                    }
                    
                    ?>                    

                    <td><input type="submit" value="submit"></td>
                </tr>
            </form>
            @endforeach
            
        </table>
    </section>

    <div class="buttonDiv">
        <input type="submit" value="Submit">
        <input type="submit" value="Cancel">
    </div>
    <div>
        <form action="goBack" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="submit" value="Homepage">
        </form>
    </div>
</body>
</html>
