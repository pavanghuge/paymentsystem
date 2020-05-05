<?php

include('connection.php');

//get the user_id
$email = $_SESSION['email'];

//run a query to look for notes corresponding to user_id
$sql = "SELECT * FROM activity WHERE sender_email ='$email' or rec_email = '$email' ORDER BY time DESC";

//shows notes or alert message
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result)){
            $sender_email = $row['sender_email'];
            $rec_email = $row['rec_email'];
            $amount = $row['amount'];
            $note_id = $row['id'];
            $status = $row['Status'];
            $comments = $row['comments'];
            $time = $row['time'];
            $t = time() - strtotime($time);
            if($sender_email==$email && $status != 'Cancel'){
                $message = '$'.$amount.' Sent to '.$rec_email;

                echo "
                <div class='note'>
                    
                    <div class='noteheader' id='$note_id'>
                    <div class='text'>$status</div>
                        <div class='text'>$message</div>
                        <div class='text'>$comments</div>
                        <div class='timetext'>$time</div>    
                        
                    </div>";

                    if($t < 600 ) {
                      
                        echo"<a href='#cancel' data-toggle='modal'> Cancel</a>";


                        echo '<form method="post" id="requestform" action="canceltransaction.php">
                        <div class="modal" id="cancel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button class="close" data-dismiss="modal">
                                    &times;
                                  </button>
                                  <h4 id="myModalLabel">
                                   Cancel Transaction: 
                                  </h4>
                              </div>
                              <div class="modal-body">
                                  
                                 
                                  <div id="sendmessage"></div>
                                  
                                    <input type="hidden" value="'.$rec_email.'" name="takeback">
                                    <input type="hidden" value="'.$note_id.'" name="transc_id">

                                
                                  <div class="form-group">
                                      <label for="amount" class="sr-only">Amount</label>
                                      <input class="form-control" type="number"  value="'.$amount.'"" readonly name="amount" step=0.1 id="amount" placeholder="Amount to Request" maxlength="30">
                                  </div>
                                  <div class="form-group">
                                      <label for="memo" class="sr-only">Cancellation Reason</label>
                                      <input class="form-control" type="text" name="memo" id="memo" placeholder="Reason for cancellation" maxlength="50">
                                  </div>
                                  
                              </div>
                              <div class="modal-footer">
                                  <input class="btn green" name="submit" type="submit" value="Cancel Transaction">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                  Back
                                </button>
                              </div>
                          </div>
                      </div>
                      </div>
                      </form>';




                       
                    }
                    
                echo "</div>";
            }
            elseif ($rec_email==$email && $status == 'Cancel') {

                $message = '$'.$amount.' transfered back from '.$rec_email;
                echo "
                <div class='note'>
                    
                    <div class='noteheader' id='$note_id'>
                    <div class='text'>$status</div>
                        <div class='text'>$message</div>
                        <div class='text'>$comments</div>
                        <div class='timetext'>$time</div>    
                        
                    </div>";

            }
            elseif ($sender_email==$email && $status == 'Cancel') {

                $message = '$'.$amount.' transfered back to '.$rec_email;
                echo "
                <div class='note'>
                    
                    <div class='noteheader' id='$note_id'>
                    <div class='text'>$status</div>
                        <div class='text'>$message</div>
                        <div class='text'>$comments</div>
                        <div class='timetext'>$time</div>    
                        
                    </div>";

            }
            else{
                $message = '$'.$amount.' Received from '.$sender_email;

                echo "
                <div class='note'>
                    
                    <div class='noteheader' id='$note_id'>
                    <div class='text'>$status</div>
                        <div class='text'>$message</div>
                        <div class='text'>$comments</div>
                        <div class='timetext'>$time</div>    
                        
                    </div>
                    
                </div>";
            }
        }
    }else{
        echo '<div class="alert alert-warning">No Transactions yet!!</div>';
    }
    
}else{
    echo '<div class="alert alert-warning">An error occured!</div>';
//    echo "ERROR: Unable to excecute: $sql." . mysqli_error($link);
}

?>

