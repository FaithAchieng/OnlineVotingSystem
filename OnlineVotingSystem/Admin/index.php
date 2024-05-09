<?php

require_once("inc/header.php");
require_once("inc/navigation.php");
if(isset($_GET['homepage'])){
    require_once("inc/homepage.php");
}
else if(isset($_GET['addElectionPage'])){
    require_once("inc/add_election.php");
}else if(isset($_GET['addCandidatePage'])){
require_once("inc/add_candidate.php");
}elseif(isset($_GET['viewResults'])){
require_once("inc/viewResults.php");
}

?>
<?php

require_once("inc/footer.php");
?>