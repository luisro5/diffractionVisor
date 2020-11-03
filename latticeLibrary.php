<?php
/**
 *
 *
 * This source code is licensed under the MIT license found in the
 * MIT-LICENSE file in the root directory of this source tree.
 *
 *
 */
//all the lattice functions
//next power of 2:
function next_pow($number)
{
  if($number < 2) return 1;
  for($i = 0 ; $number > 1 ; $i++)
  {
    $number = $number >> 1;
  }
  return 1<<($i+1);
}
//aberration adjustment
function xaberration($cs,$lambda,$defocus)
{
  $u=(2*M_PI)/lambda;
  //resolution is given in Angstroms
  $unitdouble=pow($u,2);
  $unitfour=pow($u,4);
  $first=pow(0.5*M_PI*$unitfour*$cs*$lambda,3);
  $second=M_PI*$defocus*$lambda*$unitdouble;
  $nux=$first+$second;
  return $nux;
}
// modifies the optical adjustment
function opticalMod($base,$cs1,$lambda1,$defocus1)
{
  $changeA=xaberration($cs1,$lambda1,$defocus1);
  $change=$base*exp(-2*M_PI*$changeA);
  return $change;
}
//this function find lambda based on the voltage
function findLambda($volts)
{
  $h = 6.62606957e-34;
  $emass= 9.10938291e-31;
  $light = 299792458;
  $c2=pow($light,2);
  $elementalCharge=1.60217657e-19;
  $subterm=($elementalCharge*$volts)/(2*$emass*$c2);
  $term1=$h/sqrt(2*$emass*$elementalCharge*$volts);
  $term2=1/sqrt(1+$subterm);
  $newlambda=$term1*$term2;
  return $newlambda;
}
//percentageToHex return a string
function percentageToHex($percentage)
{
  //percentage must be 1(100%) to 0
  $maximum=16777215;
  $temp1=$maximum*$percentage;
  $temp2=strval($temp1);
  base_convert($temp2,10,16);
  return $temp2;
}
//rotate the matrix using rotation angles
function rotativeMatrix($phi,$tetha,$psi)
{
  $phi2=deg2rad($phi);
  $tetha2=deg2rad($tetha);
  $psi2=deg2rad($psi);
  $r11=(cos($psi2)*cos($tetha2)*cos($phi2))-(sin($psi2)*sin($phi2));
  $r12=(-cos($psi2)*cos($tetha2)*sin($phi2))-(sin($psi2)*sin($phi2));
  $r13=cos($psi2)*sin($tetha2);
  $r21=(sin($psi2)*cos($tetha2)*cos($phi2))+(cos($psi2)*sin($phi2));
  $r22=(-sin($psi2)*cos($tetha2)*sin($phi2))+(cos($psi2)*cos($phi2));
  $r23=sin($psi2)*sin($tetha2);
  $r31=-sin($tetha2)*cos($phi2);
  $r32=sin($tetha2)*sin($phi2);
  $r33=cos($tetha2);
  return [$r11,$r12,$r13,$r21,$r22,$r23,$r31,$r32,$r33];
}
// generates the lattice points to generate the matrix of points
function lattice4($aa,$bb,$cc,$alfie,$betie,$gammie,$l,$m,$n,$psi4,$phi4,$tetha4)
{
  $ax=array();
  $ay=array();
  $az=array();
  $alti5=deg2rad($alfie);
  $beti5=deg2rad($betie);
  $gati5=deg2rad($gammie);
  $doublealfa=pow(cos($alti5),2);
  $doublebeta=pow(cos($beti5),2);
  $doublegamma=pow(cos($gati5),2);
  $prevol1=$aa*$bb*$cc;
  $prevol2=2*cos($alti5)*cos($beti5)*cos($gati5);
  $vol=$prevol1*sqrt(1-$doublealfa-$doublebeta-$doublegamma+$prevol2);
  $a11=$aa;
  $a12=$bb*cos($gati5);
  $a13=$cc*cos($beti5);
  $a21=0;
  $a22=$bb*sin($gati5);
  $a23=$cc*((cos($alti5)-cos($beti5)*cos($gati5))/sin($gati5));
  $a31=0;
  $a32=0;
  $a33=$vol/($aa*$bb*sin($gati5));
  $rotated=rotativeMatrix($phi4,$tetha4,$psi4);
  $b11=$rotated[0];
  $b12=$rotated[1];
  $b13=$rotated[2];
  $b21=$rotated[3];
  $b22=$rotated[4];
  $b23=$rotated[5];
  $b31=$rotated[6];
  $b32=$rotated[7];
  $b33=$rotated[8];
  $c11=($b11*$a11)+($b12*$a21)+($b13*$a31);
  $c12=($b11*$a12)+($b12*$a22)+($b13*$a32);
  $c13=($b11*$a13)+($b12*$a23)+($b13*$a33);
  $c21=($b21*$a11)+($b22*$a21)+($b23*$a31);
  $c22=($b21*$a12)+($b22*$a22)+($b23*$a32);
  $c23=($b21*$a13)+($b22*$a23)+($b23*$a33);
  $c31=($b31*$a11)+($b32*$a21)+($b33*$a31);
  $c32=($b31*$a12)+($b32*$a22)+($b33*$a32);
  $c33=($b31*$a13)+($b32*$a23)+($b33*$a33);
  for($i=-$l;$i<$l;$i++)
  {
    for($j=-$m;$j<$m;$j++)
    {
      for($k=-$n;$k<$n;$k++)
      {
        $bas1=($j*$c11)+($i*$c12)+($k*$c13);
        $bas2=($j*$c21)+($i*$c22)+($k*$c23);
        $bas3=($j*$c31)+($i*$c32)+($k*$c33);
        $ax[]=$bas1;
        $ay[]=$bas2;
        $az[]=$bas3;
      }
    }
  }
return [$ax,$ay,$az];
}
// MODIFY TO GENERATE THE COMPLETE MATRIX*******************************************
//base crystallography structure
function bases($aa,$bb,$cc,$l,$m,$n,$psi4,$phi4,$tetha4)
{
  $ax=array();
  $ay=array();
  $az=array();
  $a11=$aa;
  $a12=0;
  $a13=0;
  $a21=0;
  $a22=$bb;
  $a23=0;
  $a31=0;
  $a32=0;
  $a33=$cc;
  $rotated=rotativeMatrix($phi4,$tetha4,$psi4);
  $b11=$rotated[0];
  $b12=$rotated[1];
  $b13=$rotated[2];
  $b21=$rotated[3];
  $b22=$rotated[4];
  $b23=$rotated[5];
  $b31=$rotated[6];
  $b32=$rotated[7];
  $b33=$rotated[8];
  $c11=$b11*$a11;
  $c12=$b12*$a22;
  $c13=$b13*$a33;
  $c21=$b21*$a11;
  $c22=$b22*$a22;
  $c23=$b23*$a33;
  $c31=$b31*$a11;
  $c32=$b32*$a22;
  $c33=$b33*$a33;
  for($i=-$l;$i<$l;$i++)
  {
    for($j=-$m;$j<$m;$j++)
    {
      for($k=-$n;$k<$n;$k++)
      {
        $aaa=($j*$c11)+($i*$c12)+($k*$c13);
        $bbb=($j*$c21)+($i*$c22)+($k*$c23);
        $ccc=($j*$c31)+($i*$c32)+($k*$c33);
        $mon2=($i+0.5)*$bbb;
        $mon1=($j+0.5)*$aaa;
        $ax[]=$j*$aaa;
        $ay[]=$i*$bbb;
        $az[]=$k*$ccc;
        $ax[]=$mon1;
        $ay[]=$mon2;
        $az[]=$k*$ccc;
      }
    }
  }
  return [$ax,$ay,$az];
}
//inner crystallography structure
function inner($aa,$bb,$cc,$l,$m,$n,$psi4,$phi4,$tetha4)
{
  $ax=array();
  $ay=array();
  $az=array();
  $a11=$aa;
  $a12=0;
  $a13=0;
  $a21=0;
  $a22=$bb;
  $a23=0;
  $a31=0;
  $a32=0;
  $a33=$cc;
  $rotated=rotativeMatrix($phi4,$tetha4,$psi4);
  $b11=$rotated[0];
  $b12=$rotated[1];
  $b13=$rotated[2];
  $b21=$rotated[3];
  $b22=$rotated[4];
  $b23=$rotated[5];
  $b31=$rotated[6];
  $b32=$rotated[7];
  $b33=$rotated[8];
  $c11=$b11*$a11;
  $c12=$b12*$a22;
  $c13=$b13*$a33;
  $c21=$b21*$a11;
  $c22=$b22*$a22;
  $c23=$b23*$a33;
  $c31=$b31*$a11;
  $c32=$b32*$a22;
  $c33=$b33*$a33;
  for($i=-$l;$i<$l;$i++)
  {
    for($j=-$m;$j<$m;$j++)
    {
      for($k=-$n;$k<$n;$k++)
      {
        $aaa=($j*$c11)+($i*$c12)+($k*$c13);
        $bbb=($j*$c21)+($i*$c22)+($k*$c23);
        $ccc=($j*$c31)+($i*$c32)+($k*$c33);
        $mon2=($i+0.5)*$bbb;
        $mon1=($j+0.5)*$aaa;
        $mon3=($k+0.5)*$ccc;
        $ax[]=$j*$aaa;
        $ay[]=$i*$bbb;
        $az[]=$k*$ccc;
        $ax[]=$mon1;
        $ay[]=$mon2;
        $az[]=$mon3;
      }
    }
  }
  return [$ax,$ay,$az];
}
//face crystallography structure
function face($aa,$bb,$cc,$l,$m,$n,$psi4,$phi4,$tetha4)
{
  $ax=array();
  $ay=array();
  $az=array();
  $a11=$aa;
  $a12=0;
  $a13=0;
  $a21=0;
  $a22=$bb;
  $a23=0;
  $a31=0;
  $a32=0;
  $a33=$cc;
  $rotated=rotativeMatrix($phi4,$tetha4,$psi4);
  $b11=$rotated[0];
  $b12=$rotated[1];
  $b13=$rotated[2];
  $b21=$rotated[3];
  $b22=$rotated[4];
  $b23=$rotated[5];
  $b31=$rotated[6];
  $b32=$rotated[7];
  $b33=$rotated[8];
  $c11=$b11*$a11;
  $c12=$b12*$a22;
  $c13=$b13*$a33;
  $c21=$b21*$a11;
  $c22=$b22*$a22;
  $c23=$b23*$a33;
  $c31=$b31*$a11;
  $c32=$b32*$a22;
  $c33=$b33*$a33;
  for($i=-$l;$i<$l;$i++)
  {
    for($j=-$m;$j<$m;$j++)
    {
      for($k=-$n;$k<$n;$k++)
      {
        $aaa=($j*$c11)+($i*$c12)+($k*$c13);
        $bbb=($j*$c21)+($i*$c22)+($k*$c23);
        $ccc=($j*$c31)+($i*$c32)+($k*$c33);
        $mon2=($i+0.5)*$bbb;
        $mon1=($j+0.5)*$aaa;
        $mon3=($k+0.5)*$ccc;
        $ax[]=$j*$aaa;
        $ay[]=$i*$bbb;
        $az[]=$k*$ccc;
        $ax[]=$mon1;
        $ay[]=$mon2;
        $az[]=$k*$ccc;
        $ax[]=$mon1;
        $ay[]=$i*$bbb;
        $az[]=$mon3;
        $ax[]=$j*$aaa;
        $ay[]=$mon2;
        $az[]=$mon3;
      }
    }
  }
  return [$ax,$ay,$az];
}
//----------------------------------------------------------------
//-----function to start the cicles over sample
//----------------------------------------------------------------
function layersInZ($arrayZ)
{
 $piece=array();
 for($layer=0;$layer<count($arrayZ);$layer++)
 {
   $lay=$arrayZ[$layer];
   if(abs($lay)>0.1)
   {
     $piece[]=$lay;
   }
   else
   {
     $piece[]=0;
   }
 }
 return $piece;
}
//--------------------RENDER FUNCTIONS-------------------------------------
function render8($x,$y,$z,$minz)
{
 $temporal=$z+$minz;
 $u=(int)($x*16)/$temporal;
 $v=(int)($y*16)/$temporal;
 return [$u,$v];
}
function tag($pa,$pb,$pc,$anga,$angb,$angg)
{
  $anga4=deg2rad($anga);
  $angb4=deg2rad($angb);
  $angg4=deg2rad($angg);
  $cosquada=pow(cos($anga4),2);
  $cosquadb=pow(cos($angb4),2);
  $cosquadg=pow(cos($angg4),2);
  $part1v=$pa*$pb*$pc;
  $part2v=1-$cosquada-$cosquadb-$cosquadg;
  $part3v=(2*cos($anga4)*cos($angb4))+(2*cos($anga4)*cos($angg4))
  +(2*cos($angb4)*cos($angg4));
  $part4v=$part2v+$part3v;
  $part5v=sqrt($part4v);
  $volume=$part1v*$part5v;
  $arecip=($pb*$pc*sin($anga4))/$volume;
  $leyend=$arecip." A-1";
  return $leyend;
}
//-------------------------------------------------------------------------
?>
