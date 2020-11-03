<?php
/**
 *
 *
 * This source code is licensed under the MIT license found in the
 * MIT-LICENSE file in the root directory of this source tree.
 *
 *
 */
$data3d1=$_POST['allArray1'];
$data3d2=$_POST['allArray2'];
$data3d3=$_POST['allArray3'];
$data3d4=$_POST['allArray4'];
$data3d5=$_POST['allArray5'];
$data3d6=$_POST['allArray6'];
$data3d7=$_POST['allArray7'];
$data3d8=$_POST['allArray8'];
$data3d9=$_POST['allArray9'];
$data3d10=$_POST['allArray10'];
$data3d11=$_POST['allArray11'];
$data3d12=$_POST['allArray12'];
$data3d14=$_POST['allArray14'];
$data3d15=$_POST['allArray15'];
$destiny3d='"'.'isometric.php?paramA='.$data3d1.'&paramB='.$data3d2.'&paramC='.
$data3d3.'&alfa='.$data3d4.'&beta='.$data3d5.'&gamma='.$data3d6.'&numX='.$data3d7.
'&numY='.$data3d8.'&numZ='.$data3d9.'&psi='.$data3d10.'&phi='.$data3d11.
'&tetha='.$data3d12.'&crystalline='.$data3d14.'&elements='.$data3d15.'"';
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Difracction Visor</title>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body bgcolor=#67FFFE>
  <div class="jumbotron text-center">
    <h1>Diffracction Visor</h1>
  </br>
  <img src="images/AzaarProgramming_01.png" class="rounded-circle h-25 w-25" alt="Azaar AzaarProgramming_01">
</div>
</br>
  <img src=<?php echo $destiny3d;?> alt="" />
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
