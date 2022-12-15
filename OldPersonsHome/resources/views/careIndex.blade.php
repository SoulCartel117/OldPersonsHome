<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="careIndex.css">
        <header class="header">
            <h1>Caregiver's Page</h1>
        </header>
    </head>
    <body>
        <div class="main">
            <div>
            <br>
            <form action="" method="POST">
    
                <div class="flex-container">
                    <div><a href="/caregiverHome">Caregiver's Home</a></div>
                    <div><a href="/roster">Roster</a></div>
                    <div><a href="/patients">All Patients</a></div>
                </div>
                <br>
            </form>
            </div>
        </div>
<div>
        <form action="/login" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="submit" value="LOGOUT">
        </form>
    </div>
        </body>
        </html>