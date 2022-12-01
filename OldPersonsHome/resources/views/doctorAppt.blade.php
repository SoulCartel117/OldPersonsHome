<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('doctorAppt.css') }}">
    <title>Doctor's Appointment</title>
</head>
<body>
    <p> <h1>Doctor's Appointment</h1> </p>

    <div class="mainDiv">
        <div class="leftDiv">
            <form action="">
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid"><br><br>

                <label for="date">Date</label>
                <input type="date" id="date" name="date"><br><br>

                <label for="did">Doctor</label>
                <select id="did" name="did">
                    <option value="did">Pick one</option>
                    <option value="did">Doctor 1</option>
                    <option value="did">Doctor 2</option>
                </select><br><br>

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
