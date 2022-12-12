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
        <form class="example" action="/patients" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <select class="searchBar" name="searchID" id="searchID">
                <option value="" disabled selected>Search by ID</option>
                @foreach ($allPatients as $ap)
                <option value="{{ $ap['patientID'] }}">{{ $ap['patientID'] }}</option>
                @endforeach
            </select>
            <input type="submit">
        </form>

        <form class="example" action="/patients" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <select class="searchBar" name="searchFName" id="searchName">
                <option value="" disabled selected>Search by first name</option>
                <?php
                $arr = array();
                foreach ($allPatients as $ap){
                    $arr[] = $ap['FName'];
                }
                $unique = array_unique($arr);
                
                foreach($unique as $u){
                    echo "<option value='". $u ."'>". $u ."</option>";
                }
                ?>
            </select>
            <input type="submit">
        </form>

        <form class="example" action="/patients" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <select class="searchBar" name="searchLName" id="searchName">
                <option value="" disabled selected>Search by last name</option>
                <?php
                $arr = array();
                foreach ($allPatients as $ap){
                    $arr[] = $ap['LName'];
                }
                $unique = array_unique($arr);
                
                foreach($unique as $u){
                    echo "<option value='". $u ."'>". $u ."</option>";
                }
                ?>
            </select>
            <input type="submit">
        </form>

        <form class="example" action="/patients" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <select class="searchBar" name="searchDOB" id="searchAge">
                <option value="" disabled selected>Search by DOB</option>
                <?php
                $arr = array();
                foreach ($allPatients as $ap){
                    $arr[] = $ap['DOB'];
                }
                $unique = array_unique($arr);
                
                foreach($unique as $u){
                    echo "<option value='". $u ."'>". date("m/d/Y", strtotime($u)) ."</option>";
                }
                ?>
            </select>
            <input type="submit">
        </form>

        <form class="example" action="/patients" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <select class="searchBar" name="searchREC" id="searchEmCont">
                <option value="" disabled selected>Search by Emergency Contact</option>
                <?php
                $arr = array();
                foreach ($allPatients as $ap){
                    $arr[] = $ap['relationEmContact'];
                }
                $unique = array_unique($arr);
                
                foreach($unique as $u){
                    echo "<option value='". $u ."'>". $u ."</option>";
                }
                ?>
            </select>
            <input type="submit">
        </form>

        <form class="example" action="/patients" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <select class="searchBar" name="searchEC" id="searchEmContName">
                <option value="" disabled selected>Search by Emergency Contact Name</option>
                <?php
                $arr = array();
                foreach ($allPatients as $ap){
                    $arr[] = $ap['emContact'];
                }
                $unique = array_unique($arr);
                
                foreach($unique as $u){
                    echo "<option value='". $u ."'>". $u ."</option>";
                }
                ?>
            </select>
            <input type="submit">
        </form>

        <form class="example" action="/patients" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <select class="searchBar" name="searchAD" id="searchAdmission">
                <option value="" disabled selected>Search by admission date</option>
                <?php
                $arr = array();
                foreach ($allPatients as $ap){
                    $arr[] = $ap['admissionDate'];
                }
                $unique = array_unique($arr);
                
                foreach($unique as $u){
                    echo "<option value='". $u ."'>". date("m/d/Y", strtotime($u)) ."</option>";
                }
                ?>
            </select>
            <input type="submit">
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
            @foreach ($allPatients as $x)
            <tr>
                <td><?php echo $x['patientID'] ?></td>
                <td><?php echo $x['FName']." ".$x['LName'] ?></td>
                <td><?php echo date_diff(date_create($x['DOB']), date_create('now'))->y; ?></td>
                <td><?php echo $x['relationEmContact'] ?></td>
                <td><?php echo $x['emContact'] ?></td>
                <td><?php echo date("m/d/Y", strtotime($x['admissionDate'])) ?></td>
            </tr>
            @endforeach
        </table>

    </section>

    <div class="buttonDiv">
        <form class="example" action="/patients" method="get">
            <input type="submit" value="Clear">
        </form>
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
