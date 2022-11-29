<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('newRoster.css') }}">
    <title>New Roster</title>
</head>
<body>
    <p> <h1>New Roster</h1> </p>

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

            <label for="super">Supervisor</label>
            <select id="super" name="supervisor">
                <option></option>
                <option value="something">some loop in here to make the right supervisors show</option>
            </select><br><br>

            <label for="doctor">Doctor</label>
            <select id="doctor" name="Doctor">
                <option></option>
                <option value="something">some loop in here to make the right doctor show</option>
            </select><br><br>

            <label for="caregiver">Caregiver 1</label>
            <select id="caregiver" name="caregiver">
                <option></option>
                <option value="something">some loop in here to make the right caregiver show</option>
            </select><br><br>

            <label for="caregiver">Caregiver 2</label>
            <select id="caregiver" name="caregiver">
                <option></option>
                <option value="something">some loop in here to make the right caregiver show</option>
            </select><br><br>

            <label for="caregiver">Caregiver 3</label>
            <select id="caregiver" name="caregiver">
                <option></option>
                <option value="something">some loop in here to make the right caregiver show</option>
            </select><br><br>

            <label for="caregiver">Caregiver 4</label>
            <select id="caregiver" name="caregiver">
                <option></option>
                <option value="something">some loop in here to make the right caregiver show</option>
            </select><br><br>

        </form>
    </div>

    <div class="buttonDiv">
        <input type="submit" value="Submit">
        <input type="submit" value="Cancel">
    </div>

</body>
</html>
