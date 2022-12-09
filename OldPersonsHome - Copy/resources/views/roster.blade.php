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
        <form action="/roster" method="get">
            <label for="date">Date</label>
            <input type="date" name="frmDateReg" required id="frmDate" value="{{$date}}"><br><br>
            <input class='okSubmit' type='submit' id='11' name='searchByDate' value='OK'>
        </form>
    </div>

    <section class="roster">
        <table class="rosterInfo">
            <tr>
                <th>Supervisor</th>
                <th>Doctor</th>
                <th>Group 1</th>
                <th>Group 2</th>
                <th>Group 3</th>
                <th>Group 4</th>
            </tr>
            <tr>
                <?php echo
                "<td>".$users5[0]['FName']." ".$users5[0]['LName']."</td> 
                <td>".$users0[0]['FName']." ".$users0[0]['LName']."</td> 
                <td>".$users1[0]['FName']." ".$users1[0]['LName']."</td> 
                <td>".$users2[0]['FName']." ".$users2[0]['LName']."</td> 
                <td>".$users3[0]['FName']." ".$users3[0]['LName']."</td> 
                <td>".$users4[0]['FName']." ".$users4[0]['LName']."</td> "
                ?>
            </tr>
        </table>
    </section>
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
