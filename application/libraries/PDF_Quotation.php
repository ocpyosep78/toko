<?php


// Ayunidha Ashriaherty 2004
// Version 1.00

  //////////////////////////////////////
 //      Index Public functions      //
//////////////////////////////////////

// function RoundedRect
// function _Arc
// function Rotate
// function _endpage
// function sizeOfText
//require_once('html_table.php');
require_once('htmlparser.inc.php');
class PDF_Quotation extends FPDF
{
// private variables
var $colonnes;
var $format;
var $angle=0;
//variables of html parser
var $B;
var $I;
var $U;
var $HREF;
var $fontList;
var $issetfont;
var $issetcolor;
// private functions
function RoundedRect($x, $y, $w, $h, $r, $style = '')
{
	$k = $this->k;
	$hp = $this->h;
	if($style=='F')
		$op='f';
	elseif($style=='FD' || $style=='DF')
		$op='B';
	else
		$op='S';
	$MyArc = 4/3 * (sqrt(2) - 1);
	$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
	$xc = $x+$w-$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

	$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
	$xc = $x+$w-$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
	$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
	$xc = $x+$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
	$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
	$xc = $x+$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
	$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
	$this->_out($op);
}

function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
	$h = $this->h;
	$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
						$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}

function Rotate($angle, $x=-1, $y=-1)
{
	if($x==-1)
		$x=$this->x;
	if($y==-1)
		$y=$this->y;
	if($this->angle!=0)
		$this->_out('Q');
	$this->angle=$angle;
	if($angle!=0)
	{
		$angle*=M_PI/180;
		$c=cos($angle);
		$s=sin($angle);
		$cx=$x*$this->k;
		$cy=($this->h-$y)*$this->k;
		$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	}
}

function _endpage()
{
	if($this->angle!=0)
	{
		$this->angle=0;
		$this->_out('Q');
	}
	parent::_endpage();
}

// public functions
function sizeOfText( $texte, $largeur )
{
	$index    = 0;
	$nb_lines = 0;
	$loop     = TRUE;
	while ( $loop )
	{
		$pos = strpos($texte, "\n");
		if (!$pos)
		{
			$loop  = FALSE;
			$ligne = $texte;
		}
		else
		{
			$ligne  = substr( $texte, $index, $pos);
			$texte = substr( $texte, $pos+1 );
		}
		$length = floor( $this->GetStringWidth( $ligne ) );
		$res = 1 + floor( $length / $largeur) ;
		$nb_lines += $res;
	}
	return $nb_lines;
}


// tulisan invoice pojok kanan atas
function fact_dev( $libelle, $num )
{
    $r1  = $this->w - 201;
    $r2  = $r1 + 80;
    $y1  = 55;
    $y2  = $y1 + 2;
    $mid = ($r1 + $r2 ) / 2;
    
    $texte  = $libelle;    
    $szfont = 20;
    $loop   = 0;
    
    while ( $loop == 0 )
    {
       $this->SetFont( "Arial", "B", $szfont );
       $sz = $this->GetStringWidth( $texte );
       if ( ($r1+$sz) > $r2 )
          $szfont --;
       else
          $loop ++;
    }

   
   
    $this->SetXY( $r1+1, $y1+2);
    $this->SetTextColor(0,0, 0);
    $this->Cell($r2-$r1 -1,5, $texte, 0, 0, "L" );
    $this->Line(10,38,200,38);
	$this->Line(10,38.2,200,38.2);
	$this->Line(10,38.3,200,38.3);
	$this->Line(10,38.4,200,38.4);
	$this->Line(10,39.5,200,39.5);
}


