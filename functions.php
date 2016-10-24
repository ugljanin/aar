<?php
if(!defined('Functions')){die('You are not authorised to access this');}
function paginacija($strana,$ukupnostrana, $prelink,$postlink)
{
	global $fraza;
	if($strana-3<=1)
	$triprije=1;
	else
	$triprije=$strana-3;
	$triposle=$strana+3;
	$dvijeprijezadnje=$ukupnostrana-2;
	$triprijezadnje=$ukupnostrana-3;

	if($strana>1)
	{
		$prev=($strana-1);
		echo "<li><a href='".$prelink.$prev.$postlink."'> < </a></li>";
	}
	if($strana>4)
	{
		echo "<li><a href='".$prelink."1".$postlink."'>1</a></li>";
	}
	for($i=$triprije;$i<=$triposle;$i++)
	{

		if(($strana)==$i)
		{
			echo "<li class=\"active\"><a href=\"#\">$i</a></li>";
			if($i==$ukupnostrana)
			{
			$zadnja=$i;
			break;
			}
		}
		else if($i<=$ukupnostrana)
		{
			echo "<li><a href='".$prelink.$i.$postlink."'>".$i."</a></li>";
		}

	}
	if($strana<$triprijezadnje)
	{
		echo "<li><a href='".$prelink.$ukupnostrana.$postlink."'>".$ukupnostrana."</a></li>";
	}
	//pravi sledeci link
	if($strana<$ukupnostrana)
	{
		$next=($strana+1);
		echo "<li><a href='".$prelink.$next.$postlink."'> > </a></li>";
	}
}
function pager($strana,$ukupnostrana, $prelink,$postlink)
{
	global $fraza;

	$dvijeprijezadnje=$ukupnostrana-2;
	$triprijezadnje=$ukupnostrana-3;

	if($strana==1)
	{
		$prev=($strana-1);
		echo '<li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Starije</a></li>';
	}
	else if($strana>1)
	{
		$prev=($strana-1);
		echo '<li class="previous"><a href="'.$prelink.$prev.$postlink.'"><span aria-hidden="true">&larr;</span> Starije</a></li>';
	}

	//pravi sledeci link
	if($strana<$ukupnostrana)
	{
		$next=($strana+1);
		echo '<li class="next"><a href="'.$prelink.$next.$postlink.'">Novije <span aria-hidden="true">&rarr;</span></a></li>';
	}
	else if($strana==$ukupnostrana)
	{
		$next=($strana+1);
		echo '<li class="next disabled"><a href="#">Novije <span aria-hidden="true">&rarr;</span></a></li>';
	}
}
function daLiJeBroj($broj)
{
	if(preg_match("/^[0-9]+$/", $broj) == 1)
		return true;
	else
		return false;
}
function daLiJeNovac($broj)
{
	if(preg_match("/^-?[0-9]+\.[0-9]{2}$/", $broj) == 1)
		return true;
	else
		return false;
}
function daLiJeProcenat($broj)
{
	if((preg_match("/^[0-9]+$/", $broj) == 1)&&$broj<='100'&&$broj>='0')
		return true;
	else
		return false;
}
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {

	$dates = array();
	$current = strtotime( $first );
	$last = strtotime( $last );

	while( $current <= $last ) {

		$dates[] = date( $format, $current );
		$current = strtotime( $step, $current );
	}

	return $dates;
}
function redirect($url) {

    echo "<script language=\"JavaScript\">\n";
    echo "<!-- hide from old browser\n\n";

    echo "window.location = \"" . $url . "\";\n";

    echo "-->\n";
    echo "</script>\n";

    return true;
}
function nazad() {

    echo "<script language=\"JavaScript\">\n";
    echo "<!-- hide from old browser\n\n";

    echo "window.history.back();\n";


    echo "-->\n";
    echo "</script>\n";

    return true;
}

function postaviDozvole($svimoduli, $dozvole, $glavnimoduli) {
    $data = array();

	/*
	for ($ii = 0, $n = count($glavnimoduli); $ii < $n; $ii++)
	{
		$data[$glavnimoduli[$ii]["kodmodula"]][parent]='NEMA';
	}
	*/
    for ($i = 0, $c = count($svimoduli); $i < $c; $i++)
	{
        $row = array();
        for ($j = 0, $c2 = count($dozvole); $j < $c2; $j++)
		{
            if ($dozvole[$j]["modulkod"] == $svimoduli[$i]["kodmodula"])
			{
                if (autorizuj($dozvole[$j]["kreiranje"]) || autorizuj($dozvole[$j]["izmena"]) || autorizuj($dozvole[$j]["brisanje"]) || autorizuj($dozvole[$j]["pregled"]))
				{
                    $row["parent"] = $svimoduli[$i]["parent"];
                    $row["imemodula"] = $svimoduli[$i]["imemodula"];
                    $row["linkmodula"] = $svimoduli[$i]["linkmodula"];
                    $row["ikonica"] = $svimoduli[$i]["ikonica"];

                    $row["kreiranje"] = $dozvole[$j]["kreiranje"];
                    $row["izmena"] = $dozvole[$j]["izmena"];
                    $row["brisanje"] = $dozvole[$j]["brisanje"];
                    $row["pregled"] = $dozvole[$j]["pregled"];

					//ako je glavna kategorija
					if($svimoduli[$i]["parent"]=='NEMA')
					{
						$data[$svimoduli[$i]["kodmodula"]] = $row;
						//echo $row["imemodula"].$row["kodmodula"].$row["parent"];
					}
					//data[OPCIJA]=ROW
					else //ako ima podkategorija
					{
						$data[$svimoduli[$i]["parent"]]["stavke"][$svimoduli[$i]["kodmodula"]] = $row;
					}
                }
            }
        }

    }
	/*
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit();
		*/
    return $data;
}

