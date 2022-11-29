<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('doctorHome.css') }}">
    <title>Doctor Home</title>
</head>
<body>
    <p> <h1>Doctor Home</h1> </p>

    <section class="search">
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search name.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search date.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search comment.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search morning med.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search afternoon med.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search night med.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
    </section><br>

    <section class="doctorSection">
        <table class="doctorInfo">
            <tr>
                <th>Name</th>
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
                <td>name</td>
            </tr>
        </table>
    </section><br>

    <section class="apptSection">
        <form action="">
            <label for="date">Appointments</label>
            <input type="text" name="frmDateReg" required id="frmDate" value="" class="input">
            <input type="submit" class="submit" value="Submit">
        </form>
    </section><br>

    <section class="patient">
    <table class="patientInfo">
            <tr>
                <th>Patient</th>
                <th>Date</th>
            </tr>
            <tr>
                <td>name</td>
                <td>name</td>
            </tr>
        </table>
    </section>

    </body>
</html>
