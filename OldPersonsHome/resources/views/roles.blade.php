<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="rolesStylesheet.css">
            <header class="header" style="display: flex; justify-content:center;">
                <h1>Roles</h1>
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
                <div style="margin-top:20px;" class="roleButtonsDiv">
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
                <div style="margin-top: 20px;">
                    <div class="roleButtons" style="margin-top: 30px;">
                        <label style="margin-top:15px;">RoleID: </label>
                        <input name="roleID" style="width:125px; margin-left:6px; margin-top:15px;" >
                    </div>
                    <div class="roleButtons">
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
                </form>
                </div>   
                
            </div>
            <br>
            <br>
            <div>
                <form action="goBack" method="post">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="submit" value="Homepage">
                </form>
            </div>
        </body>
    </html>