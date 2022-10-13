<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "users";

$connection    = mysqli_connect($host, $user, $pass, $db);
if (!$connection) { 
    die("Can not connect to database");
}
$name        = "";
$email       = "";
$phone     = "";
$service   = "";
$success     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from user where id = '$id'";
    $q1         = mysqli_query($connection,$sql1);
    if($q1){
        $success = "Data is deleted";
    }else{
        $error  = "Error, Please try again";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from user where id = '$id'";
    $q1         = mysqli_query($connection, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $name        = $r1['name'];
    $email       = $r1['email'];
    $phone     = $r1['phone'];
    $service   = $r1['service'];

    if ($name == '') {
        $error = "Data Not Found";
    }
}
if (isset($_POST['save'])) { 
    $name        = $_POST['name'];
    $email       = $_POST['email'];
    $phone     = $_POST['phone'];
    $service   = $_POST['service'];

    if ($name && $email && $phone && $service) {
        if ($op == 'edit') { 
            $sql1       = "update user set name = '$name',email='$email',phone = '$phone',service='$service' where id = '$id'";
            $q1         = mysqli_query($connection, $sql1);
            if ($q1) {
                $success = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { 
            $sql1   = "insert into user(name,email,phone,service) values ('$name','$email','$phone','$service')";
            $q1     = mysqli_query($connection, $sql1);
            if ($q1) {
                $success     = "Succes!";
            } else {
                $error      = "Failed!";
            }
        }
    } else {
        $error = "Please fill all the data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create / Edit 
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5sec
                }
                ?>
                <?php
                if ($success) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="service" class="col-sm-2 col-form-label">Service</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="service" id="service">
                                <option value="">- Choose Service -</option>
                                <option value="regular" <?php if ($service == "regular") echo "selected" ?>>regular</option>
                                <option value="premium" <?php if ($service == "premium") echo "selected" ?>>premium</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="save" value="Save Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-white bg-secondary">
                User Data
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Service</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from user order by id desc";
                        $q2     = mysqli_query($connection, $sql2);
                        $order   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $name        = $r2['name'];
                            $email       = $r2['email'];
                            $phone     = $r2['phone'];
                            $service   = $r2['service'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $order++ ?></th>
                                <td scope="row"><?php echo $name ?></td>
                                <td scope="row"><?php echo $email ?></td>
                                <td scope="row"><?php echo $phone ?></td>
                                <td scope="row"><?php echo $service ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>