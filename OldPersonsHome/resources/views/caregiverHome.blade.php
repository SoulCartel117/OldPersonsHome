<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('caregiverHome.css') }}">
    <title>Caregiver's Home</title>
</head>
<body>
    <p> <h1>Caregiver's Home</h1> </p>

    <section class="apptSection">
        <div class="apptDiv">
            <p>List of Patient's Duty Today</p>
        </div>
    </section><br><br>

    <section class="bottom">
        <table class="patientInfo">
            <tr>
                <th>Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
            <tr>
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