//logo
function addlogo( $stat )
{
	$x1  = 10;
	$y1  = 20;
	$this->SetXY($x1,$y1);
	$this->Image(base_url().'asset/img/ajav.jpg',11,8,25.5,25.5);

}
function addjvm()
{
	$x1  = 30;
	$y1  = 20;
	$this->SetXY($x1,$y1);
	$this->Image(base_url().'asset/img/jvm.jpg',38,4,160,14);

}
function descr()
{
    global $title;

    // Arial bold 15
    $this->SetFont('Arial','B',8.5);
    // Calculate width of title and position
    $w = $this->GetStringWidth($title)+90;
    $this->SetXY((170-$w)/2,20);
    // Colors of frame, background and text
    $this->SetFillColor(255,102,0);
    $this->SetTextColor(0,0,0);
    // Thickness of frame (1 mm)
    $this->SetLineWidth(0.5);
    // Title
    $this->Cell(160,5,"General Suplier, Distributor & Representive of Laboratory Environmetal, Medical and Industrial Equipment",1,1,'C',true);
    // Line break
    $this->Ln(10);
}

function addHeadAlamat( $ha )
{
	$this->SetLineWidth(0.1);
	$r1  = $this->w - 150;
	$r2  = $r1 + 80;
	$y1  = 23;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5, "Alamat", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 +20.5, $y1+3 );
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5,$ha, 0,0, "C");
}
function addHeadTelp( $ht )
{
	$this->SetLineWidth(0.1);
	$r1  = $this->w - 150;
	$r2  = $r1 + 82;
	$y1  = 28;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5, "Telp / Faks", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 +20.5, $y1+3 );
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5,'  '.$ht, 0,0, "C");
}

function addTabelDate( $date )
{
	$r1  = $this->w - 150;
	$r2  = $r1 + 15;
	$y1  = 65;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(35,5, "   DATE", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2-20, $y1+3 );
	$this->SetFont( "Arial", "",8);
	$this->Cell(65,5,'  '.$date, 1,1, "L");
}
function addTabelAttn( $attn )
{
	$this->SetLineWidth(0.1);
	$r1  = $this->w - 75;
	$r2  = $r1 + 15;
	$y1  = 65;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 30, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(25,5, "   Attn", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2-5, $y1+3 );
	$this->SetFont( "Arial", "B",8 );
	$this->Cell(60,5,'  '.$attn, 1,1, "L");
}
function addTabelQuNo( $quno )
{
	$this->SetLineWidth(0.1);
	$r1  = $this->w - 150;
	$r2  = $r1 + 15;
	$y1  = 70;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(35,5, "   Quotation No", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2-20, $y1+3 );
	$this->SetFont( "Arial", "",8);
	$this->Cell(65,5,'  '.$quno, 1,1, "L");
}
function addTabelCc( $cc )
{
	$this->SetLineWidth(0.1);
	$r1  = $this->w - 80;
	$r2  = $r1 + 15;
	$y1  = 75;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 25, $y1-2 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(25,5, "   Cc", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2, $y1-2 );
	$this->SetFont( "Arial", "B",8 );
	$this->Cell(60,5,'  '.$cc, 1,1, "L");
}
function addTabelTo( $to )
{
	$this->SetLineWidth(0.1);
	$r1  = $this->w - 150;
	$r2  = $r1 + 15;
	$y1  = 75;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(35,5, "   To", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2-20, $y1+3 );
	$this->SetFont( "Arial", "",8);
	$this->Cell(65,5,'  '.$to, 1,1, "L");
}
function addTabelTelp( $bb )
{
	$this->SetLineWidth(0.1);
	$r1  = $this->w - 80;
	$r2  = $r1 + 15;
	$y1  = 80;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 25, $y1-2 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(25,5, "   Telp / HP", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2, $y1-2 );
	$this->SetFont( "Arial", "B",8 );
	$this->Cell(60,5,'  '.$bb, 1,1, "L");
}
function addTabelAddress()
{
	$r1  = $this->w - 150;
	$r2  = $r1 + 15;
	$y1  = 80;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(35,12, "   Address", 1, 1, "L");
}
function addressisi($add){
	$r1  = $this->w - 150;
	$r2  = $r1 + 15;
	$y1  = 80;
	$this->SetLineWidth(0.1);
	$this->SetXY( $r1 + ($r2-$r1)/2-20, $y1+3 );
	$this->SetFont( "Arial", "",8);
	$this->setX(50);
	$this->MultiCell(65, 4, $add, 0 ,'LR' ,false);
	$this->Line(47, 95, 113, 95);
}
function addTabelFaks( $faks )
{
	$r1  = $this->w - 80;
	$r2  = $r1 + 15;
	$y1  = 85;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 25, $y1-2 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(25,5, "   Fax No", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2, $y1-2 );
	$this->SetFont( "Arial", "B",8 );
	$this->Cell(60,5,'  '.$faks, 1,1, "L");
}
function addEmail( $email )
{
	$r1  = $this->w - 80;
	$r2  = $r1 + 15;
	$y1  = 90;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 25, $y1-2 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(25,7, "   Email", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2, $y1-2 );
	$this->SetTextColor(0, 153, 255);
	$this->SetFont( "Arial", "U",8 );
	$this->Cell(60,7,'  '.$email, 1,1, "L");
}
function addWeAre()
{
	$x1  = 38;
	$y1  = 100;
	$this->SetXY( $x1, $y1 );
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(0, 0, 0);
	$this->Cell(10,5, "We Are Please To Quote You As Follows", 0, 0, "C");
}

