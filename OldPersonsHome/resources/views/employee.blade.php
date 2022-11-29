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
    <p> <h1>Employee</h1> </p>

<section class="search">
    <form class="example" action="action_page.php">
        <input type="text" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search">Search</i></button>
    </form>
</section><br>

    <section class="top">
        <table class="employeeInfo">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Salary</th>
            </tr>
            <tr>
                <td>something</td>
                <td>will</td>
                <td>go</td>
                <td>here</td>
            </tr>
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
</body>
</html>
