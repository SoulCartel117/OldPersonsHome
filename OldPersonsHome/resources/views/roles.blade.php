<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="rolesStylesheet.css">
            <header class="header">

            </header>
            <br>
        </head>
        <body>
            <div class="main">
                <div class="roles">
                    <table>
                        <tr>
                            <th>Roles</th>
                            <th>Access Level</th>
                        </tr>
                        @foreach ($levels as $level)
                        <tr>
                            <td class="tableAccessLevel" >{{ $level->role }}</td>
                            <td class="tableAccessLevel" >{{ $level->level }}</td>
                        </tr>
                        @endforeach
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
                        <form action="/roles" method="post">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        {{--<label for="roles">Choose a Role:</label>
                         
                            <select  name="roleID" style="width:125px">
                                <option value=""disabled selected>Select a Role:</option>
                                @foreach ($rolesDropdown as $roles)
                                <option value={{ $roles->roleID }}>{{ $roles->role }}</option>
                                @endforeach
                            </select>
                            
                    </div>
                    <div class="roleButtons">
                        <label style="margin-top:15px;">Access Level: </label>
                        <input name="level" style="width:125px; margin-left:6px; margin-top:15px;" >
                    </div>
                </div>
                <div class="roleButtonsDiv">
                    <div class="roleButtons2">
                        <input type="submit" value="Submit">
                    </div> --}}
                    <br>
                    <div class="roleButtons">
                        <label style="margin-top:15px;">RoleID: </label>
                        <input name="roleID" style="width:125px; margin-left:6px; margin-top:15px;" >
                    </div>
                        <div>
                        <label style="margin-top:15px;">New Role: </label>
                        <input name="newRole" style="width:125px; margin-left:6px; margin-top:15px;" >
                    </div>
                    <div class="roleButtons">
                        <label style="margin-top:15px;">Access Level: </label>
                        <input name="level" style="width:125px; margin-left:6px; margin-top:15px;" >
                    </div>
                    {{-- <div class="roleButtons2">
                        <button class="buttonStyle" style="margin-top:10px;" >Cancel?</button>
                    </div> --}}
                    <div class="roleButtons2">
                        <input type="submit" value="Submit">
                    </div>
                </div>
            </form>
                {{-- <div>
                    <script>
                        function goBack() {
                          window.history.back();
                        }
                        </script>
                    <button onclick="goBack()">Go Back</button>
                </div> --}}
            </div>
            <br>
            <br>
            <footer class="footer">

            </footer>
        </body>
    </html>