<?php

require_once("required/apicall.php");

$username = $_GET['c'] or header("LOCATION: index.php");

$get_data = GetDataFromAPI('GET', "https://grahakplus.com/api/provider.php?username=$username", false);
$response = json_decode($get_data, true);
$errors = $response['success'];
$providerinfo = $response['response'];

$error = array();
$msg = "";
$msgtype = "";
	
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$fname = $_POST['fname'] or $error[] = "First name should not be empty.";
	$lname = $_POST['lname'] or $lname = "";
	$email = $_POST['email'] or $error[] = "Email id should not be empty.";
	$mobile = $_POST['mobile'] or $error[] = "Mobile number should not be empty.";
	$dob = $_POST['dob'] or $dob = "";
	
	if(!$error){
		$name = $fname." ".$lname;
		$request = "provider=".$username."&uname=".$name."&mob=".$mobile."&mail=".$email."&dob=".$dob;
		
		$get_datax = GetDataFromAPI('POST', "https://grahakplus.com/api/savedetailsfromprovider.php", $request);
		$postdata = json_decode($get_datax, true);
		$errorx = $postdata['success'];
		$savedmsg = $postdata['response'];

		$msgtype = "success";
		$msg = $providerinfo['successtext'];
	}else{
		$msgtype = "danger";
		foreach($error as $e){
			$msg .= $e."<br />";
		}
	}
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register - <?=$providerinfo['companyname'];?></title>

    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/checkout/form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="<?=$providerinfo['logourl'];?>" alt="" height="72">
        <h2>Register for <?=$providerinfo['companyname'];?></h2>
        <p class="lead"><?=$providerinfo['subtext'];?></p>
      </div>

      <div class="row">
        <div class="col-md-12 order-md-1">
		
		<?if($msg){?>
		<div class="alert alert-dismissible alert-<?=$msgtype;?>">
		  <?=$msg;?>
		</div>
		<?}?>
		
          <h4 class="mb-3"><?=$providerinfo['regtext'];?></h4>
          <form action="" method="post" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" name="fname" class="form-control" id="firstName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" name="lname" class="form-control" id="lastName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" required>
              <div class="invalid-feedback">
                Please enter a valid email address.
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">Mobile No.</label>
                <input type="text" name="mobile" class="form-control" id="firstName" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid mobile number is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Date of Birth</label>
                <input type="text" name="dob" class="form-control" id="lastName" placeholder="" value="">
              </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Save Details</button>
          </form>
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1"><?=$providerinfo['copyright'];?></p>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
