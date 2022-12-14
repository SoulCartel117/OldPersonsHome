<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('patientAdditionalInfo.css') }}">
    <title>Patient Additional Info</title>
</head>
<body>
    <p> <h1>Addition Information of Patient</h1> </p>
    <?php
        $test = DB::table('accounts')->select('*')->whereroleidAndIsregapproved(5, 1)->get(); 
    ?>
    <div class="mainDiv">
        <div class="leftDiv">
            <form action="/patientAdditionalInfo" method="POST">
            @csrf
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid" onchange="nameFinder()"><br><br>

                <label for="did">Doctor</label>
                <select name="did" id="did">
                    @foreach ($Doctors as $doctor)
                        <option name="did" value="{{ $doctor->ID }}"> {{ $doctor->FName }} {{$doctor->LName}} </option>
                    @endforeach
                </select>
                <br><br>

                <label for="gid">Group ID</label>
                <select name="gid" id="gid">
                    @foreach ($Groups as $group)
                        <option name="gid" value="{{ $group->groupID }}"> {{ $group->groupID }} </option>
                    @endforeach
                </select>

                <input type="submit" value="Submit">
                <input type="submit" value="Cancel">

            </form>
        </div>
            
        <div class="rightDiv">
            <form action="/patientAdditionalInfo" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="pid">Patient Name</label>
                <input type="text" id="name" name="" value=""><br><br>
            </form>
        </div>
    </div>

    <div class="buttonDiv">
        <form action="/patientAdditionalInfo" method="POST">

        </form>
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
