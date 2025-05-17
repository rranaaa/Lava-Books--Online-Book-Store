<?php
session_start();

//check customer logged in, if not redirect to sign-in page
if (!isset($_SESSION['User_Fname']) || !isset($_SESSION['User_Lname'])) {
  header("Location:sign-in.php");
  exit();
}

//get user data from the session
$firstName = $_SESSION['User_Fname'];
$lastName = $_SESSION['User_Lname'];
$email = $_SESSION['User_Email'];
$gender = $_SESSION['User_Gender'];
$phone = $_SESSION['User_Phone_number'];
$address = $_SESSION['User_Address'];
$dob = $_SESSION['User_DOB'];
$password = $_SESSION['User_Password'];

    $severname = "localhost";
    $username = "root";
    $password = "";
    $db = "booklr";

    //create new connection
    $con= new mysqli($severname, $username, $password, $db);

    //check connection
    if($con->connect_error){
        die("Connection failed : ".$con->connect_error);

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="styles/my-account-styles.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Account</title>

  <!--Custom CSS-->
  <link rel="stylesheet" href="Cascade Sheets/hf.css">
  <link rel="stylesheet" href="Cascade Sheets/my-account-styles.css">
</head>


<body>
  <?php include "./header.php"?>

<section style="background-color: #0000;">
  <div class="container">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="rounded-3 mb-4">
          <ol class="breadcrumb mb-0">
            <p><a href="index.php" class="btn btn-danger">Home</a></p>
            <p><a href="logout.php" class="btn btn-danger">Logout</a></p>

          </ol>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <h5 class="my-3"><?php echo $firstName.' '.$lastName; ?></h5>
            <p class="text-muted mb-1"><?php echo $gender; ?></p>
            <p class="text-muted mb-4"><?php echo $address; ?></p>
          </div>
        </div>

      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $firstName.' '.$lastName; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $email; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $phone; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Date of Birth</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $dob; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Address</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $address; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
<?php include "./footer.php"?>
</html>
