<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
.candidate_photo{
    width: 80px;
    height: 80px;
    border: 2px solid aquamarine;
    border-radius: 100%;
}
    </style>
</head>
<body>
  
</body>
</html>
<?php
$election_id=$_GET['viewResults'];
?>

<div class="row my-3">
    <div class="col-12">
        <h3>Election Results</h3>
        <?php
       $fetchingActiveElections=mysqli_query($db,"SELECT * FROM elections WHERE id='".$election_id."'") or die(mysqli_error($db));
       $totalActiveElections=mysqli_num_rows($fetchingActiveElections);
      if($totalActiveElections>0){
        while($data=mysqli_fetch_assoc($fetchingActiveElections)){
            $election_id=$data['id'];
            $election_topic=$data['election_topic'];
            ?>
                <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4" class="bg-primary text-white"><h5>ELECTION TOPIC:<?php
                                    echo strtoupper($election_topic); ?></h5></th>
                                </tr>
                                <tr>
                                    <th>Photo</th>
                                    <th>Candidate Details</th>
                                    <th> Number of Votes</th>
                                   <!-- <th>Action</th>-->
                                </tr>
                            </thead>
                        <tbody>
                            <?php
                              $fetchingCandidates=mysqli_query($db,"SELECT * FROM candidate_details WHERE
                              election_id='".$election_id."'") or die(mysqli_error($db));
                              while($candidateData=mysqli_fetch_assoc($fetchingCandidates)){
                                $candidate_id=$candidateData['id'];
                                $candidate_photo=$candidateData['candidate_photo'];
                                //fetching candidate votes
                                $fetchingVotes=mysqli_query($db, "SELECT * FROM votings WHERE candidate_id='".$candidate_id."'") or die(mysqli_error($db));
                                $totalVotes=mysqli_num_rows($fetchingVotes);
                                  

                                
                                ?>
                                <tr>
                                    <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo"></td>
                                    <td> <?php echo "<b>". $candidateData['candidate_name'] ."</b><br>" . 
                                   $candidateData['candidate_details'];?></td>
                                    <td><?php echo $totalVotes; ?></td>
                                    
                                </tr>
                                <?php
                              }
                            ?>
                        </tbody>
                        </table>
            <?php
        }
       
        ?>
      
        <?php

      }else{
        echo"No active elections";
      }
       ?>
        

        <hr>
        <h3>Voting Details</h3>
         

            <?php
             $fetchingVoteDetails=mysqli_query($db,"SELECT * FROM votings WHERE election_id='".
             $election_id."'");
             $number_of_votes=mysqli_num_rows($fetchingVoteDetails);
             if($number_of_votes>0)
             {
                $sno=1;
                ?>
                 <table class="table">
            <tr>
               <th>S.no</th>
               <th>Voters Name</th>
               <th>Contact No</th>
               <th>Voted to</th>
               <th>Date</th>
               <th>Time</th>
            </tr>


              <?php
               while($data=mysqli_fetch_assoc($fetchingVoteDetails)){

                $voters_id=$data['voters_id'];
                $candidate_id=$data['candidate_id'];
                $fetchingUserName=mysqli_query($db,"SELECT * FROM users WHERE id='".$voters_id."' ")
                or die(mysqli_error($db));
                $isDataAvailable=mysqli_num_rows($fetchingUserName);
                $userData=mysqli_fetch_assoc($fetchingUserName);
                if($isDataAvailable>0){
                 
                 $userName=$userData['username'];
                 $contact_no=$userData['contact_no'];

                  
                }else{
                    $userName="No_data";
                    $contact_no=$userData['contact_no'];
                }

                $fetchingCandidateName=mysqli_query($db,"SELECT * FROM candidate_details WHERE id='".$candidate_id."' ")
                or die(mysqli_error($db));
                $isDataAvailable=mysqli_num_rows($fetchingCandidateName);
                $candidateData=mysqli_fetch_assoc($fetchingCandidateName);
                if($isDataAvailable>0){
                 
                 $candidate_name=$candidateData['candidate_name'];
                 
                }else{
                    $candidate_name="No_data";
        
                }
                ?>
                    <tr>
                        <td><?php echo $sno++;  ?></td>
                        <td><?php echo $userName;  ?></td>
                        <td><?php echo $contact_no;  ?></td>
                        <td><?php echo $candidate_name;  ?></td>
                        <td><?php echo $data['vote_date']  ?></td>
                        <td><?php echo $data['vote_time']  ?></td>
                    </tr>
                <?php
               }
               echo "</table>";
             }else{

                echo "Vote details not available";
             }
             ?>
           
    </div>
 </div>
