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

    <div class="mainDiv">
        <div class="leftDiv">
            <form action="/patientAdditionalInfo" method="POST">
            @csrf
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid"><br><br>

                <label for="gid">Group</label>
                <input type="text" id="gid" name="gid"><br><br>

                <label for="did">Doctor ID</label>
                <select name="doctorID" id="did">
                    
                </select>

                <input type="submit" value="Submit">
                <input type="submit" value="Cancel">

            </form>
        </div>
            
        <div class="rightDiv">
            <form action="/patientAdditionalInfo" method="POST">
                <label for="pid">Patient Name</label>
                <input type="text" id="pid" name="pid"><br><br>
            </form>
        </div>
    </div>

    <div class="buttonDiv">
        <form action="/patientAdditionalInfo" method="POST">

        </form>
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
</html>