function addQuote()
{
	$this->SetXY(13,110);
	$this->Cell(10,5,'No',1,1,'C');
	$this->SetXY(23,110);
	$this->Cell(25,5,'Model',1,1,'C');
	$this->SetXY(48,110);
	$this->Cell(64,5,'Description of Goods',1,1,'C');
	$this->SetXY(112,110);
	$this->Cell(13,5,'Qty',1,1,'C');
	$this->SetXY(125,110);
	$this->Cell(13,5,'Disc',1,0,'C');
	$this->SetXY(138,110);
	$this->Cell(30,5,'Price',1,1,'C');
	$this->SetXY(168,110);
	$this->Cell(30,5,'Amount',1,0,'C');
}
function addProdSatu($no, $image, $descr, $qty, $disc, $price, $amount)
{
	
	$this->SetXY(13,115);
	$this->SetFont('Arial','B',9);
	$this->Cell(10,5,$no,1,1,'C');
	$id = $_POST['id'];
	$getdata=mysql_query("SELECT model from quot WHERE id = '$_GET[id]'");
	while($data=mysql_fetch_array($getdata))
	{
	$datamodel=explode("|",$data['model']);

	for($i=0;$i<=count($datamodel);$i++) 
	{ 
	$this->SetX(23);
	$this->SetFont('Arial','',9);
	$this->Cell(25,5,$datamodel[$i],1,1,'L'); }
	}
	$getdes=mysql_query("SELECT descr FROM quot WHERE id = '$_GET[id]'");
	while($dataa=mysql_fetch_array($getdes))
	{
	$datadesc=explode("|",$dataa['descr']);

	for($a=0;$a<=count($datadescr);$a++) 
	{ 
	$this->SetXY(48,115);	
	$this->SetFont('Arial','',9);
	$this->Cell(64,5,$datadesc[$a],1,1,'L'); }
	}
	$this->SetXY(112,115);
	$this->SetFont('Arial','B',9);
	$this->Cell(13,5,$qty,1,1,'C');
	$this->SetXY(125,115);
	$this->SetFont('Arial','B',9);
	$this->Cell(13,5,$disc,1,0,'C');
	$this->SetXY(138,115);
	$this->SetFont('Arial','',9);
	$this->Cell(30,5,$price,1,1,'R');
	$this->SetXY(168,115);
	$this->SetFont('Arial','',9);
	$this->Cell(30,5,$amount,1,0,'R');
}

