<?php
/**
 *
 *
 * This source code is licensed under the MIT license found in the
 * MIT-LICENSE file in the root directory of this source tree.
 *
 *
 */
$allArray1=$_POST['allArray1'];
$allArray2=$_POST['allArray2'];
$allArray3=$_POST['allArray3'];
$allArray4=$_POST['allArray4'];
$allArray5=$_POST['allArray5'];
$allArray6=$_POST['allArray6'];
$allArray7=$_POST['allArray7'];
$allArray8=$_POST['allArray8'];
$allArray9=$_POST['allArray9'];
$allArray10=$_POST['allArray10'];
$allArray11=$_POST['allArray11'];
$allArray12=$_POST['allArray12'];
$allArray14=$_POST['allArray14'];
$allArray15=$_POST['allArray15'];
include 'mat2PDB.php';
include 'latticeLibrary.php';
//check the type
$typeCrystal1="primitive";
$typeCrystal2="base";
$typeCrystal3="inner";
$typeCrystal4="face";
if(strcmp($allArray14,$typeCrystal1)==0)
{
  $latt=lattice4($allArray1,$allArray2,$allArray3,$allArray4,$allArray5,$allArray6,$allArray7,$allArray8,$allArray9,$allArray10,$allArray11,$allArray12);
}
elseif (strcmp($allArray14,$typeCrystal2)==0)
{
  $latt=bases($allArray1,$allArray2,$allArray3,$allArray7,$allArray8,$allArray9,$allArray10,$allArray11,$allArray12);
}
elseif (strcmp($allArray14,$typeCrystal3)==0)
{
  $latt=inner($allArray1,$allArray2,$allArray3,$allArray7,$allArray8,$allArray9,$allArray10,$allArray11,$allArray12);
}
else
{
  $latt=face($allArray1,$allArray2,$allArray3,$allArray7,$allArray8,$allArray9,$allArray10,$allArray11,$allArray12);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Diffraction Visor</title>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body bgcolor=#67FFFE>
  <div class="jumbotron text-center">
    <h1>Diffraction Visor</h1>
  </br>
  <img src="images/AzaarProgramming_01.png" class="rounded-circle h-25 w-25" alt="Azaar AzaarProgramming_01">
  <p>Preparing file...</p>
</div>
<?php
$basicElement=convertElementText($allArray15);
writerPDB($latt[0],$latt[1],$latt[2],$basicElement);
?>
</br>
<h1>done! file ready!<i class="fas fa-file"></h1>
</br>
<nav class="navbar navbar-inverse">
 <div class="container-fluid">
   <ul class="nav navbar-nav">
     <li class="active"><a href="diffractionVisor.html">Home</a></li>
   </ul>
 </div>
</nav>
</body>
</html>
