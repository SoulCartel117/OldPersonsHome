<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheet.css">
<link rel="stylesheet" href="patientIndex.css">
        <header class="header">
            <h1>Family Member's Page</h1>
        </header>
    </head>
    <body>
        <div class="main">
            <div>
            <br>
            <form action="" method="GET">
    
                <div class="flex-container">
                    <div><a href="/familyMemberHome">Family Member's Home</a></div>
                    <div><a href="/roster">Roster</a></div>
                </div>
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