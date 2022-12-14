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
            <form action="/paymentUpdate" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="pid">Patient ID</label>
                <input type="text" id="pid" name="pid"><br><br>
                <div class="buttonDiv">
                    <input type="submit" value="Update">
                </div>
            </form>
            <form action="/paymentPost" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="">Total Due</label>
               
                <p class="updateTotal">${{($runningTotals)}}</p><br><br>
                <input name="amountDue" type="text" value="{{($runningTotals)}}" hidden>
                <input name="pid" type="text" value="{{($PIDs)}}" hidden>
                <label for="did">New Payment</label>
                <input type="number" name="paymentAmount" id="paymentAmount"><br><br>

                <div class="buttonDiv">
                    <input type="submit" value="Okay">
                    <input type="submit" value="Cancel">
                </div><br>
            </form>
        </div>
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