// penambahan produk bisa pake pengulangan yaks biar lbh singkat
function addGrandTotal($no)
{
	$this->SetXY(13,135);
	$this->SetFont('Arial','B',9);
	$this->Cell(150,5,"Grand Total",1,1,'L');
	$this->SetXY(163,135);
	$this->SetFont('Arial','B',9);
	$this->Cell(35,5,$no,1,1,'R');
}
function addExVAT()
{
	$x1  = 13;
	$y1  = 145;
	$this->SetXY( $x1, $y1 );
	$this->SetFont('Arial','',9);
	$this->SetTextColor(0, 0, 0);
	$this->Cell(10,5, "Price Excluding VAT 10%", 0, 0, "L");
}
function addPriceStok()
{
	$x1  = 13;
	$y1  = 150;
	$this->SetXY( $x1, $y1 );
	$this->SetFont('Arial','',9);
	$this->SetTextColor(0, 0, 0);
	$this->Cell(10,5, "Price & Stock may change without prior notice", 0, 0, "L");
}
function addTerm( $term )
{
	$r1  = $this->w - 150;
	$r2  = $r1 + 15;
	$y1  = 155;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(55,5, "   Term Payment", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2, $y1+3 );
	$this->SetFont( "Arial", "",8);
	$this->Cell(100,5,$term, 1,1, "L");
}
function addDeliv( $deliv )
{
	$r1  = $this->w - 150;
	$r2  = $r1 + 15;
	$y1  = 160;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(55,5, "   Delivery Time", 1, 1, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2, $y1+3 );
	$this->SetFont( "Arial", "",8);
	$this->Cell(100,5,$deliv, 1,1, "L");
}
function addWarranty()
{
	$r1  = $this->w - 150;
	$r2  = $r1 + 15;
	$y1  = 165;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(55,10, "   Warranty", 1, 1, "L");
}
function addWarrantyy( $warr )
{
	$r1  = $this->w - 95;
	$r2  = $r1 + 15;
	$y1  = 165;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(100,5,$warr, 1, 1, "L");
}
function addWarrantyyy( $warrr )
{
	$r1  = $this->w - 95;
	$r2  = $r1 + 15;
	$y1  = 170;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "", 8);
	$this->Cell(100,5,$warrr, 1, 1, "L");
}
// bank information
function addBank()
{
	$r1  = $this->w -197;
	$r2  = $r1 + 18;
	$y1  = 180;
	$y2  = $y1 ;
	$this->SetXY( $r1 + ($r2-$r1)/2 - 11, $y1+3 );
	$this->SetFont( "Arial", "BU", 9);
	$this->Cell(10,5, "BANK INFORMATION", 0, 0, "L");
}
function addBCA()
{
	$r1  = $this->w -197;
	$r2  = $r1 + 25;
	$y1  = 185;
	$y2  = $y1 ;
	$this->SetXY( $r1 + ($r2-$r1)/2 - 11, $y1+3 );
	$this->SetFont( "Arial", "B", 9);
	$this->Cell(10,5, "BCA ACCOUNT NUMBER 0461332357 A.N CV. JAVA MULTI MANDIRI KCU PURWOKERTO", 0, 0, "L");
}
function addMDR()
{
	$r1  = $this->w -197;
	$r2  = $r1 + 25;
	$y1  = 189;
	$y2  = $y1 ;
	$this->SetXY( $r1 + ($r2-$r1)/2 - 11, $y1+3 );
	$this->SetFont( "Arial", "B", 9);
	$this->Cell(10,5, "MANDIRI ACCOUNT NUMBER 1390011816315 A.N CV. JAVA MULTI MANDIRI KCU PURWOKERTO", 0, 0, "L");
}
function addBNI()
{
	$r1  = $this->w -197;
	$r2  = $r1 + 25;
	$y1  = 193;
	$y2  = $y1 ;
	$this->SetXY( $r1 + ($r2-$r1)/2 - 11, $y1+3 );
	$this->SetFont( "Arial", "B", 9);
	$this->Cell(10,5, "BNI ACCOUNT NUMBER 0575801234 A.N CV. JAVA MULTI MANDIRI KCU PURWOKERTO", 0, 0, "L");
}
function addThk()
{
	$r1  = $this->w -197;
	$r2  = $r1 + 300;
	$y1  = 210;
	$y2  = $y1 ;
	$this->SetXY( $r1 + ($r2-$r1)/2 - 11, $y1+3 );
	$this->SetFont( "Arial", "", 7);
	$this->Cell(10,5, "Thanks & Best Regards,", 0, 0, "L");
}
function addCv()
{
	$r1  = $this->w -197;
	$r2  = $r1 + 296;
	$y1  = 213;
	$y2  = $y1 ;
	$this->SetXY( $r1 + ($r2-$r1)/2 - 11, $y1+3 );
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(10,5, "CV. JAVA MULTI MANDIRI", 0, 0, "L");
}
//stamp
function addstamp( )
{

	$this->Image(base_url().'asset/img/jadi.jpg',132,219,25,25);

}
//ttd
function addttd($src)
{
	$rtr=rtrim($src);
	if ((empty($rtr)) || (strlen($rtr)===0)) {
		$ttdnya='asset/img/ttd.jpg';
	}else{
		$ttdnya=$rtr;
	}
	$this->Image(base_url().$ttdnya,155,219,23,15);

}
function addFootTelp( $nama, $telp )
{
	$r1  = $this->w - 150;
	$r2  = $r1 + 296;
	$y1  = 231;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+3 );
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(10,5, $nama, 0, 0, "L");
	$this->SetXY( $r1 + ($r2-$r1)/2-70, $y1+6 );
	$this->SetFont( "Arial", "", 7);
	$this->Cell(10,5,$telp, 0,0, "L");
}
// add a watermark (temporary estimate, DUPLICATA...)
// call this method first
function temporaire( $texte )
{
	$this->SetFont('Arial','B',50);
	$this->SetTextColor(203,203,203);
	$this->Rotate(45,55,190);
	$this->Text(55,190,$texte);
	$this->Rotate(0);
	$this->SetTextColor(0,0,0);
}
//----------------------------------------------------------------------------------------------
function Header()
{
    // Logo                                       x,y,gede
    $this->Image(base_url().'asset/img/ajav.jpg',15,12,18);
    // Arial bold 15
   	
    // $this->Cell(w,h,'Title',b/none,0,align)
    //$this->Ln(20); spasi baris
}
function jdlinv(){
	//$this->SetRightMargin(25);
	$this->SetXY(175,18);
	$this->SetFont('Arial','B',24);
    $this->Cell(25,10,'INVOICE',0,0,'R');
}
function lefttopinv(){
	$this->Image(base_url().'asset/img/jvm.jpg',14,35,40);
	$this->SetFont('Arial','',9);
	$this->SetXY(19,40);
	$this->Cell(50,3,'Jl. Raya Baturaden Timur KM 7 No. 17',0,0,'R');$this->Ln();
	$this->SetXY(14,45);
	$this->Cell(50,3,'Purwokerto-Jawa Tengah-Indonesia,53100',0,0,'L');
	$this->Ln(18);
	$this->SetXY(14,53);
	$this->Cell(50,3,'PHONE',0,0,'L');
	$this->SetX(30);
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(32);
	$this->Cell(50,3,' 62-281-5755222',0,0,'L');
	$this->SetXY(14,56);
	$this->Cell(50,3,'FAKS',0,0,'L');
	$this->SetX(30);	
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(32);
	$this->Cell(50,3,' 62-281-6572606',0,0,'L');
	$this->SetXY(14,59);
	$this->Cell(50,3,'HP',0,0,'L');
	$this->SetX(30);	
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(32);
	$this->Cell(50,3,' 085291771888',0,0,'L');
	$this->SetXY(14,62);
	$this->Cell(50,3,'EMAIL',0,0,'L');
	$this->SetX(30);	
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(32);
	$this->Cell(50,3,' info@jvm.co.id',0,0,'L');
}
function Kdinv($Kdinv){
	$this->SetXY(118,34);
	$this->SetFont('Arial','B',12);
	$this->Cell(45,5,$Kdinv,0,0,'L');
}


