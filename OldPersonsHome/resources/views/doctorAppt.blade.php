<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('doctorAppt.css') }}">
    <title>Doctor's Appointment</title>
    
</head>
<body>
    <p> <h1>Doctor's Appointment</h1> </p>
    <?php 
        $test = DB::table('accounts')->select('*')->whereroleidAndIsregapproved(5, 1)->get(); 
        $test1 = DB::table('accounts')->join('roster', 'roster.doctorID',  '=', 'accounts.ID')->select('roster.doctorID', 'accounts.FName', 'accounts.LName', 'roster.date')->get(); 
    ?>
    <div class="mainDiv">
        <div class="leftDiv">
            <form action="/doctorAppt" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid" onchange="nameFinder()"><br><br>
            
                <label for="date">Date</label>
                <input type="date" id="date" name="date" onchange="doctorFinder()" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"><br><br>
          
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="did">Doctor</label>
                <select name="did">
                    <option value="did" disabled selected>Pick one</option>
                    <option value="did" id="did"></option>
                </select><br><br>
                <label for="cid">Comment</label><br><br>
                <textarea id="cid" name="cid" maxlength="240" placeholder="Enter Comment Here..." autofocus></textarea>
                <input class='okSubmit' type='submit' id='11' name='enterAppt' value='OK'>
            </form>
        </div>

        <div class="rightDiv">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <label for="pid">Patient Name</label>
            <input type="text" id="name" name="" value="" disabled><br><br>
        </div>
    </div>
    
    <div class="buttonDiv">
        <input type="submit" value="Submit">
        <input type="submit" value="Cancel">
    </div>
    <div>
        <script>
            function goBack() {
              window.history.back();
            }
            </script>
        <button onclick="goBack()">Go Back</button>
    </div>
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

    function doctorFinder(){
        var test1 = JSON.parse('<?php echo json_encode($test1) ?>');
        date = document.getElementById("date").value;
        for(x=0; x<test1.length; x++){
            if(date == test1[x].date){
            document.getElementById("did").value = test1[x].doctorID;
            document.getElementById("did").innerHTML = test1[x].FName + " " + test1[x].LName;
            break;
            }
            else{
                document.getElementById("did").value = "";
                document.getElementById("did").innerHTML = "";
            }
        }
    }
</script>
</html>
