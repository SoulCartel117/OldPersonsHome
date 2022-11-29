<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('roster.css') }}">
    <title>Roster</title>
</head>
<body>
    <p> <h1>Roster</h1> </p>

    <div class="dateDiv">
        <form action="">
            <label for="date">Date</label>
            <input type="text" name="frmDateReg" required id="frmDate" value=""><br><br>
            <script>
                function getDate(){
                    var todaydate = new Date();
                    var day = todaydate.getDate();
                    var month = todaydate.getMonth() + 1;
                    var year = todaydate.getFullYear();
                    var datestring = month + "/" + day + "/" + year;
                    document.getElementById("frmDate").value = datestring;
                } 
                getDate(); 
            </script>
            
        </form>
    </div>

    <section class="roster">
        <table class="rosterInfo">
            <tr>
                <th>Supervisor</th>
                <th>Doctor</th>
                <th>Caregiver 1</th>
                <th>Caregiver 2</th>
                <th>Caregiver 3</th>
                <th>Caregiver 4</th>
            </tr>
            <tr>
                <td>name</td>
                <td>name</td>
                <td>name</td>
                <td>name</td>
                <td>name</td>
                <td>name</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>PatientGroup1</td>
                <td>PatientGroup2</td>
                <td>PatientGroup3</td>
                <td>PatientGroup4</td>
            </tr>
        </table>

    </section>
</body>
</html>
