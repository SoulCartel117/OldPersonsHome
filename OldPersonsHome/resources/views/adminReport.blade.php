<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('adminReport.css') }}">
    <title>Admin's Report</title>
</head>
<body>
    <p> <h1>Admin's Report</h1> </p>

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
            
            <p>Missed Patient Activity</p>
        </form>
    </div>

    <section class="bottom">
        <table class="patientInfo">
            <tr>
                <th>Patient's Name</th>
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
                <td>some php/js to input name</td>
                <td><input id="checkbox-1" type="checkbox" checked disabled /></td>
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
</body>
</html>