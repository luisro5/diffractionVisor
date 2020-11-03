<?php
/**
 *
 *
 * This source code is licensed under the MIT license found in the
 * MIT-LICENSE file in the root directory of this source tree.
 *
 *
 */
//------------------------------------------------------------------------------
// START OF DEFINITIONS
//------------------------------------------------------------------------------
class Complex
{
    public $real;
    public $imaginary;

    function __construct($real, $imaginary)
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    function Add($other, $dst)
    {
        $dst->real = $this->real + $other->real;
        $dst->imaginary = $this->imaginary + $other->imaginary;
        return $dst;
    }

    function Subtract($other, $dst)
    {
        $dst->real = $this->real - $other->real;
        $dst->imaginary = $this->imaginary - $other->imaginary;
        return $dst;
    }

    function Multiply($other, $dst)
    {
        //cache real in case dst === this
        $r=($this->real * $other->real) - ($this->imaginary * $other->imaginary);
        $dst->imaginary=($this->real * $other->imaginary) + ($this->imaginary * $other->real);
        $dst->real = $r;
        return $dst;
    }

    function ComplexExponential($dst)
    {
        $er = exp($this->real);
        $dst->real = $er * cos($this->imaginary);
        $dst->imaginary = $er * sin($this->imaginary);
        return $dst;
    }

    function normalDivide($other, $dst)
    {
        //cache real in case dst === this
        //this will be complex(x1,y1)/complex(x2,0)
        $r = $this->real/$other->real;
        $dst->imaginary = $this->imaginary/$other->real;
        $dst->real = $r;
        return $dst;
    }

    function divide($other, $dst)
    {
        //cache real in case dst === this
        //this will be complex(x1,y1)/complex(x2,y2)
        $acom=$this->real;
        $bcom=$this->imaginary;
        $ccom=$other->real;
        $dcom=$other->imaginary;
        $denom=pow($ccom,2)+pow($dcom,2);
        $anumer=($acom*$ccom)+($bcom*$dcom);
        $bnumer=($bcom*$ccom)-($acom*$dcom);
        $dst->real = $anumer/$denom;
        $dst->imaginary = $bnumer/$denom;
        return $dst;
    }

    function realPower()
    {
      $aPart=$this->real;
      $bPart=$this->imaginary;
      $cPart=sqrt(pow($aPart,2)+pow($bPart,2));
      return $cPart;
    }

    function showReal()
    {
      $dPart=$this->real;
      return $dPart;
    }

    function showImaginary()
    {
      $ePart=$this->imaginary;
      return $ePart;
    }
}
//------------------------------------------------------------------------------
// START OF FUNCTIONS
//------------------------------------------------------------------------------
function IFFT($amplitudes)
{
    $N = count($amplitudes);
    $iN = 1 / $N;

    // Conjugate if imaginary part is not 0
    for($i = 0; $i < $N; ++$i)
    {
        if($amplitudes[$i] instanceof Complex)
        {
            $amplitudes[$i]->imaginary = -$amplitudes[$i]->imaginary;
        }
    }

    // Apply Fourier Transform
    $amplitudes = FFT($amplitudes);

    for($i = 0; $i < $N; ++$i)
    {
        //Conjugate again
        $amplitudes[$i]->imaginary = -$amplitudes[$i]->imaginary;
        // Scale
        $amplitudes[$i]->real *= $iN;
        $amplitudes[$i]->imaginary *= $iN;
    }
    return $amplitudes;
}


