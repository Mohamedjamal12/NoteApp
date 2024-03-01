<!DOCTYPE html>
<html>
<head>
    <title>Login page</title>
	 <style>
       .action-buttons {
            position: absolute;
            top: 5px;
            right: 5px;
        }
		button {
         padding: 8px 16px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 4px; 
  cursor: pointer;
  transition: background-color 0.3s ease; 
}
	</style>
</head>
<body style="background-color:#D2B9D3">

   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
    <center>
            <p>Login</p>

         <form action="./login process.php" method="POST">

                   <input type="text" id="username" name="username" placeholder="username"/><br><br>
                   <input type="Password" id="pass" name="password" placeholder="password"/><br><br>
                   <button type="submit" id="btn" name="login" default>login</button>
                   
         </form>

    </center>

</body>
</html>