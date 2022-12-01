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
            <form action="">
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid"><br><br>

                <label for="gid">Group</label>
                <input type="text" id="gid" name="gid"><br><br>

                <label for="gid">Admission Date</label>
                <input type="text" id="gid" name="gid"><br><br>

            </form>
        </div>
            
        <div class="rightDiv">
            <label for="pid">Patient Name</label>
            <input type="text" id="pid" name="pid"><br><br>
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
</html>
