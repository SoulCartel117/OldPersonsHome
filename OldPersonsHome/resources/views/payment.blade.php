<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('payment.css') }}">
    <title>Payment</title>
</head>
<body>
    <p> <h1>Payment</h1> </p>

    <div class="mainDiv">
        <div class="leftDiv">
            <form action="">
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid"><br><br>

                <label for="">Total Due</label>
                <input type="" id="" name=""><br><br>

                <label for="did">New Payment</label>
                <input type="" id="" name=""><br><br>

                <div class="buttonDiv">
                    <input type="submit" value="Okay">
                    <input type="submit" value="Cancel">
                </div><br>
            </form>
        </div>
    </div>

    <div class="buttonDiv">
        <input type="submit" value="Update">
    </div>
    <br>
    <div>
        <form action="goBack" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="submit" value="Homepage">
        </form>
    </div>
</body>
</html>