function autorizuj($modul) {
    return $modul == "da" ? TRUE : FALSE;
}
function autorizacija($kljucnarec,$provera)
{
	$neka=getkeypath($_SESSION,$kljucnarec);
	$ukupno=count($neka);
	if($ukupno=='2')
		return $_SESSION[$neka[$ukupno-1]][$neka[$ukupno-2]][$provera] == "da" ? TRUE : FALSE;
	else if($ukupno=='3')
		return $_SESSION[$neka[$ukupno-1]][$neka[$ukupno-2]][$neka[$ukupno-3]][$provera] == "da" ? TRUE : FALSE;
	else if($ukupno=='4')
		return $_SESSION[$neka[$ukupno-1]][$neka[$ukupno-2]][$neka[$ukupno-3]][$neka[$ukupno-4]][$provera] == "da" ? TRUE : FALSE;
}

function getkeypath($arr, $lookup)
{
    if (array_key_exists($lookup, $arr))
    {
        return array($lookup);
    }
    else
    {
        foreach ($arr as $key => $subarr)
        {
            if (is_array($subarr))
            {
                $ret = getkeypath($subarr, $lookup);

                if ($ret)
                {
                    $ret[] = $key;
                    return $ret;
                }
            }
        }
    }

    return null;
}
function checkuser()
{
	global $status;
	global $conn;
	$sql="select * from korisnici where korisnikid='".$_SESSION[user_id]."' and status='Blokiran'";
	$result=mysqli_query($conn,$sql);
	$broj=mysqli_num_rows($result);

	if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == ""||$broj!='0') {
		// not logged in send to login page
		session_destroy();
		redirect("index.php");
	}
	$status = FALSE;
}
function checkobjekat($objekatid)
{
	global $conn;
	$sql="select korisnici.ulogakod from korisnici, korisnici_objekti where korisnici.korisnikid=korisnici_objekti.korisnikid and korisnici.korisnikid='$_SESSION[user_id]' and korisnici_objekti.objekatid='$objekatid'";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)=='0')
	{
		$podnaslov = "Zabranjen pristup";
		include 'header.php';
		echo "Nemate dozvolu za pristup podacima vezanim za ovaj objekat";
		exit();
	}
}
function getObjekatId()
{
	global $conn;
	$sql="select korisnici.ulogakod,korisnici_objekti.objekatid from korisnici, korisnici_objekti where korisnici.korisnikid=korisnici_objekti.korisnikid and korisnici.korisnikid='$_SESSION[user_id]'";
	$result=mysqli_query($conn,$sql);
	$korisnik=mysqli_fetch_array($result,MYSQLI_ASSOC);

	$objekatid=$korisnik[objekatid];

	return $objekatid;
}
function createThu2mbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
{
    $path = $uploadDir . '/' . $image_name;

    $mime = getimagesize($path);

    if($mime['mime']=='image/png'){ $src_img = imagecreatefrompng($path); }
    if($mime['mime']=='image/jpg'){ $src_img = imagecreatefromjpeg($path); }
    if($mime['mime']=='image/jpeg'){ $src_img = imagecreatefromjpeg($path); }
    if($mime['mime']=='image/pjpeg'){ $src_img = imagecreatefromjpeg($path); }

    $old_x          =   imageSX($src_img);
    $old_y          =   imageSY($src_img);

    if($old_x > $old_y)
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $old_y*($new_height/$old_x);
    }

    if($old_x < $old_y)
    {
        $thumb_w    =   $old_x*($new_width/$old_y);
        $thumb_h    =   $new_height;
    }

    if($old_x == $old_y)
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $new_height;
    }

    $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);


    // New save location
    $new_thumb_loc = $moveToDir . $image_name;

    if($mime['mime']=='image/png'){ $result = imagepng($dst_img,$new_thumb_loc,8); }
    if($mime['mime']=='image/jpg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
    if($mime['mime']=='image/jpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
    if($mime['mime']=='image/pjpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }

    imagedestroy($dst_img);
    imagedestroy($src_img);

    return $result;
}
function getTopParentId($id)
{
	$query="select * from strana where id='".$id."'";
	$result=mysql_query($query);
	$strana=mysql_fetch_array($result);
	$mojid=$strana['id'];
	if($strana['parent']==0)
	{
		return $mojid;
	}
	else
	{
		return getTopParentId($strana['parent']);
	}
}
function getTopKatParentId($id)
{
	$query="select * from kat where id='".$id."'";
	$result=mysql_query($query);
	$strana=mysql_fetch_array($result);
	$mojid=$strana['id'];
	if($strana['parent']==0)
	{
		return $mojid;
	}
	else
	{
		return getTopParentId($strana['parent']);
	}
}
function getTopKatParentIme($id)
{
	$query="select * from kat where id='".$id."'";
	$result=mysql_query($query);
	$strana=mysql_fetch_array($result);
	$mojid=$strana['ime'];
	if($strana['parent']==0)
	{
		return $mojid;
	}
	else
	{
		return getTopParentId($strana['parent']);
	}
}
function getKatidFromRewrite($rewrite)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from strana
             where rewrite = '$rewrite'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'id');
   return $result;
}
function getParentFromStranaId($id)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from strana
             where id = '$id'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'parent');
   return $result;
}
function getKatimeFromKatid($catid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from strana
             where id = $catid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'ime');
   return $result;
}
function to_money($string)
  {

   $Negative = 0;

   // Make sure the number is not negative .
    if(preg_match("/^\-/",$string))
    {
     $Negative = 1;
     $string = preg_replace("|\-|","",$string);
    }

// Make sure there aren't already commas in the string.
   $string = preg_replace("|\,|","",$string);

   $Full = split("[\.]",$string);

   $Count = count($Full);

   if($Count > 1)
   {
    $First = $Full[0];
    $Second = $Full[1];
     $NumDec = strlen($Second);
      if($NumDec == 2)
       {
           //do nothing already at correct length
       }
      else if($NumDec < 2)
       {
           //add an extra zero to the end
           $Second = $Second . "0";
       }
      else if($NumDec > 2)
       {
           // Round off the rest.
           $Temp = substr($Second,0,3);
           $Rounded = round($Temp,-1);
           $Second = substr($Rounded,0,2);

       }

   }
   else
   {
    $First = $Full[0];
    $Second = "00";
   }

  $length = strlen($First);

  if( $length <= 3 )
    {
     //To Short to add a comma combine the first part and the second.
    $string = $First . "." . $Second;

    if($Negative == 1)
     {
      $string = "-" . $string;
     }

    return $string;
    }
  else
    {
    $loop = intval( ( $length / 3 ) );
    $section_length = -3;
    for( $i = 0; $i < $loop; $i++ )
      {
      $sections[$i] = substr( $First, $section_length, 3 );
      $section_length = $section_length - 3;
      }

    $stub = ( $length % 3 );
    if( $stub != 0 )
      {
      $sections[$i] = substr( $First, 0, $stub );
      }
    $Done = implode( ",", array_reverse( $sections ) );
    $Done = $Done . "." . $Second;

    if($Negative == 1)
     {
      $Done = "-" . $Done;
     }
    return  $Done;
    }
  }
