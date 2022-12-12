<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('patientOfDoctor.css') }}">
    <title>Patient of Doctor</title>
</head>
<body>
    <p> <h1>Patient of Doctor</h1> </p>
<?php 
    $did = $_SESSION['user1'][0]['ID'];
    $test = DB::table('appointments')
    ->join('patient as p', 'p.doctorID', '=', 'appointments.doctorID')
    ->join('patient as pp', 'pp.patientID', '=', 'appointments.patientID')
    ->distinct()
    ->select('appointments.patientID', 'appointments.date', 'appointments.comment', 'appointments.doctorID', 'pp.patientID', 'p.medNameMorning', 'p.medNameAfternoon', 'p.medNameNight')
    ->where('appointments.doctorID', '=', $did)
    ->get();
    $test = json_decode(json_encode($test), true);
    
?>
    <section class="doctorPatient">
        <div class="patientDiv">
            <form action="/patientOfDoctor">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <p class="apptDiv">Search by patient's ID</p>
                <input type="text" name="pid" id="pid" onchange="nameFinder()">
            </form>
            <table class="doctorPatientInfo">
                <tr>
                    <th>Date</th>
                    <th>Comment</th>
                    <th>Morning Med</th>
                    <th>Afternoon Med</th>
                    <th>Night Med</th>
                </tr>
                <?php for($i=0; $i< count($test); $i++){ ?>
                <tr class="tdDate">
                    <td id="date"><?php echo $test[$i]['date']?></td>
                    <td id="comment"><?php echo $test[$i]['comment']?></td>
                    <td id="morningMed"><?php echo $test[$i]['medNameMorning']?></td>
                    <td id="afternoonMed"><?php echo $test[$i]['medNameAfternoon']?></td>
                    <td id="nightMed"><?php echo $test[$i]['medNameNight']?></td>
                </tr>
                <?php }; ?>
            </table>
        </div>
    </section><br>

    <section class="apptSection">
        <div class="apptDiv">
            <p>Appointments</p>
        </div>
    </section><br>
   

    <section class="patient">
    <table class="patientInfo">
            <tr>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>
            <tr>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
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

    <script>
    function nameFinder(){
        var test = JSON.parse('<?php echo json_encode($test) ?>');
        row = document.querySelectorAll(".tdDate");
        patientID = document.getElementById("pid").value;

        for(x=0; x<test.length; x++){
            const vis = test[x].patientID == (patientID);
            if(vis ==true ){
                row[x].style.display = "table-row";
            } else{
                row[x].style.display = "none";
            }
        }
    }
    </script>

</html>
