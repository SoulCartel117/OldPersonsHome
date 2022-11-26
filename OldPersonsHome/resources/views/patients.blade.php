<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('patients.css') }}">
    <title>Patients</title>
</head>
<body>
    <p> <h1>Patient</h1> </p>

    <section class="search">
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search ID.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search name.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search age.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search Em Cont.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search Em Cont Name.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
        <form class="example" action="action_page.php">
            <input type="text" placeholder="Search admission date.." name="search">
            <button type="submit"><i class="fa fa-search">Search</i></button>
        </form>
    </section><br>

    <section class="top">
        <table class="patientInfo">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Emergency Contact</th>
                <th>Emergency Contact Name</th>
                <th>Admission Date</th>
            </tr>
            <tr>
                <td>something</td>
                <td>will</td>
                <td>go</td>
                <td>here</td>
                <td>and</td>
                <td>here</td>
            </tr>
        </table>

    </section>

    <div class="buttonDiv">
        <input type="submit" value="Submit">
        <input type="submit" value="Cancel">
    </div>
</body>
</html>
