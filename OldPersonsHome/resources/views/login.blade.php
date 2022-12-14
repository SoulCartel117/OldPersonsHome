<!DOCTYPE html>
<html>
    <style>
*{
    margin: none;
    padding: none;
    box-sizing: border-box;
}
.header{
    width: 100%;
    height: 150px;
    border: 2px solid #2196F3;
}
.footer{
    width: 100%;
    height: 150px;
}
.main{
    height: 650px;
    width: 100%;
    display: flex;
    justify-content: center;
}
.flex-container {
  display: flex;
  text-align: center;
}

.flex-container > div {
  background-color: #f1f1f1;
  margin: auto;
  padding: 20px;
  font-size: 25px;
  width: 45%;
}

.flex-containerbtn {
  display: flex;
  text-align: center;
}

.flex-containerbtn > div {
  background-color: #f1f1f1;
  margin: 65px;
  padding: 20px;
  font-size: 25px;
  width: auto;
}

a {
  padding: 0%;
  background-color: #2196F3;
  border: black 2px;
}

.flex-containerbtn > a {
  background-color: #f1f1f1;
  margin: 65px;
  padding: 20px;
  font-size: 25px;
  width: auto;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  font-size: 25px;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #2196F3;
  cursor: pointer;
}

.cancelbtn:hover {
  opacity: 0.5;
}

h1{
    text-align: center;
    font-size: 50px;
}
.error {
  display: flex;
  justify-content: center;
}

</style>
<head>
<link rel="stylesheet" href="stylesheet.css">
        <header class="header">
            <h1>Old Persons' Home</h1>
        </header>
    </head>
    <body>
        <div class="main">
            <div>
            <h1>Login Page</h1>
            <p class="error"> {{ $loginError }} </p>
            <br>
            <form action="/login" method="POST">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="flex-container">
                    <div>Email</div>
                    <div><input type="text" name="email" placeholder="Enter Email"></div>
                </div>
                <br>
                <div class="flex-container">
                    <div>Password</div>
                    <div><input type="password" name="password" placeholder="Enter Password"></div>
                </div>
                <br>
                <div class="flex-containerbtn">
                    <div>
                      <a class="cancelbtn" style="border: 2px solid black;" href="/registration">Register</a>
                    </div>
                    <div>
                      <input type="submit" value="Login" class="cancelbtn" name="Login">
                    </div>
                </div>
            </form>
            </div>
        </div>
        <footer class="footer">

            </footer>
        </body>
        </html>