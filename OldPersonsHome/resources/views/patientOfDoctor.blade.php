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
use Illuminate\Support\Facades\DB;
    $did = $_SESSION['user1'][0]['ID'];

    $date1 = date("y-m-d");

    $test = DB::select("select a.appointmentID, a.comment, a.patientID, p.medNameMorning, p.medNameAfternoon, p.medNameNight, a.date FROM patient p join appointments a on a.doctorID = p.doctorID where a.doctorID = $did group by a.appointmentID order by date asc;");
    // select * from (SELECT doctorID, patientID, comment, date FROM `appointments` where patientID = 48 and doctorID = 43) a join (SELECT patientID, doctorID, medNameMorning, medNameAfternoon, medNameNight FROM `patient` where doctorID = 43 and patientID = 48) b on a.doctorID=b.doctorID where date = '2022-12-07';
    $test = json_decode(json_encode($test), true);


    $test1 = DB::table('appointments')
    ->join('patient as p', 'p.doctorID', '=', 'appointments.doctorID')
    ->join('patient as pp', 'pp.patientID', '=', 'appointments.patientID')
    ->distinct()
    ->select('appointments.patientID', 'appointments.date', 'appointments.comment', 'appointments.doctorID', 'pp.patientID', 'p.medNameMorning', 'p.medNameAfternoon', 'p.medNameNight')
    ->where('appointments.doctorID', '=', $did)
    ->where('appointments.date', '>=', date("Y-m-d"))
    ->get();
    $test1 = json_decode(json_encode($test1), true);
    
?>
    <section class="doctorPatient">
        <div class="patientDiv">
            <form action="/patientOfDoctor" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <p class="apptDiv">Search by patient's ID</p>
                <input type="text" name="pid" id="pid" onchange="nameFinder()">
            
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
            <p>New Prescription</p>
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
                    <div class="inputDiv" >
                        <tr>
                            <td id="disabled"><input type="text" name="comment"></td>
                            <td id="disabled"><input type="text" name="morningMed"></td>
                            <td id="disabled"><input type="text" name="afternoonMed"></td>
                            <td id="disabled"><input type="text" name="nightMed"></td>
                        </tr>
                    </div>
                </table><br><br>
                <input type="submit" class="buttonDiv">
        </form>
    </section>

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

        var test1 = JSON.parse('<?php echo json_encode($test1) ?>');
        const date = new Date().toJSON().slice(0, 10);
        console.log(test1)
            if(test1[0].date == date ){
                document.getElementById("disabled").style.display = "block";
            } else{
                document.getElementById("disabled").style.display = "none";
                console.log(document.getElementById("disabled"));
            }
    }

    </script>

</html>
