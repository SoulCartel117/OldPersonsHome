<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('employee.css') }}">
    <title>Employee</title>
</head>
<body>
    <p> <h1 class="title">Employee</h1> </p>

    <section class="search">
        <form class="example" action="employee" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input class="searchBar" type="text" placeholder="Search ID.." name="searchID">
             
            <input class="searchBar" type="text" placeholder="Search Last Name.." name="searchName">  
       
            <input class="searchBar" type="text" placeholder="Search Role.." name="searchRole">
        
            <input class="searchBar" type="text" placeholder="Search Salary" name="searchSalary"><br><br>
       
            <button class="searchSubmit" type="submit"><i class="fa fa-search">Search</i></button>
        </form>
    </section><br>

    <section class="top">
        <table class="employeeInfo">
            <tr>
                <th style="width: 150px;">ID</th>
                <th style="width: 150px;">Name</th>
                <th style="width: 150px;">Role</th>
                <th style="width: 150px;">Salary</th>
            </tr>
            
            @foreach ($Emps as $emp)
            <tr>
                <td class="dataRows">{{ $emp->ID }}</td>
                <td class="dataRows">{{ $emp->FName }} {{ $emp->LName }}</td>
                <td class="dataRows">{{ $emp->role}}</td>
                <td class="dataRows">{{ $emp->salary }}</td>
            </tr>
            @endforeach
            
        </table>
    
        <div class="mainDiv">
            <div class="leftDiv">
                <form action="">
                    <label for="eid">Emp ID</label>
                    <input type="text" id="eid" name="eid"><br><br>

                    <label for="sid">New Salary</label>
                    <input type="text" id="sid" name="sid"><br><br>
                </form>
            </div>
        </div>
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
