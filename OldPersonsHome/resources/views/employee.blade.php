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
        <form class="example" action="/employeeSearch" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <select class="searchBar" name="searchID" id="searchID">
                <option value="" disabled selected>Select an ID</option>
                @foreach ($EmpIDs as $empID)
                    <option value="{{ $empID->ID }}"> {{ $empID->ID}}</option>
                @endforeach
            </select>

            <select class="searchBar" name="searchName" id="searchName">
                <option value="" disabled selected>Select a Name</option>
                @foreach ($EmpsNames as $empName)
                    <option value="{{ $empName->LName }}">{{ $empName->FName }} {{ $empName->LName }}</option>
                @endforeach
            </select>

            <select class="searchBar" name="searchRole" id="searchRole">
                <option value="" disabled selected>Select a Role</option>
                @foreach ($RoleIDs as $role)
                    <option value="{{ $role->roleID }}"> {{ $role->role }}</option>
                @endforeach
            </select>
        
           <select class="searchBar" name="searchSalary" id="searchSalary">
                <option value="" disabled selected>Select a Salary</option>
                @foreach ($EmpSalaries as $salary)
                    <option value="{{ $salary->salary }}"> {{ $salary->salary }}</option>
                @endforeach
            </select>

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
                <form action="/employee" method="post">
                    <label for="eid">Emp ID</label>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <select class="mainDivinput" name="SalaryID">
                        <option value="" disabled selected>Select a ID</option>
                        @foreach ($EmpsNoSalary as $empsNoSalary)
                            <option value="{{ $empsNoSalary->ID }}"> {{ $empsNoSalary->ID}}</option>
                        @endforeach
                    </select>
                    <br><br>

                    <label for="sid">New Salary</label>
                    <input class="mainDivinput" type="text" id="sid" name="sid"><br><br>

                    <div class="buttonDiv">
                        <input type="submit" value="Submit">
                        <input type="submit" value="Cancel">
                    </div>
                </form>
            </div>
        </div>
    </section>
    
    
    <div>
        <form action="goBack" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="submit" value="Homepage">
        </form>
    </div>
</body>
</html>
