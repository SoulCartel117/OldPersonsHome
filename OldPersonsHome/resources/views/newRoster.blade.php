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
        <form action="/newRoster" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <label for="date">Date</label>
            <input type="date" name="frmDateReg" required id="frmDate" value=""><br><br>
            <script>
                document.getElementById('frmDate').valueAsDate = new Date();
            </script>

            
            <div class="dateDiv">
                <label for="super">Supervisor</label>
                <select id="super" name="Supervisor">
                    <option value="" disabled selected>Select a Supervisor</option>
                    @foreach ($Super as $Super)
                        <option value="{{ $Super->ID }}"> {{ $Super->FName }} {{$Super->LName}} </option>
                    @endforeach
                </select>
            </div>
            <br><br>

            <div class="dateDiv">
                <label for="doctor">Doctor</label>
            <select id="doctor" name="Doctor">
                <option value="" disabled selected>Select a Doctor</option>
                @foreach ($Doctors as $Doctor)
                    <option value="{{ $Doctor->ID }}"> {{ $Doctor->FName }} {{$Doctor->LName}} </option>
                @endforeach
            </select>
            </div>
            <br><br>

            <div class="dateDiv">
                <label for="caregiver">Group 1</label>
                <select id="caregiver1" name="caregiver1">
                    <option value="" disabled selected>Select a Caregiver for Group 1</option>
                    @foreach ($Care as $caregiver)
                        <option value="{{ $caregiver->ID }}"> {{ $caregiver->FName }} {{$caregiver->LName}} </option>
                    @endforeach
                </select>
            </div>
            <br><br>

            <div class="dateDiv">
                <label for="caregiver">Group 2</label>
                <select id="caregiver2" name="caregiver2">
                    <option value="" disabled selected>Select a Caregiver for Group 2</option>
                    @foreach ($Care as $caregiver)
                        <option value="{{ $caregiver->ID }}"> {{ $caregiver->FName }} {{$caregiver->LName}} </option>
                    @endforeach
                </select>
            </div>
            <br><br>

            <div class="dateDiv">
                <label for="caregiver">Group 3</label>
                <select id="caregiver3" name="caregiver3">
                    <option value="" disabled selected>Select a Caregiver for Group 3</option>
                    @foreach ($Care as $caregiver)
                        <option value="{{ $caregiver->ID }}"> {{ $caregiver->FName }} {{$caregiver->LName}} </option>
                    @endforeach
                </select>
            </div>
            <br><br>

            <div class="dateDiv">
                <label for="caregiver">Group 4</label>
                <select id="caregiver4" name="caregiver4">
                    <option value="" disabled selected>Select a Caregiver for Group 4</option>
                    @foreach ($Care as $caregiver)
                        <option value="{{ $caregiver->ID }}"> {{ $caregiver->FName }} {{$caregiver->LName}} </option>
                    @endforeach
                </select>
            </div>
            <br><br>

    </div>

        <div class="buttonDiv">
            <input type="submit" value="Submit">
            <input type="submit" value="Cancel">
        </div>
    </form>

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
