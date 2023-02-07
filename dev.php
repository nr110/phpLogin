<?php
  function recaptcha():array{
   $n1=mt_rand(1,20);
  $n2=mt_rand(1,20);
  $arr=array(
  'n1'=>$n1,
   'n2'=>$n2,
   'sum'=>$n1+$n2);
  return $arr;
 }
  $recaptchaData=recaptcha();
  $sHash=hash('sha256',strval($recaptchaData['sum']));
  $feedback="";
  $bFormSubmitted=isset($_POST['uname']);
  function validUname(string $uname):bool{
    $uname=trim($uname);
    if(strlen($uname)<5){
      return false;
	}
	else{
    return true;
	}
     
  }
  function validPword(string $pword){
    $pword=trim($pword);
    if(strlen($pword)<5){
      return false;
	}
    $dollarAt=strpos($pword,'$');
    $astAt=strpos($pword,'*');
    if($dollarAt>-1){
        return false;
    }
    if($astAt>-1){
        return false;
    }
	  else{
   return true;
	  }
  }
  function mathCheck($userans):bool{
    if($userans!=$_POST['solution']){
      return false;
	}
	  else{
      return true;
    }
  }
  if($bFormSubmitted===true){
    $uname=trim($_POST['uname']);
    $pword=trim($_POST['pword']);
    $userans=$_POST['useranswer'];
    $uhash=hash('sha256',$_POST['useranswer']);
    $bValidUname=validUname($uname);
    $bValidPWord=validPword($pword);
    $bValidMath=mathCheck($uhash);
    if ($uname===""){
      $feedback.='<li>Please enter a username.';
    }
    else if (false===$bValidUname){
      $feedback .='<li>' . $_POST['uname'] . ' is not a valid username, please enter a valid one.<br>';;}


   
    if ($pword===""){
      $feedback.="<li>Please enter a password.";
    }
    else if (1===$bValidPWord){
      $feedback.='<li> Your password cannot contain a "*".';}
    else if (2===$bValidPWord){
      $feedback.='<li> Your password cannot contain a "$".';}
    else if(3===$bValidPWord){
      $feedback.='<li> Your password must be at least 5 characters.';}


   

    if(strlen((strval($userans)))<1){
      $feedback.='<li>Please answer the captcha.';
    }
    else if(false===$bValidCaptcha){
      $feedback.='<li> Your math is bad. Are you human?';
    }
   
  }
 
 
 if($bFormSubmitted && strlen($feedback)>0){
   echo '<div class="bg-danger text-white pl-2"> Please complete the following: <br> <ul type="circle">';
   echo $feedback;
   echo '</ul></div>';
 }
 else if($bFormSubmitted && strlen($feedback)==0){
   header('Location: dashboard.php');
 }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title></title>

</head>
  <body>
      <div class="container">
 
 
 <h1>Login!</h1>
 <div class="row">
 </div>
 <br>
 <form method="post">
<div class="row col-12">
 
<div class="border col-12">
  <div class="input-group m-3">
<div class="input-group-prepend">
<span class="input-group-text">Username</span>
</div>
<input type="text" class="form-control mr-3" name="uname" id="uname" placeholder="Username">
</div>
<div class="input-group m-3 mt-4">
  <div class="input-group-prepend">
  <span class="input-group-text">Password</span>
  </div>
  <input type="text" class="form-control mr-3" name="pword" id="pword" placeholder="Enter Your password">
</div>

  <div class="input-group m-3 mb-4">
 <div class="input-group-prepend">
 <span class="input-group-text">
 <span id="QButton">
            What is <?php echo $recaptchaData['n1']; ?> + <?php echo $recaptchaData['n2']; ?>              
</span>
   
 </span>
 </div>
 <input type="number" class="form-control mr-3" id="useranswer" name="useranswer" placeholder="Enter Your Answer">
 </div>
</div>
</div>
   
<div class="pl-5 pt-2">
<button type="submit" class="btn bg-primary text-white " id="registerbttn">Submit</button>
  <input type="hidden" name="solution" value="<?php echo $sHash; ?>">
</div>
   
 </form>
 </div>
 
 
 
 <script>
 
 let gDoc=(id)=>{return document.getElementById(id);}
 let loginClicked=(e)=>{
 console.log("loginClicked()");
 gDoc("regform").submit()
 }
 </script>
 
 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 

   
  </body>
</html>
