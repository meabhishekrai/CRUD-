<?php

$insert = false;
$update = false;
$delete = false;
/*INSERT INTO `notes` (`sno.`, `title`, `descr`, `timestamp`) 
     VALUES ('1', 'we go gym', 'we go gym early morning and after that learn php', current_timestamp());*/
//connecting to the database
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'notes';

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){

  die("The connection is unsuccessfull:" . mysqli_connect_error());

}


if(isset($_GET['delete'])){

  $sno = $_GET['delete'];

  $delete = true;

  $sql = "DELETE FROM `notes` WHERE `notes`.`sno.` = $sno";
  //"DELETE FROM `notes` WHERE `sno.` = $sno";

  $result = mysqli_query($conn, $sql);

}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  if(isset($_POST['snoEdit'])){

    $sno = $_POST["snoEdit"];

    $title = $_POST["titleEdit"];

    $descr = $_POST["descrEdit"];
  
  
    $sql = "UPDATE `notes` SET `title` = '$title',
                                `descr` = '$descr' WHERE `notes`.`sno.` = $sno";

    $result = mysqli_query($conn, $sql);
    
    if($result){

      $update =true;

    }

    else{

      echo "We cannot Update the Record";

    }
  }

  else{

  
  $title = $_POST["title"];

  $descr = $_POST["descr"];


  $sql = "INSERT INTO `notes` (`title`, `descr`) VALUES ('$title', '$descr')";
  $result = mysqli_query($conn, $sql);

  if($result){

    /*echo '<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Sucess!The Note is added successfully.</h4>
  </div> <br>';*/
  $insert = true;

  }
    else{

      echo "Unable to save the record <br>";
    }
    }
  }
 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  
  </head>

  <body>

 <!-- EDIT modal
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editmodal">
  Edit Modal
</button>-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crud/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc">Note Description</label>

              <textarea class="form-control" id="descrEdit" name="descrEdit" rows="3"></textarea>
              <button type="submit" class="btn btn-primary">Update Note</button>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
           
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
        </form>
      </div>
      </div>
    </div>
  </div>

    <nav class="navbar navbar-dark bg-dark body body-tertiary">
        <a class="navbar-brand" href="#">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="/crud/logo.svg" height = "28px" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
              </ul>

              
            <form class="d-flex" role="search">

              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">

              <button class="btn btn-outline-success" type="submit">Search</button>
              
            </form>
        
          </div>
        </div>
      </nav>
      <?php
      if($insert){
echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been inserted successfully
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div';
      }
      ?>
      <?php
      if($update){
echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been updated successfully
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div';
      }
      ?>
      <?php
      if($delete){
echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been deleted successfully
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div';
      }
      ?>
      <div class="container">
<h2>Add a Note</h2>
<form action = "/crud/index.php" method = "POST">
    <div class="mb-3">
      <label for="title" class="form-label">Note</label>
      <input type="text" class="form-control" id="title" name = "title" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
      <label for="descr" class="form-label">Description</label>
      <input type="text" class="form-control" id="descr" name = "descr">
    </div>
    <button type="submit" class="btn btn-primary">Add Note</button>
  </form>
  <hr>
          </div>
          <div class="container">
<table class="table" id = "myTable">

  <thead>
    <tr>
      <th scope="col">Sno</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php

$sql = "SELECT * FROM `notes`";
$result = mysqli_query($conn, $sql);
$sno = 0;
while($row = mysqli_fetch_assoc($result)){
  $sno = $sno + 1;
  echo "<tr>
  <th scope='row'>". $sno .  "</th>
  <td>". $row['title'] . "</td>
  <td>". $row['descr'] . "</td>
  <td> <button class='edit btn-sm btn-primary' id =". $row['sno.'] .">Edit</button>  
                               <button class='delete btn-sm btn-primary' id = d". $row['sno.'] .">Delete</button>
</tr>";

}


          ?>
   
  
  </tbody>
</table>

          </div>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
  
  <script>
   $(document).ready( function () {
    $('#myTable').DataTable();
} );


  </script>
  <script>
edits =  document.getElementsByClassName('edit')
Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        descr = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, descr);
        titleEdit.value = title;
        descrEdit.value = descr;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
  $('#editModal').modal('toggle');
  })

})
deletes =  document.getElementsByClassName('delete')
Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1,);
        if(confirm("Are you sure you want to delete the note?")){
          console.log("yes")
          window.location = '/crud/index.php?delete=${sno.}';
        }
else{

  console.log("no");

}

      })

})

</script
  
  </body>

</html>