function rsideinv($tgl,$paymet,$shipmet,$paystt,$notpay){
	$this->SetXY(118,39);
	$this->SetFont('Arial','',8);
	$this->Cell(45,3,'STATUS',0,0,'L');
	$this->SetX(150);
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(152);
	$this->Cell(45,3,' OPEN',0,0,'L');
	$this->Ln();
	$this->SetXY(118,42);
	$this->Cell(45,3,'DATE',0,0,'L');
	$this->SetX(150);
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(152);
	$this->Cell(45,3,' '.$tgl,0,0,'L');
	$this->Ln();
	$this->SetXY(118,45);
	$this->Cell(45,3,'PAYMENT METHOD',0,0,'L');
	$this->SetX(150);
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(152);
	$this->Cell(45,3,' '.$paymet,0,0,'L');
	$this->Ln();
	$this->SetXY(118,48);
	$this->Cell(45,3,'SHIPING METHOD',0,0,'L');
	$this->SetX(150);
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(152);
	$this->Cell(45,3,' '.$shipmet,0,0,'L');
	$this->SetXY(118,55);
	$this->Cell(45,3,'PAYMENT STATUS',0,0,'L');
	$this->SetX(150);
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(152);
	$this->Cell(45,3,' '.$paystt,0,0,'L');
	$this->SetXY(118,58);
	$this->Cell(45,3,'NOTE PAYMENT',0,0,'L');
	$this->SetX(150);
	$this->Cell(45,3,' : ',0,0,'L');
	$this->SetX(152);
	$this->Cell(45,3,' '.$notpay,0,0,'L');
}
function jdl_cusside(){
	$this->Ln(10);
	$this->SetFont('Arial','B',12);
	$this->SetXY(14,67);
	$this->Cell(45,3,'Customer :',0,0,'L');

}
function jdl_billside(){
	$this->Ln(10);
	$this->SetFont('Arial','B',12);
	$this->SetXY(75,67);
	$this->Cell(45,3,'Bill to :',0,0,'L');

}
function jdl_shipside(){
	$this->Ln(10);
	$this->SetFont('Arial','B',12);
	$this->SetXY(130,67);
	$this->Cell(45,3,'Ship to :',0,0,'L');

}
function isi_cusside($nm,$almt,$city,$telp){
	
	$this->SetFont('Arial','',8);
	$this->SetXY(14,71);
	$this->Cell(35,3,$nm,0,0,'L');
	$this->SetXY(14,75);
	$this->Multicell(35,3.5,$almt,0);
	$this->SetXY(14,86);
	$this->Multicell(35,3.5,$city,0);
	$this->SetXY(14,90);
	$this->Multicell(35,3.5,$telp,0);
	$this->Image(base_url().'asset/img/barcodee.jpg',13.5,94.5,45,6.5);
}
function isi_billside($nm,$almt,$telp){
	
	$this->SetFont('Arial','',8);
	$this->SetXY(75,71);
	$this->Cell(50,3.5,$nm,0,0,'L');
	$this->SetXY(75,74);
	$this->Multicell(50,3.5,$almt,0,'L');
	$this->SetXY(75,90);
	$this->Cell(50,3.5,$telp,0,0,'L');
	
}
function isi_shipside($nm,$almt,$telp){
	
	$this->SetFont('Arial','',8);
	$this->SetXY(130,71);
	$this->Cell(50,3.5,$nm,0,0,'L');
	$this->SetXY(130,74);
	$this->Multicell(50,3.5,$almt,0,'L');
	$this->SetXY(130,89);
	$this->Cell(50,3.5,$telp,0,0,'L');
	
}
//---------------------------------cell_scalefit------------------------------------------------------------------------------------
	//Cell with horizontal scaling if text is too wide
	function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
	{
		//Get string width
		$str_width=$this->GetStringWidth($txt);

		//Calculate ratio to fit cell
		if($w==0)
			$w = $this->w-$this->rMargin-$this->x;
		$ratio = ($w-$this->cMargin*2)/$str_width;

		$fit = ($ratio < 1 || ($ratio > 1 && $force));
		if ($fit)
		{
			if ($scale)
			{
				//Calculate horizontal scaling
				$horiz_scale=$ratio*100.0;
				//Set horizontal scaling
				$this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
			}
			else
			{
				//Calculate character spacing in points
				$char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
				//Set character spacing
				$this->_out(sprintf('BT %.2F Tc ET',$char_space));
			}
			//Override user alignment (since text will fill up cell)
			$align='';
		}

		//Pass on to Cell method
		$this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

		//Reset character spacing/horizontal scaling
		if ($fit)
			$this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
	}

	//Cell with horizontal scaling only if necessary
	function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
	}

	//Cell with horizontal scaling always
	function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
	}

	//Cell with character spacing only if necessary
	function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
	}

	//Cell with character spacing always
	function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		//Same as calling CellFit directly
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
	}

	//Patch to also work with CJK double-byte text
	function MBGetStringLength($s)
	{
		if($this->CurrentFont['type']=='Type0')
		{
			$len = 0;
			$nbbytes = strlen($s);
			for ($i = 0; $i < $nbbytes; $i++)
			{
				if (ord($s[$i])<128)
					$len++;
				else
				{
					$len++;
					$i++;
				}
			}
			return $len;
		}
		else
			return strlen($s);
	}


