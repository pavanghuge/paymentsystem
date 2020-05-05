<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Notes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <style>
        #container{
            margin-top:120px;   
        }

        #notePad, #allNotes, #done, .delete{
            display: none;   
        }

        .buttons{
            margin-bottom: 20px;   
        }

        textarea{
            width: 100%;
            max-width: 100%;
            font-size: 16px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #00cec9;
            color: #00cec9;
            background-color: #00cec9;
            padding: 10px;
              
        }
        
        .noteheader{
            border: 1px solid grey;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 0 10px;
            background: linear-gradient(#FFFFFF,#ECEAE7);
        }
          
        .text{
            font-size: 20px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
          
        .timetext{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .notes{
            margin-bottom: 100px;
        }

      </style>
  </head>
  <body>
    <!--Navigation Bar-->  
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
      
          <div class="container-fluid">
            
              <div class="navbar-header">
              
                  <a class="navbar-brand">Digital Wallet</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  
                  </button>
              </div>
              <div class="navbar-collapse collapse" id="navbarCollapse">
                  <ul class="nav navbar-nav">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="#SendModal" data-toggle="modal">Transfer</a></li>
                    <li><a href="#RequestModal" data-toggle="modal">Request</a></li>
                      <li class="active"><a href="#">Account Activity</a></li>
                      <li ><a href="viewrequests.php">Requests</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="#">Logged in as <b><?php echo $_SESSION['username']?></b></a></li>
                    <li><a href="index.php?logout=1">Log out</a></li>
                  </ul>
              
              </div>
          </div>
      
      </nav>
    
<!--Container-->
      <div class="container" id="container">
          <!--Alert Message-->
          <div id="alert" class="alert alert-danger collapse">
              <a class="close" data-dismiss="alert">
                &times;
              </a>
              <p id="alertContent"></p>
          

          </div>
          <div class="row">
              <div class="col-md-offset-3 col-md-6">
                  <div>
                  <?php
                  include('connection.php');
                  $id = $_SESSION['user_id'];
                  $query = "SELECT balance from users where user_id='$id'";  
                  if($result = mysqli_query($link,$query)) {
                    while($row = mysqli_fetch_array($result)) {
                  ?>
                   <h2 align="center">Your account balance is $<?php echo $row['balance'] ?></h2>
                   <?php
                    }
                  }
                     ?>
                  </div><br>
                  <div id="notes" class="notes">
                      <?php include('loadactivity.php'); ?>
                  </div>
              
              </div>
          </div>
      </div>
      
      <form method="post" id="sendform">
        <div class="modal" id="SendModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Transfer: 
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Login message from PHP file-->
                  <div id="sendmessage"></div>
                  

                  <div class="form-group">
                      <label for="sendemail" class="sr-only">Email:</label>
                      <input class="form-control" type="email" name="sendemail" id="sendemail" placeholder="Receiver's Email" maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="amount" class="sr-only">Amount</label>
                      <input class="form-control" type="number" name="amount" step=0.1 id="amount" placeholder="Amount to Send" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="memo" class="sr-only">Memo</label>
                      <input class="form-control" type="text" name="memo" id="memo" placeholder="What is it for?" maxlength="50">
                  </div>
                  
              </div>
              <div class="modal-footer">
                  <input class="btn green" name="submit" type="submit" value="Send">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
                </button>
              </div>
          </div>
      </div>
      </div>
      </form>




      <form method="post" id="requestform" action="request.php">
        <div class="modal" id="RequestModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Request: 
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Login message from PHP file-->
                  <div id="sendmessage"></div>
                  

                  <div class="form-group">
                      <label for="requestemail" class="sr-only">Email:</label>
                      <input class="form-control" type="email" name="requestemail" id="requestemail" placeholder="Receiver's Email" maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="amount" class="sr-only">Amount</label>
                      <input class="form-control" type="number" name="amount" step=0.1 id="amount" placeholder="Amount to Request" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="memo" class="sr-only">Memo</label>
                      <input class="form-control" type="text" name="memo" id="memo" placeholder="What is it for?" maxlength="50">
                  </div>
                  
              </div>
              <div class="modal-footer">
                  <input class="btn green" name="submit" type="submit" value="Send">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
                </button>
              </div>
          </div>
      </div>
      </div>
      </form>



    <!-- Footer-->
      <div class="footer">
          <div class="container">
              <p>Pavan Ghuge</p>
          </div>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="mypayments.js"></script>  
    <script>
    document.getElementById("cancel");
    </script>
  </body>
</html>