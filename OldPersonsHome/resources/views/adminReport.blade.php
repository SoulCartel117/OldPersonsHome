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
                @foreach ($Group1 as $group1):
                <td>{{$group1->FName}} {{$group1->LName}}</td>
                
                <?php 
                    $doctors = DB::table('patient')
                        ->join('accounts', 'accounts.ID', '=', 'patient.doctorID')
                        ->get();
                    $doctors = json_decode(json_encode($doctors), true);
                    echo '<td>'.$doctors[0]['FName'].' '.$doctors[0]['LName'].'</td>';


                    if ($group1->morningMed == 1) {
                        echo '<td><input name="checkbox-1" type="checkbox" disabled checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-1" type="checkbox" disabled  /></td>';
                    }
                
                    if($group1->groupID == 1){
                        $curRosterG1 = DB::table('roster')
                            ->join('accounts', 'accounts.ID', '=', 'roster.group1')
                            ->where('date', '=', date('Y-m-d'))
                            ->get();
                            $curRosterG1 = json_decode(json_encode($curRosterG1), true);
                          
                        echo '<td>'.$curRosterG1[0]['FName'].' '.$curRosterG1[0]['LName'].'</td>';
                    }
                    if($group1->groupID == 2){
                        $curRosterG2 = DB::table('roster')
                            ->join('accounts', 'accounts.ID', '=', 'roster.group2')
                            ->where('date', '=', date('Y-m-d'))
                            ->get();
                        $curRosterG2 = json_decode(json_encode($curRosterG2), true);
                          
                        echo '<td>'.$curRosterG2[0]['FName'].' '.$curRosterG2[0]['LName'].'</td>';
                    }
                    if($group1->groupID == 3){
                        $curRosterG3 = DB::table('roster')
                            ->join('accounts', 'accounts.ID', '=', 'roster.group3')
                            ->where('date', '=', date('Y-m-d'))
                            ->get();
                        $curRosterG3 = json_decode(json_encode($curRosterG3), true);
                          
                        echo '<td>'.$curRosterG3[0]['FName'].' '.$curRosterG3[0]['LName'].'</td>';
                    }
                    if($group1->groupID == 4){
                        $curRosterG4 = DB::table('roster')
                            ->join('accounts', 'accounts.ID', '=', 'roster.group4')
                            ->where('date', '=', date('Y-m-d'))
                            ->get();
                        $curRosterG4 = json_decode(json_encode($curRosterG4), true);
                          
                        echo '<td>'.$curRosterG4[0]['FName'].' '.$curRosterG4[0]['LName'].'</td>';
                    }

                    if ($group1->morningMed == 1) {
                        echo '<td><input name="checkbox-1" type="checkbox" disabled checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-1" type="checkbox" disabled /></td>';
                    }
                    if ($group1->afternoonMed == 1) {
                        echo '<td><input name="checkbox-2" type="checkbox" disabled checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-2" type="checkbox" disabled /></td>';
                    }
                    if ($group1->nightMed == 1) {
                        echo '<td><input name="checkbox-3" type="checkbox" disabled checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-3" type="checkbox" disabled  /></td>';
                    }
                    if ($group1->breakfast == 1) {
                        echo '<td><input name="checkbox-4" type="checkbox" disabled checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-4" type="checkbox" disabled /></td>';
                    }
                    if ($group1->lunch == 1) {
                        echo '<td><input name="checkbox-5" type="checkbox" disabled checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-5" type="checkbox" disabled /></td>';
                    }
                    if ($group1->dinner == 1) {
                        echo '<td><input name="checkbox-6" type="checkbox" disabled checked /></td>';
                    }
                    else {
                        echo '<td><input name="checkbox-6" type="checkbox" disabled /></td>';
                    }
                    
                    ?>       
            </tr>
            @endforeach
        </table>
    </section>
    <div>
        <form action="goBack" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="submit" value="Homepage">
        </form>
    </div>
</body>
</html>
