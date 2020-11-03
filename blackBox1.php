<?php
/**
 *
 *
 * This source code is licensed under the MIT license found in the
 * MIT-LICENSE file in the root directory of this source tree.
 *
 *
 */
$allArray1=$_POST['paramA'];
$allArray2=$_POST['paramB'];
$allArray3=$_POST['paramC'];
$allArray4=$_POST['alfa'];
$allArray5=$_POST['beta'];
$allArray6=$_POST['gamma'];
$allArray7=$_POST['numX'];
$allArray8=$_POST['numY'];
$allArray9=$_POST['numZ'];
$allArray10=$_POST['psi'];
$allArray11=$_POST['phi'];
$allArray12=$_POST['tetha'];
$allArray13=$_POST['voltage'];
$allArray14=$_POST['crystalline'];
$allArray15=$_POST['elements'];
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
</head>
<body bgcolor=#67FFFE>
    <div class="jumbotron text-center">
      <h1>Diffracction Visor</h1>
    </br>
    <img src="images/AzaarProgramming_01.png" class="rounded-circle h-25 w-25" alt="Azaar AzaarProgramming_01">
    <p>Select the option to see:</p>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <form action="construct3d.php" method="post" target="_blank">
 <div class="form-group">
   <input type="hidden" name="allArray1" value='<?php echo $allArray1;?>'>
   <input type="hidden" name="allArray2" value='<?php echo $allArray2;?>'>
   <input type="hidden" name="allArray3" value='<?php echo $allArray3;?>'>
   <input type="hidden" name="allArray4" value='<?php echo $allArray4;?>'>
   <input type="hidden" name="allArray5" value='<?php echo $allArray5;?>'>
   <input type="hidden" name="allArray6" value='<?php echo $allArray6;?>'>
   <input type="hidden" name="allArray7" value='<?php echo $allArray7;?>'>
   <input type="hidden" name="allArray8" value='<?php echo $allArray8;?>'>
   <input type="hidden" name="allArray9" value='<?php echo $allArray9;?>'>
   <input type="hidden" name="allArray10" value='<?php echo $allArray10;?>'>
   <input type="hidden" name="allArray11" value='<?php echo $allArray11;?>'>
   <input type="hidden" name="allArray12" value='<?php echo $allArray12;?>'>
   <input type="hidden" name="allArray14" value='<?php echo $allArray14;?>'>
   <input type="hidden" name="allArray15" value='<?php echo $allArray15;?>'>
   <button type="submit" class="btn btn-info">3D View</button>
 </div>
</form>
      </div>
      <div class="col-sm-4">
        <form action="constructPhaseSpace.php" method="post" target="_blank">
 <div class="form-group">
   <input type="hidden" name="allArray1" value='<?php echo $allArray1;?>'>
   <input type="hidden" name="allArray2" value='<?php echo $allArray2;?>'>
   <input type="hidden" name="allArray3" value='<?php echo $allArray3;?>'>
   <input type="hidden" name="allArray4" value='<?php echo $allArray4;?>'>
   <input type="hidden" name="allArray5" value='<?php echo $allArray5;?>'>
   <input type="hidden" name="allArray6" value='<?php echo $allArray6;?>'>
   <input type="hidden" name="allArray7" value='<?php echo $allArray7;?>'>
   <input type="hidden" name="allArray8" value='<?php echo $allArray8;?>'>
   <input type="hidden" name="allArray9" value='<?php echo $allArray9;?>'>
   <input type="hidden" name="allArray10" value='<?php echo $allArray10;?>'>
   <input type="hidden" name="allArray11" value='<?php echo $allArray11;?>'>
   <input type="hidden" name="allArray12" value='<?php echo $allArray12;?>'>
   <input type="hidden" name="allArray13" value='<?php echo $allArray13;?>'>
   <input type="hidden" name="allArray14" value='<?php echo $allArray14;?>'>
   <input type="hidden" name="allArray15" value='<?php echo $allArray15;?>'>
   <button type="submit" class="btn btn-info">Phase Space</button>
 </div>
</form>
      </div>
      <div class="col-sm-4">
        <form action="downloadPDB.php" method="post" target="_blank">
 <div class="form-group">
   <input type="hidden" name="allArray1" value='<?php echo $allArray1;?>'>
   <input type="hidden" name="allArray2" value='<?php echo $allArray2;?>'>
   <input type="hidden" name="allArray3" value='<?php echo $allArray3;?>'>
   <input type="hidden" name="allArray4" value='<?php echo $allArray4;?>'>
   <input type="hidden" name="allArray5" value='<?php echo $allArray5;?>'>
   <input type="hidden" name="allArray6" value='<?php echo $allArray6;?>'>
   <input type="hidden" name="allArray7" value='<?php echo $allArray7;?>'>
   <input type="hidden" name="allArray8" value='<?php echo $allArray8;?>'>
   <input type="hidden" name="allArray9" value='<?php echo $allArray9;?>'>
   <input type="hidden" name="allArray10" value='<?php echo $allArray10;?>'>
   <input type="hidden" name="allArray11" value='<?php echo $allArray11;?>'>
   <input type="hidden" name="allArray12" value='<?php echo $allArray12;?>'>
   <input type="hidden" name="allArray14" value='<?php echo $allArray14;?>'>
   <input type="hidden" name="allArray15" value='<?php echo $allArray15;?>'>
   <button type="submit" class="btn btn-info">download PDB</button>
 </div>
</form>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-inverse">
   <div class="container-fluid">
     <ul class="nav navbar-nav">
       <li class="active"><a href="diffractionVisor.html">Home</a></li>
     </ul>
   </div>
  </nav>
</body>
</html>