function GetParentRednibroj($rewrite)
{
	$sql="select * from strana where rewrite='$rewrite'";
	$result=mysql_query($sql);
	$s=mysql_fetch_array($result);
	$parent_old=$s['parent'];
	$rewrite_old=$s['rewrite'];
	$parentrewrite=$s['sortiranje'];
 	if($parent_old!='0')
	{
	    $sql1="select * from strana where id=$parent_old";
		$result1=mysql_query($sql1);
		$s1=mysql_fetch_array($result1);
		$parent_old1=$s1['parent'];
		$rewrite_old1=$s1['rewrite'];
        return GetParentRednibroj($rewrite_old1);
	}
	else
	{
		return $parentrewrite;
	}
}

function putanjamodula($kodmodula,$ikonica,$link,$ime,$id)
{
	global $conn;
	$query="select * from moduli where kodmodula ='".$kodmodula."'";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)!=0)
	{
			while($podmeni=mysqli_fetch_array($result,MYSQLI_ASSOC))
			{
				$id++;
				$ikonica=$podmeni[ikonica];
				$kodmodula=$podmeni[parent];
				$ikonice.=$podmeni[ikonica].",";
				$ime.=$podmeni['imemodula'].",";
				putanjamodula($kodmodula,$ikonica,$ikonice,$ime,$id);

			}
	}
	else
	{
		$ikonicamodula=explode(",",$ikonice);
		$ime2=explode(",",$ime);
		$id--;
		for($id;$id>=0;$id--)
		{
			$adresa.=$link2[$id].'/';
			print '<li>';
			echo '<i class="'.$ikonicamodula[$id].'"></i>';
			print $ime2[$id];
			print "</li>";
		}
	}

}
function rootmodula($uporedimodul,$kodmodula,$ime,$id)
{
	global $conn;
	$query="select * from moduli where kodmodula ='".$kodmodula."'";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)!=0)
	{
			while($podmeni=mysqli_fetch_array($result,MYSQLI_ASSOC))
			{
				$id++;
				$ikonica=$podmeni[ikonica];
				$kodmodula=$podmeni[parent];
				$ime[]=$podmeni['imemodula'];
				rootmodula($uporedimodul,$kodmodula,$ime,$id);

			}
	}
	else
	{
		$id--;
		$kod=$ime[$id];
		if($kod==$uporedimodul)
			echo 'active';

	}
}
function kodmodula($uporedimodul,$kodmodula)
{
	global $conn;
	$query="select * from moduli where kodmodula ='".$kodmodula."'";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)!=0)
	{
			$podmeni=mysqli_fetch_array($result,MYSQLI_ASSOC);
			$id++;
			if($podmeni[imemodula]==$uporedimodul)
				echo 'active';

	}
}

