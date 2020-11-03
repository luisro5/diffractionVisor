<?php
/**
 *
 *
 * This source code is licensed under the MIT license found in the
 * MIT-LICENSE file in the root directory of this source tree.
 *
 *
 */
$allArray1=$_GET['paramA'];
$allArray2=$_GET['paramB'];
$allArray3=$_GET['paramC'];
$allArray4=$_GET['alfa'];
$allArray5=$_GET['beta'];
$allArray6=$_GET['gamma'];
$allArray7=$_GET['numX'];
$allArray8=$_GET['numY'];
$allArray9=$_GET['numZ'];
$allArray10=$_GET['psi'];
$allArray11=$_GET['phi'];
$allArray12=$_GET['tetha'];
$allArray13=$_GET['voltage'];
$allArray14=$_GET['crystalline'];
$allArray15=$_GET['elements'];
include 'mat2PDB.php';
include 'latticeLibrary.php';
include 'complexLibrary.php';
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
$axisX=$latt[0];
$axisY=$latt[1];
$axisZ=$latt[2];
//start to  iterate all the slices
$sidePlate=getSizePlate($axisX,$axisY);
$subaxisZ=layersInZ($axisZ);
$subaxisZ2=array_unique($subaxisZ);
$subaxisZ2=array_values($subaxisZ2);
$lambas=findLambda($allArray13);
$thick=count($subaxisZ2);
$slices=array();
$currentPass=0;
while($currentPass<($thick))
{
  $flatX=array_slice($axisX,$currentPass*$thick, $thick);
  $flatY=array_slice($axisY,$currentPass*$thick, $thick);
  $plate=generatePlate($flatX,$flatY,$sidePlate);
  $auger=fresnelnu($plate,$sidePlate,$sidePlate,1,
  $subaxisZ2[$currentPass],$lambas);
  $flatty=atomicPotential80($flatX,$flatY,$sidePlate,
  $subaxisZ2[$currentPass],$subaxisZ2[$thick-1],$subaxisZ2[$thick],
  $allArray15,$lambas);
  $imageA1=convolution2($flatty,$auger,$sidePlate);
  $imageA2=convertToIntensities($imageA1);
  $imageA3=convertDataToMax($imageA2);
  $slices[]=$imageA3;
  $currentPass++;
}
$task=convolution2($slices[0],$slices[1],$sidePlate);
$nextOne=2;
while($nextOne<count($slices))
{
    $outerIm=convolution2($task,$slices[$nextOne],$sidePlate);
    $task=$outerIm;
    $nextOne++;
}
//finishing up all images
  $image4=fftshift2d($outerIm,$sidePlate,$sidePlate);
  $image5=convertToIntensities($image4);
  $image6=convertDataToColour($image5);
//START GRAPHICS************************************
//custom output
if($sidePlate<1024)
{
  //custom output
  $canvasSize=800;
}
else
{
  $canvasSize=$sidePlate;
}
// Create the size of image or blank image
$canvas = imagecreatetruecolor($canvasSize, $canvasSize);
// Set the background color of image
$background_color = imagecolorallocate($canvas,  0, 0, 0);
imagefill($canvas, 0, 0, $background_color);
$green=imagecolorallocate($canvas,2,253,1);
$colours=createAllColours($canvas);
$half=$canvasSize/2;
$gen=0;
while($gen<count($image6))
{
    $intense=$image6[$gen];
    $intense2=(int)($intense*255)/100;
    $agentColour=$colours[$intense2];
    $dx=(int)$gen%$sidePlate;
    $dy=(int)$gen/$sidePlate;
    imagesetpixel($canvas, $dx+$half, $dy+$half,$agentColour);
$gen++;
}
$nameEl=convertElementText($allArray15);
$inversetag=tag($allArray1,$allArray2,$allArray3,$allArray4,$allArray5,$allArray6);
$scale="Element:".$nameEl."  ".$inversetag." ".$allArray14." system";
imagestring($canvas, 3, 70, 750, $scale, $green);
header('Content-type: image/png');
imagepng($canvas);
imagedestroy($canvas);
?>
