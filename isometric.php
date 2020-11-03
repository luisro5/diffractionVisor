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
$allArray14=$_GET['crystalline'];
$allArray15=$_GET['elements'];
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
$visualx=$latt[0];
$visualy=$latt[1];
$visualz=$latt[2];
$coordinates=0;
$isoWidth=800;
$isoHeight=800;
// Create the size of image or blank image
$image = imagecreatetruecolor($isoWidth, $isoHeight);
$halfx=$isoWidth/2;
$halfy=$isoHeight/2;
// Set the background color of image
$background_color = imagecolorallocate($image,  0, 0, 0);
imagefill($image, 0, 0, $background_color);
$minZ=abs(min($visualz))+1;
$green=imagecolorallocate($image,2,253,1);
$red=imagecolorallocate($image,227,66,52);
$gen=0;
while($gen<count($visualx))
{
 $node0x=$visualx[$gen];
 $node0y=$visualy[$gen];
 $node0z=$visualz[$gen];
 $vertex=render8($node0x,$node0y,$node0z,$minZ);
 $potx=(int)$vertex[0]+$halfx;
 $poty=(int)$vertex[1]+$halfy;
imagesetpixel($image, $potx, $poty,$green);
$gen++;
}
$nameEl=convertElementText($allArray15);
$scale="Element:".$nameEl."  ".$allArray1."x".$allArray2."x".$allArray3.
" nm alpha: ".$allArray4." Betha: ".$allArray5." Gamma: ".$allArray6." ".
$allArray14." system";
imageline($image,$halfx/2,0,$halfy/2,$isoHeight,$red);
imageline($image,0,$halfy,$halfx,$isoHeight,$red);
imageline($image,0,$halfy+($halfy/2),$isoWidth,$halfy+($halfy/2),$red);
imagestring($image, 3, 70, 750, $scale, $green);
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