//-------------------------------------------htmlpdf---------------------------------------------------------------------



function WriteHTML($html)
{
	$this->B=0;
	$this->I=0;
	$this->U=0;
	$this->HREF='';

	$this->tableborder=0;
	$this->tdbegin=false;
	$this->tdwidth=0;
	$this->tdheight=0;
	$this->tdalign="L";
	$this->tdbgcolor=false;

	$this->oldx=0;
	$this->oldy=0;

	$this->fontlist=array("arial","times","courier","helvetica","symbol");
	$this->issetfont=false;
	$this->issetcolor=false;
	$html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><table><sup>"); //remove all unsupported tags
	$html=str_replace("\n",'',$html); //replace carriage returns by spaces
	$html=str_replace("\t",'',$html); //replace carriage returns by spaces
	$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //explodes the string
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			//Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			elseif($this->tdbegin) {
				if(trim($e)!='' && $e!="&nbsp;") {
					$this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
				}
				elseif($e=="&nbsp;") {
					$this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
				}
			}
			else
				$this->Write(5,stripslashes(txtentities($e)));
		}
		else
		{
			//Tag
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				//Extract attributes
				$a2=explode(' ',$e);
				$tag=strtoupper(array_shift($a2));
				$attr=array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])]=$a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}
}

function OpenTag($tag, $attr)
{
	//Opening tag
	switch($tag){

		case 'SUP':
			if( !empty($attr['SUP']) ) {	
				//Set current font to 6pt 	
				$this->SetFont('','',6);
				//Start 125cm plus width of cell to the right of left margin 		
				//Superscript "1" 
				$this->Cell(2,2,$attr['SUP'],0,0,'L');
			}
			break;

		case 'TABLE': // TABLE-BEGIN
			if( !empty($attr['BORDER']) ) $this->tableborder=$attr['BORDER'];
			else $this->tableborder=0;
			break;
		case 'TR': //TR-BEGIN
			break;
		case 'TD': // TD-BEGIN
			if( !empty($attr['WIDTH']) ) $this->tdwidth=($attr['WIDTH']/4);
			else $this->tdwidth=40; // Set to your own width if you need bigger fixed cells
			if( !empty($attr['HEIGHT']) ) $this->tdheight=($attr['HEIGHT']/6);
			else $this->tdheight=6; // Set to your own height if you need bigger fixed cells
			if( !empty($attr['ALIGN']) ) {
				$align=$attr['ALIGN'];		
				if($align=='LEFT') $this->tdalign='L';
				if($align=='CENTER') $this->tdalign='C';
				if($align=='RIGHT') $this->tdalign='R';
			}
			else $this->tdalign='L'; // Set to your own
			if( !empty($attr['BGCOLOR']) ) {
				$coul=hex2dec($attr['BGCOLOR']);
					$this->SetFillColor($coul['R'],$coul['G'],$coul['B']);
					$this->tdbgcolor=true;
				}
			$this->tdbegin=true;
			break;

		case 'HR':
			if( !empty($attr['WIDTH']) )
				$Width = $attr['WIDTH'];
			else
				$Width = $this->w - $this->lMargin-$this->rMargin;
			$x = $this->GetX();
			$y = $this->GetY();
			$this->SetLineWidth(0.2);
			$this->Line($x,$y,$x+$Width,$y);
			$this->SetLineWidth(0.2);
			$this->Ln(1);
			break;
		case 'STRONG':
			$this->SetStyle('B',true);
			break;
		case 'EM':
			$this->SetStyle('I',true);
			break;
		case 'B':
		case 'I':
		case 'U':
			$this->SetStyle($tag,true);
			break;
		case 'A':
			$this->HREF=$attr['HREF'];
			break;
		case 'IMG':
			if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
				if(!isset($attr['WIDTH']))
					$attr['WIDTH'] = 0;
				if(!isset($attr['HEIGHT']))
					$attr['HEIGHT'] = 0;
				$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
			}
			break;
		case 'BLOCKQUOTE':
		case 'BR':
			$this->Ln(5);
			break;
		case 'P':
			$this->Ln(10);
			break;
		case 'FONT':
			if (isset($attr['COLOR']) && $attr['COLOR']!='') {
				$coul=hex2dec($attr['COLOR']);
				$this->SetTextColor($coul['R'],$coul['G'],$coul['B']);
				$this->issetcolor=true;
			}
			if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
				$this->SetFont(strtolower($attr['FACE']));
				$this->issetfont=true;
			}
			if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist) && isset($attr['SIZE']) && $attr['SIZE']!='') {
				$this->SetFont(strtolower($attr['FACE']),'',$attr['SIZE']);
				$this->issetfont=true;
			}
			break;
	}
}

