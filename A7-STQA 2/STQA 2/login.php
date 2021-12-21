<?php
  session_start();
  require_once "pdo.php";
  if(isset($_SESSION["uname"]))
	{
    unset($_SESSION["uname"]);
  }
  if(isset($_SESSION["id_cust"]))
	{
    unset($_SESSION["id_cust"]);
  }
  if(isset($_POST["LoginButton"]))
	{	
		if(isset($_POST["loginID"]) && isset($_POST["password"]))
		{
			if( $_POST["loginID"] == "" || $_POST["password"] == "")
			{	
        $_SESSION["error"] = 'Both fields are mandatory!';
      }
      else if(is_numeric($_POST["loginID"])&&strlen($_POST["loginID"])!=10)
      {
        $_SESSION["error"] = 'Please enter valid phone number.';
      }
      else
      {
        $stmt = $pdo->prepare('select cust_id, name, pass from customer where email = :id');
        if(is_numeric($_POST["loginID"]))
			  {
          $stmt = $pdo->prepare('select cust_id, name, pass from customer where phoneno = :id');
        }
        $stmt->execute(array( ':id' => $_POST['loginID']));
        if($user = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          if($user['pass'] == $_POST["password"])
          {
            $_SESSION['id_cust'] = $user['cust_id'];
            $_SESSION['uname'] = $user['name'];
            header("Location: products.php");
		        return;
          }
          else{
            $_SESSION["error"] = 'Incorrect password.';
          }
        }
        else if(is_numeric($_POST["loginID"]))
        {
          $_SESSION["error"] = 'Please enter valid phone number.';
        }
        else{
          $_SESSION["error"] = 'Please enter valid email id.';
        }
      }
    }
    else
    {
      $_SESSION["error"] = 'Both fields are mandatory!';
    }
    header("Location: login.php");
    return;
	}
?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css"> </link>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</head>
<body>
    <header>
    <nav class="navbar navbar-light" >
    <a class="navbar-brand" href="index.php">
      <img src="logo.PNG" id="logo" alt="Home" loading="lazy">
    </a>

    <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
      </ul>
    </nav>
    </header>

    <div id="loginDiv" >
    <div id='formLogin' style ="height: fit-content;">
        <span id='loginSpan'>Log In</span>
        <?php
          if ( isset($_SESSION['error']) ) {
            echo('<div class="alert alert-danger" id="errorDiv" role="alert" style="display: block;  width: 60%; margin: 0px auto 0px auto;">');
            echo(htmlentities($_SESSION['error'])."&#128533;</p></div>\n");
            unset($_SESSION['error']);
          }
          if ( isset($_SESSION['success']) ) {
            echo('<div class="alert alert-success" id="successDiv" role="alert" style="display: block;  width: 60%; margin: 0px auto 0px auto;">');
            echo(htmlentities($_SESSION['success'])."&#128516;</p></div>\n");
            unset($_SESSION['success']);
          }
        ?>
        <form id='loginFormText' name ='loginFormValid' style="margin-top:10px" onsubmit="return validate()" method="POST" >
          <div class="input-group mb-3" style="padding-left: 10%; padding-right: 10%;">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Email ID/Ph. No. </span>
            </div>
            <input type="text" class="form-control" id="loginID" name="loginID"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
          </div>

          <div class="input-group mb-3" style="padding-left: 10%; padding-right: 10%;">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Password </span>
            </div>
            <input type="password" class="form-control" id="password" name="password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
          </div>
          <button type="submit" class="btn btn-success" id="LoginButton" name = "LoginButton" value= "Login">Login</button>
          <button type="reset" class="btn btn-secondary" id="ClearButton">Clear</button>
          <div style="margin-top: 20px;">
          <span>Don't have an account? </span>
          <a href="register.php" id="linkRegister">Register</a>
          </div>
        </form>
    </div>
    </div>
    <script lang="JavaScript" src="login.js"></script>
      
</body>
</html>