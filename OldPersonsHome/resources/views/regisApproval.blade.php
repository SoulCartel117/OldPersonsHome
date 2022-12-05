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
                        <div class="nameRow">Name</div>
                        <div class="roleRow">Role</div>
                    <?php 
                        for ($i=0; $i < count($users); $i++){
                            echo "<p class='nameName'>".$users[$i]["FName"]." ".$users[$i]["LName"]."</p>
                                    <p class='roleRole'>".$users[$i]["role"]."</p>
                                    <form class='checkBox' action='/regisApproval/{$users[$i]['ID']}' method='post'>
                                        <input type='hidden' name='_token' value=".csrf_token().">
                                        <input type='radio' id='1' name='option' value='1'>
                                        <label class='yesCheck' for='1'>Yes</label>

                                        <input type='radio' id='2' name='option' value='0'>
                                        <label class='noCheck' for='2'>No</label>

                                        <input class='okSubmit' type='submit' id='11' name='ok' value='OK'>
                                    </form>";      
                        } 
                    ?>         
            
                    
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