function FFT($amplitudes)
{
    $N = count($amplitudes);
    if($N <= 1)
    {
        return $amplitudes;
    }

    $hN = $N / 2;

    $even =  array_pad(array() , $hN, 0);
    $odd =  array_pad(array() , $hN, 0);
    for($i = 0; $i < $hN; ++$i)
    {
        $even[$i] = $amplitudes[$i*2];
        $odd[$i] = $amplitudes[$i*2+1];
    }
    $even = FFT($even);
    $odd = FFT($odd);

    $a = -2*PI();
    for($k = 0; $k < $hN; ++$k)
    {
        if(!($even[$k] instanceof Complex))
        {
            $even[$k] = new Complex($even[$k], 0);
        }

        if(!($odd[$k] instanceof Complex))
        {
            $odd[$k] = new Complex($odd[$k], 0);
        }
        $p = $k/$N;
        $t = new Complex(0, $a * $p);

        $t->ComplexExponential($t);
        $t->Multiply($odd[$k], $t);


        $amplitudes[$k] = $even[$k]->Add($t, $odd[$k]);
        $amplitudes[$k + $hN] = $even[$k]->Subtract($t, $even[$k]);
    }
    return $amplitudes;
}

function convertToComplex($reals)
{
  //this function converts the array of reals to complex
  // if there is not imaginary number then pass 0 to imaginary
  $drive=array();
  for($nom = 0; $nom < count($reals); $nom++)
  {
    $drive[] = new Complex($reals[$nom], 0);
  }
  return $drive;
}
function convertToIntensities($anotherComplex)
{
  //this function converts the array of complex to reals
  $drive2=array();
  for($nom2 = 0; $nom2 < count($anotherComplex); $nom2++)
  {
    $takeAway=$anotherComplex[$nom2];
    $drive2[] = $takeAway->realPower();
  }
  return $drive2;
}
function x0Filter($m,$n,$dx0)
{
  // n and m must be the same !!
    $out=array();
    $i=-($n/2);
    while($i<($n/2))
    {
      $da=$i*$dx0;
      $counter=0;
      while($counter<$m)
      {
        $out[]=$da;
        $counter++;
      }
      $i++;
    }
    return $out;
}