function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir,$dodatak)
{
    $path = $uploadDir . '/' . $image_name;

    $mime = getimagesize($path);

    if($mime['mime']=='image/png'){ $src_img = imagecreatefrompng($path); }
    if($mime['mime']=='image/jpg'){ $src_img = imagecreatefromjpeg($path); }
    if($mime['mime']=='image/jpeg'){ $src_img = imagecreatefromjpeg($path); }
    if($mime['mime']=='image/pjpeg'){ $src_img = imagecreatefromjpeg($path); }

    $old_x          =   imageSX($src_img);
    $old_y          =   imageSY($src_img);
/*
    if($old_x > $old_y)
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $old_y*($new_height/$old_x);
    }

    if($old_x < $old_y)
    {
        $thumb_w    =   $old_x*($new_width/$old_y);
        $thumb_h    =   $new_height;
    }

    if($old_x == $old_y)
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $new_height;
    }
*/
	$x_ratio = $new_width / $old_x;
	$y_ratio = $new_height / $old_y;

	if ( ($old_x <= $new_width) && ($old_y <= $new_height) ) {
	$thumb_w = $old_x;
	$thumb_w=$thumb_w-1;
	$thumb_h = $old_y;
	$thumb_h=$thumb_h-1;
	}
	else if (($x_ratio * $old_y) < $new_height) {
	$thumb_h = ceil($x_ratio * $old_y);
	$thumb_h=$thumb_h-1;
	$thumb_w = $new_width;
	$thumb_w=$thumb_w-1;
	}
	else {
	$thumb_w = ceil($y_ratio * $old_x);
	$thumb_w=$thumb_w-1;
	$thumb_h = $new_height;
	$thumb_h=$thumb_h-1;
	}

    $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);


    // New save location
	$niz=explode(".",$image_name);

	if($dodatak)
    $new_thumb_loc = $moveToDir . $niz[0]."-".$dodatak.".".$niz[1];
	else
    $new_thumb_loc = $moveToDir . $niz[0].".".$niz[1];

    if($mime['mime']=='image/png'){ $result = imagepng($dst_img,$new_thumb_loc,8); }
    if($mime['mime']=='image/jpg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
    if($mime['mime']=='image/jpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
    if($mime['mime']=='image/pjpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }

    imagedestroy($dst_img);
    imagedestroy($src_img);

    return $result;
}
function unikatni($datum)
{
	$d=date ("d",$datum);
	$m=date ("m",$datum);
	$y=date ("Y",$datum);
	//$t=time();
	$t=mktime(0,0,0,$m,$d,$y);
	$dmt=$t+$d+$m+$y;
	$ran= rand(0,10000000);
	$dmtran= $dmt+$ran;
	$un=  uniqid();
	$dmtun = $dmt.$un;
	$mdun = md5($dmtran.$un);
	return $mdun;
	//$sort=substr($mdun, 16); // if you want sort length code.
}
function skenirajDirektorijumPoEkstenziji($rootDir, $allowext, $allData=array()) {
    $dirContent = scandir($rootDir);
    foreach($dirContent as $key => $content) {
        $path = $rootDir.'/'.$content;
        $ext = substr($content, strrpos($content, '.') + 1);
        if(in_array($ext, $allowext)) {
            if(is_file($path) && is_readable($path)) {
                $allData[] = $path;
            }elseif(is_dir($path) && is_readable($path)) {
                // recursive callback to open new directory
                $allData = scanDirectories($path, $allData);
            }
        }
    }
    return $allData;
}
function scanDirectories($rootDir, $allowext, $allData=array()) {
    $dirContent = scandir($rootDir);
    foreach($dirContent as $key => $content) {
        $path = $rootDir.'/'.$content;
        //$ext = substr($content, strrpos($content, '.') + 1);
		//prikazuje sve lijevo od tacke i oduzima dva broja poslednja koja oznacavaju broj slike
        $ext = substr($content,0, strrpos($content, '.') - 2);

        if(in_array($ext, $allowext)) {
            if(is_file($path) && is_readable($path)) {
                $allData[] = $path;
            }elseif(is_dir($path) && is_readable($path)) {
                // recursive callback to open new directory
                $allData = scanDirectories($path, $allData);
            }
        }
    }
    return $allData;
}
function linkovanje($meniid,$rewrite,$link,$id)
{

	$query="select * from strana where id='".$meniid."'";
	$result=mysql_query($query);
	if(mysql_num_rows($result)!=0)
	{
			while($podmeni=mysql_fetch_array($result))
			{
				$id++;
				$rewrite=$podmeni[rewrite];
				$meniid=$podmeni[parent];
				$link.=$podmeni[rewrite]."|";
				linkovanje($meniid,$rewrite,$link,$id);
			}
	}
	else
	{
		$link2=explode("|",$link);
		$broj=$id-2;
		for($broj;$broj>=0;$broj--)
		{
			print $link2[$broj];
			print "/";
		}
	}

}
function navigacija($meniid,$rewrite,$link)
{
	$link.=$rewrite.'/';
	$query="select * from strana where parent='".$meniid."' order by sortiranje";
	$result=mysql_query($query);
	if(mysql_num_rows($result)!=0)
	{
		print "\n\t<ul class='categoryitems'>";
			while($podmeni=mysql_fetch_array($result))
			{
				$meniid=$podmeni[id];
				print "\n\t\t<li><a href='".ROOT.$link.$podmeni[rewrite]."/'>".$podmeni['ime'].$id."</a>";
				$rewrite=$podmeni[rewrite];
    			navigacija($meniid,$rewrite,$link);
				print "\n\t\t</li>";
			}
		print "\n\t</ul>";

	}
}
function navigacijaTree($meniid,$rewrite,$link)
{
	$link.=$rewrite.'/';
	$query="select * from kat where parent='".$meniid."' order by sortiranje";
	$result=mysql_query($query);
	if(mysql_num_rows($result)!=0)
	{
		print "\n\t<ul class='categoryitems'>";
			while($podmeni=mysql_fetch_array($result))
			{
				$meniid=$podmeni[id];
				print "\n\t\t<li><a href='".B2BROOT."#'  id='".$podmeni[id]."' onclick='PrikaziArtikle(this.id)'>".$podmeni['ime'].$id."</a>";
				$rewrite=$podmeni[rewrite];
    			navigacijaTree($meniid,$rewrite,$link);
				print "\n\t\t</li>";
			}
		print "\n\t</ul>";

	}
}
function navigacijaDrvo($meniid,$rewrite,$link)
{
	$link.=$rewrite.'/';
	$query="select * from kat where parent='".$meniid."' order by sortiranje";
	$result=mysql_query($query);
	if(mysql_num_rows($result)!=0)
	{
		print "\n\t<ul class='categoryitems'>";
			while($podmeni=mysql_fetch_array($result))
			{
				$meniid=$podmeni[id];
				print "\n\t\t<li><a href='".ROOT.$podmeni['rewrite']."/'>".$podmeni['ime'].$id."</a>";
				$rewrite=$podmeni[rewrite];
    			navigacijaDrvo($meniid,$rewrite,$link);
				print "\n\t\t</li>";
			}
		print "\n\t</ul>";

	}
}

function navigacijaArtikliKat($id,$crtica)
{
	global $conn;
	$crtica.=' - ';
	$query="select * from artikli_kategorije where parent='".$id."' order by sortiranje";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)!=0)
	{
		while($podmeni=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			echo '<option value="';
			echo $podmeni['katid'];
			echo '"';
			echo '>';
			print $crtica.$podmeni['ime'];
			print "</option>";
			$id=$podmeni[katid];
			navigacijaArtikliKat($id,$crtica);
		}
	}
}
function navigacijaKat($id,$crtica)
{
	$crtica.=' - ';
	$query="select * from strana where parent='".$id."' order by sortiranje";
	$result=mysql_query($query);
	if(mysql_num_rows($result)!=0)
	{
		while($podmeni=mysql_fetch_array($result))
		{
			echo '<option value="';
			echo $podmeni['id'];
			echo '"';
			echo '>';
			print $crtica.$podmeni['ime'];
			print "</option>";
			$id=$podmeni[id];
			navigacijaKat($id,$crtica);
		}
	}
}
function navigacijaKatb2b($id,$crtica,$katid)
{
	$crtica.=' - ';
	$query="select * from kat where parent='".$id."' order by sortiranje";
	$result=mysql_query($query);
	if(mysql_num_rows($result)!=0)
	{
		while($podmeni=mysql_fetch_array($result))
		{
			echo '<option value="';
			echo $podmeni['id'];
			echo ' "';
			if ($podmeni['id'] == $katid)
				echo ' selected';
			echo '>';
			print $crtica.$podmeni['ime'];
			print "</option>";
			$id=$podmeni[id];
			navigacijaKatb2b($id,$crtica,$katid);
		}
	}
}
function thumbnaillitl($image_path,$thumb_path,$image_name,$filename)
{
    if (!isset($max_width))
	$max_width = 90;
	if (!isset($max_height))
	$max_height = 60;
	$src_img = imagecreatefromjpeg("$image_path/$image_name");
    $width=imagesx($src_img);
    $height=imagesy($src_img);
    $dst_img = imagecreatetruecolor($max_width,$max_height);
    imagecopyresampled($dst_img,$src_img,0,0,0,0,$max_width,$max_height,imagesx($src_img),imagesy($src_img));
    imagejpeg($dst_img, "$thumb_path/$filename");
    return true;
}
function thumbnailbig($image_path,$thumb_path,$image_name,$filename)
{
    if (!isset($max_width))
	$max_width = 270;
	if (!isset($max_height))
	$max_height = 220;
	$src_img = imagecreatefromjpeg("$image_path/$image_name");
    $width=imagesx($src_img);
    $height=imagesy($src_img);
	$dst_img = imagecreatetruecolor($max_width,$max_height);
    imagecopyresampled($dst_img,$src_img,0,0,0,0,$max_width,$max_height,imagesx($src_img),imagesy($src_img));
    imagejpeg($dst_img, "$thumb_path/$filename");
    return true;
}
function truncate($text, $len = 120) {
       if(empty($text)) {
           return "";
       }
       if(strlen($text)<$len) {
            return $text;
       }
       return preg_match("/(.{1,$len})\s./ms", $text, $match) ? $match[1] ." ..."  : substr($text, 0, $len)." ...";
}
function banovan($clanid)
{
	$sql="select * from banovani where clanid='".$clanid."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num!='0')
		return true;
	else
		return false;
}
function dan($dan)
  {
   switch($dan) {
	case "Sunday":
		$dan = "Nedelja";
		break;
	case "Monday":
		$dan = "Ponedeljak";
		break;
	case "Tuesday":
		$dan = "Utorak";
		break;
	case "Wednesday":
		$dan = "Sreda";
		break;
	case "Thursday":
		$dan = "Cetvrtak";
		break;
	case "Friday":
		$dan = "Petak";
		break;
	case "Saturday":
		$dan = "Subota";
   }
   return $dan;
}
function GetGalerijaIdFromRewrite($rewrite)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from galerija_kat
             where rewrite = '$rewrite'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'id');
   return $result;
}
function GetGalerijaImeFromId($id)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from galerija_kat
             where id = '$id'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'ime');
   return $result;
}
function get_slika()
{
   $conn = db_connect();
   $query = 'select *
             from galerija order by ime';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_vesti_kat()
{
   $conn = db_connect();
   $query = 'select *
             from vesti_kat order by kat_ime';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_vestikat_rewrite($katid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from vesti_kat
             where kat_id = '$katid'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'kat_rewrite');
   return $result;
}
function get_vestikat_katime($catid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from vesti_kat
             where kat_id = $catid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'kat_ime');
   return $result;
}
function get_vestikat_katid($rewrite)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from vesti_kat
             where kat_rewrite = '$rewrite'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'kat_id');
   return $result;
}
function getOglasiKatidFromRewrite($rewrite)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from oglasi_kat
             where rewrite = '$rewrite'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'id');
   return $result;
}
function getOglasiKatimeFromKatid($catid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from oglasi_kat
             where id = $catid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'ime');
   return $result;
}
function getPoslovniKatidFromRewrite($rewrite)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from poslovni_kat
             where rewrite = '$rewrite'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'id');
   return $result;
}
function getPoslovniKatimeFromKatid($catid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from poslovni_kat
             where id = $catid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'ime');
   return $result;
}
function alphapng($src, $alt) {
	$ua = $_SERVER['HTTP_USER_AGENT'];
	list($width, $height, $type, $attr) = getimagesize($src);
	if (!strip_tags($ua, "Opera") || strpos($ua, "MSIE 6.0") || strpos($ua, "MSIE 5.5"))
	{
		$imgEl .= "<img src='http://localhost/www.connect.rs/images/blank.gif' ";
		$imgEl .= "style='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(";
		$imgEl .= "src=".$src.", sizingMethod='scale')' border=\"0\" alt=\"$alt\" $attr >";
	}
	else
	{
		$imgEl .= "<img src=\"".$src."\" alt=\"$alt\" border=0 $attr >";
	}
	return $imgEl;
}
function add_search_words($mode, $post_id, $post_text, $post_title = '')
{
	global $db, $phpbb_root_path, $board_config, $lang;

	$stopword_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_stopwords.txt");
	$synonym_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_synonyms.txt");

	$search_raw_words = array();
	$search_raw_words['text'] = split_words(clean_words('post', $post_text, $stopword_array, $synonym_array));
	$search_raw_words['title'] = split_words(clean_words('post', $post_title, $stopword_array, $synonym_array));

	@set_time_limit(0);

	$word = array();
	$word_insert_sql = array();
	while ( list($word_in, $search_matches) = @each($search_raw_words) )
	{
		$word_insert_sql[$word_in] = '';
		if ( !empty($search_matches) )
		{
			for ($i = 0; $i < count($search_matches); $i++)
			{
				$search_matches[$i] = trim($search_matches[$i]);

				if( $search_matches[$i] != '' )
				{
					$word[] = $search_matches[$i];
					if ( !strstr($word_insert_sql[$word_in], "'" . $search_matches[$i] . "'") )
					{
						$word_insert_sql[$word_in] .= ( $word_insert_sql[$word_in] != "" ) ? ", '" . $search_matches[$i] . "'" : "'" . $search_matches[$i] . "'";
					}
				}
			}
		}
	}

	if ( count($word) )
	{
		sort($word);

		$prev_word = '';
		$word_text_sql = '';
		$temp_word = array();
		for($i = 0; $i < count($word); $i++)
		{
			if ( $word[$i] != $prev_word )
			{
				$temp_word[] = $word[$i];
				$word_text_sql .= ( ( $word_text_sql != '' ) ? ', ' : '' ) . "'" . $word[$i] . "'";
			}
			$prev_word = $word[$i];
		}
		$word = $temp_word;

		$check_words = array();
		switch( SQL_LAYER )
		{
			case 'postgresql':
			case 'msaccess':
			case 'mssql-odbc':
			case 'oracle':
			case 'db2':
				$sql = "SELECT word_id, word_text
					FROM " . SEARCH_WORD_TABLE . "
					WHERE word_text IN ($word_text_sql)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not select words', '', __LINE__, __FILE__, $sql);
				}

				while ( $row = $db->sql_fetchrow($result) )
				{
					$check_words[$row['word_text']] = $row['word_id'];
				}
				break;
		}

		$value_sql = '';
		$match_word = array();
		for ($i = 0; $i < count($word); $i++)
		{
			$new_match = true;
			if ( isset($check_words[$word[$i]]) )
			{
				$new_match = false;
			}

			if ( $new_match )
			{
				switch( SQL_LAYER )
				{
					case 'mysql':
					case 'mysql4':
						$value_sql .= ( ( $value_sql != '' ) ? ', ' : '' ) . '(\'' . $word[$i] . '\', 0)';
						break;
					case 'mssql':
					case 'mssql-odbc':
						$value_sql .= ( ( $value_sql != '' ) ? ' UNION ALL ' : '' ) . "SELECT '" . $word[$i] . "', 0";
						break;
					default:
						$sql = "INSERT INTO " . SEARCH_WORD_TABLE . " (word_text, word_common)
							VALUES ('" . $word[$i] . "', 0)";
						if( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not insert new word', '', __LINE__, __FILE__, $sql);
						}
						break;
				}
			}
		}

		if ( $value_sql != '' )
		{
			switch ( SQL_LAYER )
			{
				case 'mysql':
				case 'mysql4':
					$sql = "INSERT IGNORE INTO " . SEARCH_WORD_TABLE . " (word_text, word_common)
						VALUES $value_sql";
					break;
				case 'mssql':
				case 'mssql-odbc':
					$sql = "INSERT INTO " . SEARCH_WORD_TABLE . " (word_text, word_common)
						$value_sql";
					break;
			}

			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not insert new word', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	while( list($word_in, $match_sql) = @each($word_insert_sql) )
	{
		$title_match = ( $word_in == 'title' ) ? 1 : 0;

		if ( $match_sql != '' )
		{
			$sql = "INSERT INTO " . SEARCH_MATCH_TABLE . " (post_id, word_id, title_match)
				SELECT $post_id, word_id, $title_match
					FROM " . SEARCH_WORD_TABLE . "
					WHERE word_text IN ($match_sql)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not insert new word matches', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if ($mode == 'single')
	{
		remove_common('single', 4/10, $word);
	}

	return;
}

function do_html_url($url, $name)
{
?>
  <a href="<?php echo $url; ?>"><?php echo $name; ?></a>
<?php
}
function ocisti_reci($entry)
{
	static $drop_char_match =   array('^', '$', '&', '(', ')', '<', '>', '`', '\'', '"', '|', ',', '@', '_', '?', '%', '-', '~', '+', '.', '[', ']', '{', '}', ':', '\\', '/', '=', '#', '\'', ';', '!');
	static $drop_char_replace = array(' ', ' ', ' ', ' ', ' ', ' ', ' ', '',  '',   ' ', ' ', ' ', ' ', '',  ' ', ' ', '',  ' ',  ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' , ' ', ' ', ' ', ' ',  ' ', ' ');

	$entry = ' ' . strip_tags(strtolower($entry)) . ' ';

	// Replace line endings by a space
	$entry = preg_replace('/[\n\r]/is', ' ', $entry);
	// HTML entities like &nbsp;
	$entry = preg_replace('/\b&[a-z]+;\b/', ' ', $entry);
	// Remove URL's
	$entry = preg_replace('/\b[a-z0-9]+:\/\/[a-z0-9\.\-]+(\/[a-z0-9\?\.%_\-\+=&\/]+)?/', ' ', $entry);
	// Quickly remove BBcode.
	$entry = preg_replace('/\[img:[a-z0-9]{10,}\].*?\[\/img:[a-z0-9]{10,}\]/', ' ', $entry);
	$entry = preg_replace('/\[\/?url(=.*?)?\]/', ' ', $entry);
	$entry = preg_replace('/\[\/?[a-z\*=\+\-]+(\:?[0-9a-z]+)?:[a-z0-9]{10,}(\:[a-z0-9]+)?=?.*?\]/', ' ', $entry);
	//
	// Filter out strange characters like ^, $, &, change "it's" to "its"
	//
	for($i = 0; $i < count($drop_char_match); $i++)
	{
		$entry =  str_replace($drop_char_match[$i], $drop_char_replace[$i], $entry);
	}

	$entry = str_replace('*', ' ', $entry);

	// 'words' that consist of <3 or >20 characters are removed.
	$entry = preg_replace('/[ ]([\S]{1,2}|[\S]{21,})[ ]/',' ', $entry);

	return $entry;
}
function BBdecode($text)
{
	$text=str_replace("\n","<br>\n", $text);
	$text=str_replace("[b]","<span style=\"font-weight: bold\">",$text);
	$text=str_replace("[/b]","</span>",$text);
	$text=str_replace("[i]","<span style=\"font-style: italic\">",$text);
	$text=str_replace("[/i]","</span>",$text);
	$text=str_replace("[u]","<span style=\"text-decoration: underline\">",$text);
	$text=str_replace("[/u]","</span>",$text);
	$text=str_replace("[img]","<img src=\"",$text);
	$text=str_replace("[/img]","\">",$text);
	$text=str_replace("[korak]","<li><span class=\"korak\">",$text);
	$text=str_replace("[/korak]","</span>",$text);
	$text=str_replace("[quote]","<strong>Citat:</strong><div class=\"citat\">",$text);
	$text=str_replace("[/quote]","</div>",$text);
	return $text;
}
function BBencode($text)
{
	$text=str_replace("<br>\n","\n", $text);
	$text=str_replace("<span style=\"font-weight: bold\">","[b]",$text);
	$text=str_replace("</span>","[/b]",$text);
	$text=str_replace("<span style=\"font-style: italic\">","[i]",$text);
	$text=str_replace("</span>","[/i]",$text);
	$text=str_replace("<span style=\"text-decoration: underline\">","[u]",$text);
	$text=str_replace("</span>","[/u]",$text);
	$text=str_replace("<img src=\"","[img]",$text);
	$text=str_replace("\">","[/img]",$text);
	$text=str_replace("<li><span class=\"korak\">","[korak]",$text);
	$text=str_replace("</span>","[/korak]",$text);
	$text=str_replace("<strong>Citat:</strong><div class=\"citat\">","[quote]",$text);
	$text=str_replace("</div>","[/quote]",$text);
	return $text;
}
function clean_trazi_words($mode, &$entry)
{
	static $drop_char_match =   array('^', '$', '&', '(', ')', '<', '>', '`', '\'', '"', '|', ',', '@', '_', '?', '%', '-', '~', '+', '.', '[', ']', '{', '}', ':', '\\', '/', '=', '#', '\'', ';', '!');
	static $drop_char_replace = array(' ', ' ', ' ', ' ', ' ', ' ', ' ', '',  '',   ' ', ' ', ' ', ' ', '',  ' ', ' ', '',  ' ',  ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' , ' ', ' ', ' ', ' ',  ' ', ' ');

	$entry = ' ' . strip_tags(strtolower($entry)) . ' ';

	$entry = str_replace(' +', ' and ', $entry);
	$entry = str_replace(' -', ' not ', $entry);

	//
	// Filter out strange characters like ^, $, &, change "it's" to "its"
	//
	for($i = 0; $i < count($drop_char_match); $i++)
	{
		$entry =  str_replace($drop_char_match[$i], $drop_char_replace[$i], $entry);
	}
	return $entry;
}
function razbi($entry)
{
	return explode(' ', trim(preg_replace('#\s+#', ' ', $entry)));
}
function get_podkat()
{
   $conn = db_connect();
   $query = 'select *
             from podkat order by podkat_ime';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_kat()
{
   $conn = db_connect();
   $query = 'select *
             from kat order by kat_ime';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_anketa()
{
   $conn = db_connect();
   $query = 'select id, pitanje
             from anketa order by id';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_categories()
{
   $conn = db_connect();
   $query = 'select kat_rewrite, kat_ime, kat_brfajlova from kat order by kat_ime';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_category_rewrite($catid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from kat
             where kat_id = $catid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'kat_rewrite');
   return $result;
}
function get_podcategory_rewrite($podkatid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from podkat
             where podkat_id = $podkatid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'podkat_rewrite');
   return $result;
}
function mapa($cat_array)
{
  if (!is_array($cat_array))
  {
     echo 'Trenutno nema kategorija<br />';
     return;
  }
  echo '<table width="100%" cellspacing="0" cellpadding="0" class="privredniu">';
  echo '<tr><td>';
  echo '<table  width="100%" cellspacing="0" cellpadding="0">';
  echo '<tr>';
  echo '<td align="right" valign="bottom"></td></tr>';
  echo '</table>';
  echo '</td></tr>';
  echo '<tr><td><table border=0 width="100%" class="privredni" cellspacing="2" cellpadding="2">';
  foreach ($cat_array as $row)
  {
	  $kategori=$row['catid'];
	  $kveri="select * from delatnosti where catid='$kategori' order by delname";
	  $rezultat=mysql_query($kveri);
	  $url = 'delatnosti.php?catid='.($row['catid']);
    $title = $row['catname'];
		echo '<tr><td width="33%" align="left" valign="top">';
		echo "<table border=0 width='100%' cellspacing='0' cellpadding='0'>";
		echo '<tr><td align="left" valign="top">';
		do_html_url($url, $title);
		echo '</td></tr>';
		echo '<tr><td align="left" valign="top">';
		while($link=mysql_fetch_array($rezultat))
		{
		echo '<span class="class1">';
		echo '- <a href="linkovi.php?catid='.$kategori.'&delatnost='.$link['delid'].'">'.$link['delname'].'</a><br>';
		echo '';
		echo '</span>';
		}
		echo '</td></tr>';
		echo '</table>';
		echo "</td>";
  }
  echo '</table>';
  echo '</td></tr>';
echo '</table>';
}
function display_categories($cat_array)
{
  if (!is_array($cat_array))
  {
     echo 'Trenutno nema kategorija<br />';
     return;
  }
$count=-1;
?>
<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td class="naslov" width="80%">Index</td>
					<td class="naslov" width="20%" align="center">Br. Fajlova</td>
				</tr>
			<?php
			foreach ($cat_array as $row)
			{
				$url = ROOT.($row['kat_rewrite'])."/";
				$title = $row['kat_ime'];
				$broj = $row['kat_brfajlova'];
				print "<tr><td class='linkovi'>";
				do_html_url($url, $title);
				print "</td>";
				print "<td class='linkovi' align='center'>";
				do_html_url($url, $broj);
				print "</td></tr>";
			}
			?>
			</table>
		</td>
	</tr>
</table>
<?php
}
function broj_linkova($link)
{
	$conn = db_connect();
	$query="select * from sajtovi where delid=$link and verifikacija=2";
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	return $num;
}
function get_clan_name($catid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select username
             from clanovi
             where id = $catid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'username');
   return $result;
}
function get_category_id($rewrite)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from kat
             where kat_rewrite = '$rewrite'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'kat_id');
   return $result;
}
function get_subcategory_id($rewrite)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select * from podkat
             where podkat_rewrite = '$rewrite'";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'podkat_id');
   return $result;
}
function get_category_name($catid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select kat_ime
             from kat
             where kat_id = $catid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'kat_ime');
   return $result;
}
function get_podkat_name($delid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select podkat_ime
             from podkat
             where podkat_id = $delid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'podkat_ime');
   return $result;
}
function get_podkat_katid($delid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select kat_id
             from podkat
             where podkat_id = $delid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'kat_id');
   return $result;
}
function get_fajlovi_podkatid($delid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select podkat_id
             from fajlovi
             where fajl_id = $delid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'podkat_id');
   return $result;
}
function get_fajl_name($delid)
{
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select fajl_ime
             from fajlovi
             where fajl_id = $delid";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = mysql_result($result, 0, 'fajl_ime');
   return $result;
}
function get_delatnosti()
{
   $conn = db_connect();
   $query = "select delid, delname
             from delatnosti order by delname";
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_dela = @mysql_num_rows($result);
   if ($num_dela ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function display_delatnosti($del_array)
{
  if (!is_array($del_array))
  {
     echo 'Trenutno nema delatnosti<br />';
     return;
  }
  $count=0;
  echo '<table border=1>';
  foreach ($del_array as $row)
  {
    $url = 'delatnosti.php?delid='.($row['delid']);
    $title = $row['delname'];
    $count+=1;
	echo '<tr>';
	echo '<td>';
	do_html_url($url, $title);
	echo '</td>';
	echo '</tr>';
  }
  echo '</table>';
  print $count;
  echo '<hr />';
}
function get_drzava()
{
   $conn = db_connect();
   $query = 'select *
             from drzava order by drzava';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_godina()
{
   $conn = db_connect();
   $query = 'select *
             from d_godina order by godina desc';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_dan()
{
   $conn = db_connect();
   $query = 'select *
             from d_dan order by dan';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
function get_mesec()
{
   $conn = db_connect();
   $query = 'select *
             from d_mesec order by mesec';
   $result = @mysql_query($query);
   if (!$result)
     return false;
   $num_cats = @mysql_num_rows($result);
   if ($num_cats ==0)
      return false;
   $result = db_result_to_array($result);
   return $result;
}
?>
