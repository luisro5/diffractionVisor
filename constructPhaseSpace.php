<?php
/**
 *
 *
 * This source code is licensed under the MIT license found in the
 * MIT-LICENSE file in the root directory of this source tree.
 *
 *
 */
$pat1=$_POST['allArray1'];
$pat2=$_POST['allArray2'];
$pat3=$_POST['allArray3'];
$pat4=$_POST['allArray4'];
$pat5=$_POST['allArray5'];
$pat6=$_POST['allArray6'];
$pat7=$_POST['allArray7'];
$pat8=$_POST['allArray8'];
$pat9=$_POST['allArray9'];
$pat10=$_POST['allArray10'];
$pat11=$_POST['allArray11'];
$pat12=$_POST['allArray12'];
$pat13=$_POST['allArray13'];
$pat14=$_POST['allArray14'];
$pat15=$_POST['allArray15'];
$destinyPattern='"'.'pattern.php?paramA='.$pat1.'&paramB='.$pat2.'&paramC='.
$pat3.'&alfa='.$pat4.'&beta='.$pat5.'&gamma='.$pat6.'&numX='.$pat7.
'&numY='.$pat8.'&numZ='.$pat9.'&psi='.$pat10.'&phi='.$pat11.
'&tetha='.$pat12.'&voltage='.$pat13.'&crystalline='.
$pat14.'&elements='.$pat15.'"';
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
</br>
  <img src=<?php echo $destinyPattern;?> alt="" />
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
