<!DOCTYPE html>
    <html>
        <head>
            {{-- <link rel="stylesheet" href="RegStyleSheet.css"> --}}
            <link rel="stylesheet" href="{{ asset('RegStyleSheet.css') }}">
            <header class="header">

            </header>
        </head>
        <body>
            <div class="main">
                <div class="mainFlex">
                    <div class="leftFlex">
                        <form action="/registration" method="post">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="infoBoxes">
                            <p style="width: 100px;">Role:</p>
                            <select name="role" id="role" style="width: 100px;">
                                <option value="1">Admin</option>
                                <option value="2">Supervisor</option>
                                <option value="3">Doctor</option>
                                <option value="4">Caregiver</option>
                                <option value="5">Patient</option>
                                <option value="6">Family</option>
                            </select>
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">First name</p>
                                <input name="fname" id="fname" type="text">
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">Last name</p>
                                <input name="lname" id="lname" type="text">
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">Email</p>
                                <input name="email" id="email" type="email">
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">Phone</p>
                                <input name="phone" id="phone" type="text">
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">Password</p>
                                <input name="password" id="password" type="text">
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">Date of Birth</p>
                                <input name="DOB" id="DOB" type="date">
                            </div>
                            <div class="infoBoxes">
                                <input type="submit" value="submit">
                            </div>
                        
                    </div>
                    <div class="rightFlex">
                        
                            <div class="infoBoxes">
                                <p style="width: 100px;">Family Code</p>
                                <input type="number" name="familyCode">
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">Emergency Contact Name</p>
                                <input type="text" name="familyName">
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">Relation to Emergency Contact</p>
                                <input type="text" name="familyRelation">
                            </div>
                            <div class="infoBoxes">
                                <p style="width: 100px;">Emergency Contact Phone</p>
                                <input type="number" name="familyPhone">
                            </div>
                            
                        </form>
                        
                    </div>
                </div>
                


            </div>
            <div>
                <script>
                    function goBack() {
                      window.history.back();
                    }
                    </script>
                <button onclick="goBack()">Go Back</button>
            </div>
            <footer class="footer">

            </footer>
        </body>
    </html>