
<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($server,$username,$password,$database);

if(!$conn){
    $error = mysqli_connect_error();
die("sorry fail to connect ". $error);
}
$insert = false;
$update = false;
$delete = false;
$isempty = false;

if (isset($_GET['delete'])){

    $srNo = $_GET['delete'];
  
    $sql = "DELETE FROM `note` WHERE `note`.`sr_no` = $srNo;";
    mysqli_query($conn,$sql);
    $delete = true;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
    if (isset($_POST['editNoteId'])){
        $id = $_POST["editNoteId"];
        $edittitle = $_POST["editTitle"];
        $editdescription = $_POST["editDescription"];
        $sql = "UPDATE `note` SET `Title` = '$edittitle', `description` = '$editdescription' 
        WHERE `note`.`sr_no` = $id;";
         mysqli_query($conn,$sql);
         $update = true;
    }
    else{

        $title = $_POST["title"];
        $description = $_POST["description"];
      
        if (empty($title) || empty($description)) {
          $isempty = true;
          
        }else{
          $sql = "INSERT INTO `note` ( `Title`, `description`, `date`) 
          VALUES ( '$title', '$description', current_timestamp());";
          $result = mysqli_query($conn,$sql);
          $insert = true;
        }
    
    
    }
}



        

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
  <body>
    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit your Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/crud/index.php" method= "post">
            <input type="hidden" id="editNoteId" name="editNoteId" value="">
            <div class="mb-3">
              <label for="editTitle" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="editTitle" name= "editTitle" aria-describedby="emailHelp">
              
            </div>
          <div class="mb-3">
            <label for="editDescription" class="form-label">Description</label>
            <textarea class="form-control" id="editDescription" name = "editDescription" rows="3"></textarea>
          </div>
          
          <button type="submit" class="btn btn-primary">Save changes</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg  bg-body-tertiary">
  <div class="container-fluid">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/2560px-PHP-logo.svg.png" height="26px" alt="" srcset="">
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
          <a class="nav-link" href="#">Contact-Us</a>
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
if ($insert) {
  echo'  <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Sucess!</strong> Your Note Has Been Added Sucessfully
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}elseif($update){
    echo'  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sucess!</strong> Your Note Has Been Updated Sucessfully
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
elseif($delete){
    echo'  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sucess!</strong> Your Note Has Been Deleted Sucessfully
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}elseif($isempty){
  echo'  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Please fill in all fields.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  
}
?>

<div class="container my-4">
    <h2>Add a Note</h2>
<form action="/crud/index.php" method= "post">
  <div class="mb-3">
    <label for="title" class="form-label">Note Title</label>
    <input type="text" class="form-control" id="title" name= "title" aria-describedby="emailHelp">
    
  </div>
<div class="mb-3">
  <label for="description" class="form-label">Description</label>
  <textarea class="form-control" id="description" name = "description" rows="3"></textarea>
</div>

  <button type="submit" class="btn btn-primary">Add Note</button>
</form>
</div>


<div class="container">
 
    <table class="table" id = "myTable">
  <thead>
    <tr>
      <th scope="col">Sr-No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

<?php

$sql = "SELECT * FROM `note`";
$result = mysqli_query($conn,$sql);
$no = 0;
 while($row =mysqli_fetch_assoc($result)){
   $no = $no+1; 
     echo "<tr>
      
      <td>$no</td>
      <td>$row[Title]</td>
      <td>$row[description]</td>
      <td><button type='button' id='$row[sr_no]' class='edit btn btn-sm btn-success'>Edit</button>
<button type='button' id='d$row[sr_no]' class='delete btn btn-sm btn-danger'>Delete</button></td>
    </tr>";
    
 }

?>

  </tbody>
</table>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    
        // Add an event listener for the "Edit" button outside the loop
        document.getElementById('myTable').addEventListener('click', function(e) {
            if (e.target.classList.contains('edit')) {
                let tr = e.target.closest('tr');
                let title = tr.getElementsByTagName('td')[1].innerText;
                let description = tr.getElementsByTagName('td')[2].innerText;
                let editNoteId = e.target.id;
    
                // Set the values in the modal
                document.getElementById('editTitle').value = title;
                document.getElementById('editDescription').value = description;
                document.getElementById('editNoteId').value = editNoteId;
    
                $('#editModal').modal('show');
            }
             if(e.target.classList.contains('delete')){
                let tr = e.target.closest('tr');
                let deleteNodeId = e.target.id.substr(1,)
                if (confirm("are you sure you want to delete")) {
                 window.location = `/crud/index.php?delete=${deleteNodeId}`

                }
            }
        });
    </script>
    
</body>
</html>