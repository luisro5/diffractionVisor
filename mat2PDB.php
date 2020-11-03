<?php
/**
 *
 *
 * This source code is licensed under the MIT license found in the
 * MIT-LICENSE file in the root directory of this source tree.
 *
 *
 */
/*
COLUMNS
DATA TYPE
FIELD
DEFINITION
-------------------------------------------------------------------------------------
1 - 6 Record name "ATOM "
7 - 11 Integer serial Atom serial number.
13 - 16 Atom name Atom name.
17 Character altLoc Alternate location indicator.
18 - 20 Residue name resName Residue name.
22 Character chainID Chain identifier.
23 - 26 Integer resSeq Residue sequence number.
27 AChar iCode Code for insertion of residues.
31 - 38 Real(8.3) x Orthogonal coordinates for X in Angstroms.
39 - 46 Real(8.3) y Orthogonal coordinates for Y in Angstroms.
47 - 54 Real(8.3) z Orthogonal coordinates for Z in Angstroms.
55 - 60 Real(6.2) occupancy Occupancy.
61 - 66 Real(6.2) tempFactor Temperature factor.
77 - 78 LString(2) element Element symbol, right-justified.
79 - 80 LString(2) charge Charge on the atom.
*/
function cellFill($data,$numberCharacters)
{
  //fill the data with spaces depending on the field
  $newfill=$data;
  $filler=" ";
  $old=strlen($newfill);
  if($old<$numberCharacters)
  {
    $counterOfChar=$old;
    while($counterOfChar<$numberCharacters)
    {
      $newfill.=$filler;
      $counterOfChar++;
    }
  }
  return $newfill;
}
function cutter($number)
{
  if($number<0.01)
  {
    return 0;
  }
  else
  {
    return $number;
  }
}
function makeLine($index,$element,$theX,$theY,$theZ)
{
  $futureFeaturespdb1="               ";
  $futureFeaturespdb2="                    ";
  $occu="1.000";
  $index2=strval($index);
  $theXbis=strval(cutter($theX));
  $theYbis=strval(cutter($theY));
  $theZbis=strval(cutter($theZ));
  $chamber1=cellFill("ATOM",6);
  $chamber2=cellFill($index2,4);
  $chamber3=cellFill($element,3);
  $chamber4=cellFill($theXbis,7);
  $chamber5=cellFill($theYbis,7);
  $chamber6=cellFill($theZbis,7);
  $chamber7=cellFill($occu,5);
  $txtcoord = $chamber1.$chamber2.$chamber3.$futureFeaturespdb1.$chamber4.$chamber5.$chamber6.$chamber7.$futureFeaturespdb2.PHP_EOL;
  return $txtcoord;
}
function convertElementText($atomicNumber)
{
  //this function converts the atomic number to the element
  $elemental="";
  switch ($atomicNumber)
  {
    case 1:
    $elemental="H";
    break;
    case 2:
    $elemental="He";
    break;
    case 3:
    $elemental="Li";
    break;
    case 4:
    $elemental="Be";
    break;
    case 5:
    $elemental="B";
    break;
    case 6:
    $elemental="C";
    break;
    case 7:
    $elemental="N";
    break;
    case 8:
    $elemental="O";
    break;
    case 9:
    $elemental="F";
    break;
    case 10:
    $elemental="Ne";
    break;
    case 11:
    $elemental="Na";
    break;
    case 12:
    $elemental="Mg";
    break;
    case 13:
    $elemental="Al";
    break;
    case 14:
    $elemental="Si";
    break;
    case 15:
    $elemental="P";
    break;
    case 16:
    $elemental="S";
    break;
    case 17:
    $elemental="Cl";
    break;
    case 18:
    $elemental="Ar";
    break;
    case 19:
    $elemental="K";
    break;
    case 20:
    $elemental="Ca";
    break;
    case 21:
    $elemental="Sc";
    break;
    case 22:
    $elemental="Ti";
    break;
    case 23:
    $elemental="V";
    break;
    case 24:
    $elemental="Cr";
    break;
    case 25:
    $elemental="Mn";
    break;
    case 26:
    $elemental="Fe";
    break;
    case 27:
    $elemental="Co";
    break;
    case 28:
    $elemental="Ni";
    break;
    case 29:
    $elemental="Cu";
    break;
    case 30:
    $elemental="Zn";
    break;
    case 31:
    $elemental="Ga";
    break;
    case 32:
    $elemental="Ge";
    break;
    case 33:
    $elemental="As";
    break;
    case 34:
    $elemental="Se";
    break;
    case 35:
    $elemental="Br";
    break;
    case 36:
    $elemental="Kr";
    break;
    case 37:
    $elemental="Rb";
    break;
    case 38:
    $elemental="Sr";
    break;
    case 39:
    $elemental="Y";
    break;
    case 40:
    $elemental="Zr";
    break;
    case 41:
    $elemental="Nb";
    break;
    case 42:
    $elemental="Mo";
    break;
    case 43:
    $elemental="Tc";
    break;
    case 44:
    $elemental="Ru";
    break;
    case 45:
    $elemental="Rh";
    break;
    case 46:
    $elemental="Pd";
    break;
    case 47:
    $elemental="Ag";
    break;
    case 48:
    $elemental="Cd";
    break;
    case 49:
    $elemental="In";
    break;
    case 50:
    $elemental="Sn";
    break;
    case 51:
    $elemental="Sb";
    break;
    case 52:
    $elemental="Te";
    break;
    case 53:
    $elemental="I";
    break;
    case 54:
    $elemental="Xe";
    break;
    case 55:
    $elemental="Cs";
    break;
    case 56:
    $elemental="Ba";
    break;
    case 57:
    $elemental="La";
    break;
    case 58:
    $elemental="Ce";
    break;
    case 59:
    $elemental="Pr";
    break;
    case 60:
    $elemental="Nd";
    break;
    case 61:
    $elemental="Pm";
    break;
    case 62:
    $elemental="Sm";
    break;
    case 63:
    $elemental="Eu";
    break;
    case 64:
    $elemental="Gd";
    break;
    case 65:
    $elemental="Tb";
    break;
    case 66:
    $elemental="Dy";
    break;
    case 67:
    $elemental="Ho";
    break;
    case 68:
    $elemental="Er";
    break;
    case 69:
    $elemental="Tm";
    break;
    case 70:
    $elemental="Yb";
    break;
    case 71:
    $elemental="Lu";
    break;
    case 72:
    $elemental="Hf";
    break;
    case 73:
    $elemental="Ta";
    break;
    case 74:
    $elemental="W";
    break;
    case 75:
    $elemental="Re";
    break;
    case 76:
    $elemental="Os";
    break;
    case 77:
    $elemental="Ir";
    break;
    case 78:
    $elemental="Pt";
    break;
    case 79:
    $elemental="Au";
    break;
    case 80:
    $elemental="Hg";
    break;
    case 81:
    $elemental="Tl";
    break;
    case 82:
    $elemental="Pb";
    break;
    case 83:
    $elemental="Bi";
    break;
    case 84:
    $elemental="Po";
    break;
    case 85:
    $elemental="At";
    break;
    case 86:
    $elemental="Rn";
    break;
    case 87:
    $elemental="Fr";
    break;
    case 88:
    $elemental="Ra";
    break;
    case 89:
    $elemental="Ac";
    break;
    case 90:
    $elemental="Th";
    break;
    case 91:
    $elemental="Pa";
    break;
    case 92:
    $elemental="U";
    break;
    case 93:
    $elemental="Np";
    break;
    case 94:
    $elemental="Pu";
    break;
    case 95:
    $elemental="Am";
    break;
    case 96:
    $elemental="Cm";
    break;
    case 97:
    $elemental="Bk";
    break;
    case 98:
    $elemental="Cf";
    break;
  }
  return $elemental;
}
//create the output structure to pdb2mat
function writerPDB($thex,$they,$thez,$ele)
{
  $t=time();
  $default=date("Y-m-d-h_m_s",$t);
  $name=$default.".PDB";
  $myfile = fopen($name, "w+") or die("Unable to open file!");
  $counter=0;
      while($k<count($thez))
      {
        $txt=makeLine($counter+1,$ele,$thex[$k],$they[$k],$thez[$k]);
        //echo $thex[$k]."----".$they[$k]."----".$thex[$k]."</br>";
        //echo $txt."</br>";
        fwrite($myfile, $txt);
        $counter++;
        $k++;
      }

  fclose($myfile);
}
?>
