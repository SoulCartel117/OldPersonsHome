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
                <div class="mainInside">
                    <div class="nameRow">Name</div>
                    <div class="roleRow">Role</div>
                </div>
                <form class="checkBox">
                    <input type="radio" id="1" name="option" value="Yes">
                    <label class="yesCheck" for="1">Yes</label>
                    <input type="radio" id="2" name="option" value="No">
                    <label class="noCheck" for="2">No</label>
                </form>
                <form class="submitB">
                    <input class="okSubmit" type="submit" id="11" name="ok" value="OK">
                    <input class="cancelSubmit" type="submit" id="12" name="cancel" value="Cancel">
                </form>
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