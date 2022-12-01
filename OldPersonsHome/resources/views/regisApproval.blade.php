<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="regisApproval.css">
            <title>Registration Approval</title>
            <header class="header">
                <h1 class="title">Registration Approval</h1>
            </header>
        </head>
        <body>
            <div class="main">
                
                <div class="patientInfo">
                    <table>
                        <tr>
                            <th class="nameRow">Name</th>
                            <th class="roleRow">Role</th>
                        </tr>
                        <tr>
                            <?php 
                        for ($x=0; $x < count($users); $x++){
                            echo " <td> <p class='nameName'>".$users[$x]["FName"]."</p> </td>";
                            echo "<td ><p class='roleRole'>".$users[$x]["role"]."</p> </td>";
                            echo "<td><form class='checkBox'>
                                <input type='hidden' name='_token' value='<?php echo csrf_token(); ?>'>
                                <input type='radio' id='1' name='option' value='Yes'>
                                <label class='yesCheck' for='1'>Yes</label>
                                <input type='radio' id='2' name='option' value='No'>
                                <label class='noCheck' for='2'>No</label>
                            </form> </td>";
                        } 
                    ?>
                        </tr>
                    </table>
                    
                </div>

                
                <form class="submitB">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input class="okSubmit" type="submit" id="11" name="ok" value="OK">
                    <input class="cancelSubmit" type="submit" id="12" name="cancel" value="Cancel">
                </form>
            </div>
            <footer class="footer">

            </footer>
        </body>
    </html>