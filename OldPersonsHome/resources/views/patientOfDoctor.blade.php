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

    <section class="doctorPatient">
        <table class="doctorPatientInfo">
            <tr>
                <th>Date</th>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>
            <tr>
                <td>name</td>
                <td>name</td>
                <td>name</td>
                <td>name</td>
                <td>name</td>
            </tr>
        </table>
    </section><br>

    <section class="apptSection">
        <div class="apptDiv">
            <p>Appointments</p>
        </div>
    </section>
   

    <section class="patient">
    <table class="patientInfo">
            <tr>
                <th>Comment</th>
                <th>Morning Med</th>
                <th>Afternoon Med</th>
                <th>Night Med</th>
            </tr>
            <tr>
                <td>name</td>
                <td>name</td>
                <td>name</td>
                <td>name</td>
            </tr>
        </table>
    </section>

    <div class="buttonDiv">
        <input type="submit" value="Submit">
        <input type="submit" value="Cancel">
    </div>

    </body>
</html>