function transposeShift($original,$r)
{
  //this function must be applied after the FFT
  //also asume that n*n matrix as inputs
  $shifted=array();
  $xshift=$r/2;
  $yshift=$r/2;
  array_pad($shifted,count($original),0);
  for ( $i = 0; $i < $r; $i++)
  {
    $ii = ($i + $xshift) % $r;
    for ($j = 0; $j < $r; $j++)
    {
      $jj = ($j + $yshift) % $r;
      $shifted[$ii * $r + $jj] = $original[$i * $r + $j];
    }
  }
  return $shifted;
}
function d2FFT($theComplex,$rows,$columns)
{
  $outer1=array();
  //first we process the $rows
  for($moveRow = 0; $moveRow < count($theComplex); $moveRow+=$rows)
  {
    $tempo1=array_slice($theComplex,$moveRow,$rows);
    $tempo2=FFT($tempo1);
    array_push($outer1,...$tempo1);
  }
  $postOuter1=transposeShift($outer1,$rows);
  $postOuter2=array_values($postOuter1);
  //then we process the $columns
  $outer3=array();
  for($moveColumns = 0; $moveColumns < count($postOuter2); $moveColumns+=$columns)
  {
    $tempo3=array_slice($postOuter2,$moveColumns,$columns);
    $tempo4=FFT($tempo3);
    array_push($outer3,...$tempo3);
  }
  $div=$rows*$columns;
  $norm=new Complex($div,0);
  $outer4=array();
  for($normal=0;$normal<count($outer3);$normal++)
  {
      $tre=$outer3[$normal];
      $tre->divide($norm, $tre);
      $outer4[]=$tre;
  }
  return $outer4;
}
//Asume that is n*n square
function fftshift2d(&$data,$xdim,$ydim)
{
  $len=count($data);
  $cody=array_pad(array(),$len,0);
  $xshift=$xdim/2;
  $yshift=$ydim/2;
  for ($x = 0; $x < $xdim; $x++)
  {
    $outx=($x+$xshift)%$xdim;
    for ($y = 0; $y < $ydim; $y++)
    {
      $outy=($y+$yshift)%$ydim;
      $cody[$outx+$xdim*$outy]=$data[$x+$xdim*$y];
    }
  }
  return $cody;
}
//this function process each of the section of the array 1 PLANE AT TIME
function generatePlate($theX,$theY,$side)
{
  $square2=pow($side,2);
  $center=floor($side/2);
  $flat=array_pad(array() ,$square2,0);
  for($indexIm=0;$indexIm<count($theX);$indexIm++)
  {
    $ix=$center+(int)$theX[$indexIm];
    $ky=$center+(int)$theY[$indexIm];
    $position=($side*$ix)+$ky;
    //echo $position."</br>";
    $flat[$position]=1;
  }
  return $flat;
}
function fresnelnu($pref0,$M,$N,$dx0,$z,$lamb)
{
  // NOTE: fo and m*n must be the same size
  if($z<0.1)
  {
      $z=1;
  }
  $k=(2*M_PI)/$lamb;
  //the x0 optical filter
  $x0=x0Filter($M,$N,$dx0);
  $normalize=new Complex($lamb*$z,0);
  //the y0 optical filter
  $previousy0=transposeShift($x0,$N);
  $y0=array_values($previousy0);
  $f0=convertToComplex($pref0);
  //f0 we can asume as being a complex array
  //g=f0.*exp(j*0.5*k*(x0.^2+y0.^2)/z); this expression we can handle as complex
  $secondKernel=array();
  for($preCharge=0;$preCharge<count($x0);$preCharge++)
  {
    $firstKernel=0.5*$k*(pow($x0[$preCharge],2)+pow($y0[$preCharge],2))/$z;
    $kernel_0=cos($firstKernel);
    $kernel_1=-sin($firstKernel);
    $t = new Complex($kernel_0, $kernel_1);
    $t->Multiply($f0[$preCharge], $t);
    $secondKernel[]=$t;
  }
  //G=fftshift(fft2(g));
  $f02=d2FFT($secondKernel,$M,$N);
  $f03=fftshift2d($f02,$M,$N);
  // we get the adjust of dx1
  $du=1/($M*$dx0);
  $dx1=$lamb*$z*$du;
  //the x1 optical filter
  $x1=x0Filter($M,$N,$dx1);
  //the y1 optical filter
  $previousy1=transposeShift($x1,$N);
  $y1=array_values($previousy1);
  //f1=G.*exp(i*0.5*k*(x1.^2+y1.^2)/z);
  $fourthKernel=array();
  for($charge=0;$charge<count($x1);$charge++)
  {
    $thirdKernel=0.5*$k*(pow($x1[$charge],2)+pow($y1[$charge],2))/$z;
    $kernel_2=cos($thirdKernel);
    $kernel_3=-sin($thirdKernel);
    $tk = new Complex($kernel_2, $kernel_3);
    $tk->Multiply($f03[$charge], $tk);
    $tk->normalDivide($normalize, $tk);
    $fourthKernel[]=$tk;
  }
  return $fourthKernel;
}
function normalizeComplex($theComplex)
{
  $divideby=count($theComplex);
  $cut=new Complex($divideby,0);
  $preface=array();
  for($pre=0;$pre<$divideby;$pre++)
  {
    $tr=$theComplex[$pre];
    $tr->divide($cut, $tr);
    $preface[]=$tr;
  }
  return $preface;
}
function multiplyArrComplex($a,$b)
{
  $preface=array();
  for($pre=0;$pre<count($a);$pre++)
  {
    //copy all
    $h1=$a[$pre];
    $h2=$b[$pre];
    $tr = $h1;
    $tr->Multiply($h2, $tr);
    $preface[]=$tr;
  }
  return $preface;
}
// utitlities for matrix************
function unitaryComplexAddition($partA,$partB)
{
    $dst=new Complex(0,0);
    $dst->real = $partA->real + $partB->real;
    $dst->imaginary = $partA->imaginary + $partB->imaginary;
    return $dst;
}
function unitaryComplexMultiplication($partA,$partB)
{
    $rea=($partA->real * $partB->real) - ($partA->imaginary * $partB->imaginary);
    $ima=($partA->real * $partB->imaginary) + ($partA->imaginary * $partB->real);
    $dst=new Complex($rea,$ima);
    return $dst;
}
function complexMultiplicationMatrix($matA,$matB,$side)
{
  $theVoid=new Complex(0,0);
  //$theVoid=0;
  $munch=array_pad(array(),$side*$side,$theVoid);
  for ($i = 0; $i < $side; $i++)
  {
      for($j = 0; $j < $side; $j++)
      {
          $sum = new Complex(0,0);
            for ($k = 0; $k < $side; $k++)
            {
                 $partA=$matA[($i * $side) + $k];
                 $partB=$matB[($k * $side) + $j];
                 $prev4=unitaryComplexMultiplication($partA,$partB);
                 $sum=unitaryComplexAddition($sum,$prev4);
            }
            $munch[$i * $side + $j] = $sum;
        }
  }
  return $munch;
}
// utitlities for matrix************
//******NOTICE:must be same size both arguments!! padd with zeros and change panels as fftShift
//after
function convolution2($thex,$they,$side)
{
  $signalx=FFT($thex);
  $signaly=FFT($they);
  $both=multiplyArrComplex($signaly,$signalx);
  $smooth=IFFT($both);
  //need normalize vector
  $smooth2=normalizeComplex($smooth);
  return $smooth2;
}
// electro-Chemical potential library
function getAtomScatt($atomicNumber,$scattFile)
{
  $handle = fopen($scattFile,'r');
  $row = 0;
  $arr = array();
  while($line = fgetcsv($handle,1000,";"))
  {
    $arr[] = $line;
  }
  $integrate1=$arr[$atomicNumber][0];
  $integrate2=$arr[$atomicNumber][1];
  $integrate3=$arr[$atomicNumber][2];
  $integrate4=$arr[$atomicNumber][3];
  $integrate5=$arr[$atomicNumber][4];
  $integrate6=$arr[$atomicNumber][5];
  $integrate7=$arr[$atomicNumber][6];
  $integrate8=$arr[$atomicNumber][7];
  $integrate9=$arr[$atomicNumber][8];
  $integrate10=$arr[$atomicNumber][9];
  $integrate11=$arr[$atomicNumber][10];
  $integrate12=$arr[$atomicNumber][11];
  $integrate=array($integrate1,$integrate2,$integrate3,$integrate4,
  $integrate5,$integrate6,$integrate7,$integrate8,$integrate9,
  $integrate10,$integrate11,$integrate12);
  return $integrate;
}
// dt and dx must be 1 (discrete values)
function erf($ll, $ul, $t, $dt, $dx)
{
     $val = 0;
     for($i = $ll; $i <= $ul; $i+=$dx)
{
          $val +=  exp(-pow($t,2)) * $dt;
     }
     return (2/sqrt(M_PI)) * $val;
}
function getSizePlate($theX,$theY)
{
   //We asume that x and y array are all  with the same Z
  $per1=abs(min($theX));
  $per2=abs(min($theY));
  $per3=abs(max($theX));
  $per4=abs(max($theY));
  $pers=array($per1,$per2,$per3,$per4);
  $biggest=max($pers);
  unset($pers);
  //get side of the image
  $side=$biggest*4;
  return $side;
}
//****************************************************************
//IMPORTANT: remember to add the complex library to return the
//array of complex as index of Chemical bright to each atom
//in 2 DIMENSION
//****************************************************************
function atomicPotential80($l,$m,$side,$currentZ,$secondLastZ,$lastZ,
$atomicNumber,$lam)
{
  //this function is in adition with the initial set,
  //to get the electro Chemical Potential,before the visual process
  $center=floor($side/2);
  $theVoid=new Complex(0,0);
  $flatChem=array_pad(array() ,$side*$side,$theVoid);
  $atomSpecs=getAtomScatt($atomicNumber,'scatteringTables10.csv');
  //atomicNumber,element,ya1,yb1,ya2,yb2,ya3,yb3,ya4,yb4,ya5,yb5
  $ai=array(0,0,0,0,0);
  $bi=array(0,0,0,0,0);
  $ai[0]=$atomSpecs[2];
  $ai[1]=$atomSpecs[3];
  $ai[2]=$atomSpecs[4];
  $ai[3]=$atomSpecs[5];
  $ai[4]=$atomSpecs[6];
  $bi[0]=$atomSpecs[7];
  $bi[1]=$atomSpecs[8];
  $bi[2]=$atomSpecs[9];
  $bi[3]=$atomSpecs[10];
  $bi[4]=$atomSpecs[11];
  //echo $ya1."---".$yb1."---".$ya2."---".$yb2."---".$ya3."---".$yb3."</br>";
  //echo $ya4."---".$yb4."---".$ya5."---".$yb5."---"."</br>";
  $planckConstant=6.626068e-34;
  $planck2=pow($planckConstant,2);
  $massElectron=9.10938188e-31;
  $preb=pow(M_PI,2);
  $particleBand=(-$lam)/((2*M_PI*$massElectron*$lam)/$planck2);
  $pseudoPos=0;
  for($indexIm1=0;$indexIm1<count($l);$indexIm1++)
  {
    for($indexIm2=0;$indexIm2<count($m);$indexIm2++)
    {
        $alpha=pow($l[$indexIm1],2)+pow($m[$indexIm2],2);
        for($coeff=0;$coeff<5;$coeff++)
        {
            $first=($ai[$coeff]/$bi[$coeff]);
            $second=(-$preb*$alpha)/$bi[$coeff];
            $third=sqrt((2*$preb)/$bi[$coeff]);
            $fourth=erf($currentZ, $lastZ, $third,1,1);
            $fifth=erf($currentZ, $secondLastZ, $third,1,1);
            $sixth=$fourth-$fifth;
            $pseudoPos+=$first*exp($second)*$sixth;
        }
        $electronicPotential=$particleBand*$pseudoPos;
        $position=($center*$l[$indexIm1])+$m[$indexIm2];
        $flatChem[$position]=new Complex($electronicPotential,0);
    }
  }
  return $flatChem;
}
//identity Matrix
function identityMatrix($side)
{
 $theVoid=new Complex(0,0);
 $identity=new Complex(1,0);
 $total=array_pad(array(),$side*$side,$theVoid);
 $counter=0;
 for($y=0;$y<$side;$y++)
    {
      for($x=0;$x<$side;$x++)
      {
          if($x==$y)
          {
             $total[$counter]=$identity;
          }
          $counter++;
      }
    }
    return $total;
}
// counter absolute points
function convertDataToMax($data)
{
  //max of the data will define the pixel
  $biggestIntensity=max($data);
  $intensities=array();
	$stage=0;
  //over all the data
  while ($stage < count($data))
  {
    //make the center
    $based1=($data[$stage]*100)/$biggestIntensity;
    $based2=$identity=new Complex($based1*100,0);
    $intensities[]=$based2;
    $stage++;
  }
  return $intensities;
}
//255 is white in rgb
function convertDataToColour($data)
{
  //max of the data will define the pixel
  $biggestIntensity=max($data);
  $intensities=array();
	$stage=0;
  //over all the data
  while ($stage < count($data))
  {
    //make the center
    $based1=$data[$stage]/$biggestIntensity;
    $based2=$based1*100;
    $intensities[]=(int)$based2;
    $stage++;
  }
  return $intensities;
}
//this function creates an array with 100 colours
//using the image allocate
function createAllColours($imageToProcess)
{
   //last one is white
   $allColours=array_pad(array(),255,0);
   for($r=0;$r<255;$r++)
   {
       $allColours[$r]=imagecolorallocate($imageToProcess,$r,$r,$r);
   }
   return $allColours;
}
?>
