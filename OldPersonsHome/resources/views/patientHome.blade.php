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
    <?php 
        $test = DB::table('accounts')->select('*')->whereroleidAndIsregapproved(5, 1)->get(); 
        $test1 = DB::table('accounts')->join('roster', 'roster.doctorID',  '=', 'accounts.ID')->select('roster.doctorID', 'accounts.FName', 'accounts.LName', 'roster.date')->get(); 
    ?>
    <p> <h1>Patient's Home</h1> </p>

    <div class="mainDiv">
        <div class="leftDiv">
            <form action="/patientHome">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid" onchange="nameFinder()"><br><br>

                <label for="date">Date</label>
                <input type="date" name="frmDateReg" required id="frmDate" value="<?php echo date("Y-m-d");?>"><br><br>
               
            </form>
        </div>
            
        <div class="rightDiv">
            <label for="pid">Patient Name</label>
            <input type="text" id="name" name="pid"><br><br>
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
                <td>some php/js to input name</td>
                <td>
                    <input id="checkbox-1" type="checkbox" checked disabled />
                </td>
                <td>some php/js to input name</td>
                <td><input id="checkbox-1" type="checkbox" checked disabled /></td>
                <td><input id="checkbox-1" type="checkbox" checked disabled /></td>
                <td><input id="checkbox-1" type="checkbox" checked disabled /></td>
                <td><input id="checkbox-1" type="checkbox" checked disabled /></td>
                <td><input id="checkbox-1" type="checkbox" checked disabled /></td>
                <td><input id="checkbox-1" type="checkbox" checked disabled /></td>
            </tr>
        </table>
    </section>
    <div><button type="button" class="cancelbtn" name="Logout"><a href="/login"</a>Logout</div>
</body>
<script>
    function nameFinder(){
        var test = JSON.parse('<?php echo json_encode($test) ?>');
        patientID = document.getElementById("pid").value;
        for(x=0; x<test.length; x++){
            if(patientID == test[x].ID){
            document.getElementById("name").value = test[x].FName + " " + test[x].LName;
            break;
            }
            else{
                document.getElementById("name").value = "";
            }
        }
    }
</script>
</html>