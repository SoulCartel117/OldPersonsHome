<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="rolesStylesheet.css">
            <header class="header">

            </header>
        </head>
        <body>
            <div class="main">
                <div class="roles">
                    <table>
                        <tr>
                            <th>Roles</th>
                            <th>Access Level</th>
                        </tr>
                        <tr>
                            <td class="tableAccessLevel" >Doctor</td>
                            <td class="tableAccessLevel" >1</td>
                        </tr>
                        <tr>
                            <td class="tableAccessLevel" >Caregiver</td>
                            <td class="tableAccessLevel" >2</td>
                        </tr>
                    </table>
                </div>
                <div class="roleButtonsDiv">
                    <!-- <button class="roleButtons">
                        Role
                    </button>
                    <button class="roleButtons">
                        Access Level
                    </button> -->
                    <div class="roleButtons">
                        <label for="rolesID">Choose a Role:</label>
                            <select id="rolesID" name="rolesID" style="width:125px">
                                <option value="volvo">Doctor</option>
                                <option value="saab">Caregiver</option>
                                <option value="fiat">Supervisor</option>
                                <option value="audi">Admin</option>
                                <option value="audi">Patient</option>
                                <option value="audi">Family Member</option>
                            </select>
                    </div>
                    <div class="roleButtons">
                        <label style="margin-top:15px;">Access Level: </label>
                        <input id="accessID" style="width:125px; margin-left:6px; margin-top:15px;" >
                    </div>
                </div>
                <div class="roleButtonsDiv">
                    <div class="roleButtons2">
                        <button class="buttonStyle">Ok</button>
                    </div>
                    <div class="roleButtons2">
                        <button class="buttonStyle" style="margin-top:10px;" >Cancel?</button>
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
            </div>
            <footer class="footer">

            </footer>
        </body>
    </html>