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
if(isset($_GET['added'])){
    ?>
    <div class="alert alert-success my-3" role="alert">
    Candidate has been added successfully!
  </div>
  <?php
}elseif(isset($_GET['largeFile'])){
  ?>
<div class="alert alert-danger my-3" role="alert">
    Candidate image is too large, please upload small file ...upload files less than 2mb
  </div>
  <?Php
}elseif(isset($_GET['invalidFile'])){
?>
<div class="alert alert-danger my-3" role="alert">
    Only .jpeg .png .jpg files are allowed
  </div>
<?php
}elseif(isset($_GET['failed'])){
?>
  <div class="alert alert-danger my-3" role="alert">
    image uploading failed, please try again
  </div>
<?php
}
?>

<div class="row my-3">
    <div class="col-4">
        <h3>Add New Candidates</h3>

        <form method="POST" enctype="multipart/form-data" >
           <div class="form-group">
           <select class="form-control" name="election_id" required>
            <option value="">Select Election</option>
            <?php
              $fetchingElections=mysqli_query($db, "SELECT * FROM elections") OR die(mysqli_error($db));
              $isAnyElectionAdded=mysqli_num_rows($fetchingElections);
              if($isAnyElectionAdded>0){
                while ($row=mysqli_fetch_assoc($fetchingElections)) {
                    $election_id=$row['id'];
                    $election_name=$row['election_topic'];
                    $allowed_candidates=$row['no_of_candidates'];
                    //Checking how many candidates are added in the election
                    $fetchingCandidate=mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id='".$election_id."'")or die(mysqli_error($db));
                    $added_candidates=mysqli_num_rows($fetchingCandidate);

                    if($added_candidates<$allowed_candidates){

                    
                    ?>
                      <option value="<?php echo $election_id; ?>"> <?php echo $election_name; ?></option>
                    <?php
                           }
              }
           
              }else{
                ?>
                <option value=""> Election is not added yet</option>
                <?php
              }
            ?>
           </select>
           </div>
           <div class="form-group">
            <input type="text" name="candidate_name" placeholder="Candidate Name" class="form-control" required/>
           </div>
           <div class="form-group">
            <input type="file"  name="candidate_photo"  class="form-control" required/>
           </div>
           <div class="form-group">
            <input type="text"  name="candidate_details" placeholder="Candidate Details" class="form-control" required/>
           </div>
            <input type="submit" value="Add Candidate" name="addCandidateBtn" class="btn btn-success">
        </form>
    </div> 
    <div class="col-8">
        <h3>Candidate Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Election</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $fetchingData=mysqli_query($db,"SELECT * FROM candidate_details") or die(mysqli_error($db));
                 $isAnyCandidateAdded=mysqli_num_rows($fetchingData);
                 if($isAnyCandidateAdded>0){
                    $sno=1;
                    while ($row=mysqli_fetch_assoc($fetchingData)) {
                      $election_id=$row['election_id'];
                      $fetchingElectionName=mysqli_query($db, "SELECT * FROM elections WHERE id='".$election_id."'")or die(mysqli_error($db));
                      $execFetchingElectionNameQuery=mysqli_fetch_assoc($fetchingElectionName);
                      $election_name=$execFetchingElectionNameQuery['election_topic'];
                      $candidate_photo=$row['candidate_photo'];
                     
                        ?>
                          <tr>
                            <td><?php echo $sno++; ?></td>
                            <td> <img src="<?php echo $candidate_photo;  ?>" class="candidate_photo"/> </td>
                            <td><?php echo $row['candidate_name']; ?></td>
                            <td><?php echo $row['candidate_details']; ?></td>
                            <td><?php echo $election_name ?></td>
                            <td>
                                <a href="" class="btn bt-sm btn-warning">Edit</a>
                                <a href="" class="btn bt-sm btn-danger">Delete</a>
                            </td>
                          </tr>
                        <?php
                    }

                 }else{
                    ?>
                   <tr>
                    <td colspan="7">Candidate is not added yet </td>
                   </tr>
                    <?php
                 }
                ?>

            </tbody>
        </table>
    </div>
</div>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['addCandidateBtn'])){

  $election_id = mysqli_real_escape_string($db, $_POST['election_id']);
  $candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);
  $candidate_details = mysqli_real_escape_string($db, $_POST['candidate_details']);
  $inserted_by = $_SESSION['username'];
  $inserted_on = date("Y-m-d");
  
  $candidate_photo = $_FILES['candidate_photo'];
  $imagefilename = $candidate_photo['name'];
  $imagefiletemp = $candidate_photo['tmp_name'];
  $filename_separate = explode('.', $imagefilename);
  $file_extension = strtolower(end($filename_separate));
  $extension = array('jpeg', 'jpg', 'png');
  $upload_image = 'candidate_photo/'.$imagefilename;

  
  $image_size = $candidate_photo['size'];
  if ($image_size > 2000000) {
      echo "<script> location.assign('index.php?addCandidatePage=1&largeFile=1')</script>";
      exit(); 
  }

  
  if (!in_array($file_extension, $extension)) {
      echo "<script> location.assign('index.php?addCandidatePage=1&invalidFile=1')</script>";
      exit(); 
  }
  $upload_directory = 'candidate_photo/';

  
  if (!file_exists($upload_directory)) {
      mkdir($upload_directory, 0777, true); 
  }
  
  if (move_uploaded_file($imagefiletemp, $upload_image)) {
      // Insert data into database
      $query = "INSERT INTO candidate_details(election_id, candidate_name, candidate_details, candidate_photo, inserted_by, inserted_on) VALUES ('$election_id', '$candidate_name', '$candidate_details', '$upload_image', '$inserted_by', '$inserted_on')";
      mysqli_query($db, $query) or die(mysqli_error($db));
      echo "<script> location.assign('index.php?addCandidatePage=1&added=1')</script>";
      exit(); 
  } else {
      echo "<script> location.assign('index.php?addCandidatePage=1&failed=1')</script>" or die(mysqli_error($db));
      exit(); 
  }
     


   
   
    ?>
 <script> location.assign("index.php?addElectionPage=1&added=1")</script>
    <?php
    
}
?>