function CloseTag($tag)
{
	//Closing tag
	if($tag=='SUP') {
	}

	if($tag=='TD') { // TD-END
		$this->tdbegin=false;
		$this->tdwidth=0;
		$this->tdheight=0;
		$this->tdalign="L";
		$this->tdbgcolor=false;
	}
	if($tag=='TR') { // TR-END
		$this->Ln();
	}
	if($tag=='TABLE') { // TABLE-END
		//$this->Ln();
		$this->tableborder=0;
	}

	if($tag=='STRONG')
		$tag='B';
	if($tag=='EM')
		$tag='I';
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF='';
	if($tag=='FONT'){
		if ($this->issetcolor==true) {
			$this->SetTextColor(0);
		}
		if ($this->issetfont) {
			$this->SetFont('arial');
			$this->issetfont=false;
		}
	}
}

function SetStyle($tag, $enable)
{
	//Modify style and select corresponding font
	$this->$tag+=($enable ? 1 : -1);
	$style='';
	foreach(array('B','I','U') as $s) {
		if($this->$s>0)
			$style.=$s;
	}
	$this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
	//Put a hyperlink
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
}
function hcatatn(){
	$this->SetFont('Arial','B',12);
	$this->SetXY(15,242);
	$this->Cell(20,10,'Catatan :',0,1,'L');
}
function catatan($cttn){
	$this->SetFont('Arial','',10);
	$this->SetXY(15,250);
	$this->SetFillColor(254,254,254);
	$this->SetTextColor(0,0,0);	
	$this->Multicell(180,5,$cttn,0,1,'L');

	
}
function Contactus($a,$b,$c,$d)
{
	$this->SetFont('Arial','',10);
	$this->SetXY(15,210);
	$this->SetFillColor(254,254,254);
	$this->Multicell(100,5," Nama : ".$a."\n pin bb : ".$b."\n Email : ".$c."\n Hp : ".$d,1,1,'L');
}
function totalinv($total){
	$this->SetFont('Arial','',10);
	$this->SetX(14);
	$this->Cell(139,7,'Total ',1,0,'R');
	$this->Cell(40,7,$total.' ',1,0,'R');
}


}
?>
