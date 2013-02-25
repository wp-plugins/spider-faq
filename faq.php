<?php
/*
Plugin Name: Spider FAQ
Plugin URI: http://web-dorado.com/products/wordpress-faq-plugin.html
Version: 1.0
Author: http://web-dorado.com/
License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/
$many_faqs=0;
add_action( 'init', 'FAQ_language_load' );

function FAQ_language_load() {
	 load_plugin_textdomain('faq', false, basename( dirname( __FILE__ ) ) . '/Languages' );	
}

function Spider_FAQ_shotrcode($atts) {
     extract(shortcode_atts(array(
	      'id' => 'no Spider FAQ',
     ), $atts));
     return front_end_Spider_FAQ($id);
}

add_shortcode('Spider_FAQ', 'Spider_FAQ_shotrcode');



////
 function   front_end_Spider_FAQ($id){
 
 global $wpdb;
	 
	 $all_faq_ids=$wpdb->get_col("SELECT id FROM ".$wpdb->prefix."spider_faq_faq");
				$b=false;
				foreach($all_faq_ids as $all_faq_id)
				{
					if($all_faq_id==$id)
					$b=true;
				}
				if(!$b)
				return "";	
				
				$Spider_Faq_front_end="";
		
		
		$faq=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spider_faq_faq WHERE id=".$id);
		
		$faq_ids=$wpdb->get_col("SELECT id FROM ".$wpdb->prefix."spider_faq_faq");
		
		
		$cats_id=explode(',',$faq->category);
		$cats_id= array_slice($cats_id,1, count($cats_id)-2); 
		
		foreach($cats_id as $id)
	{
		$cats[]=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spider_faq_category WHERE published='1' AND id=".$id );
		
	}	
		
	
		$standcats_id=explode(',',$faq->standcategory);
		$standcats_id= array_slice($standcats_id,1, count($standcats_id)-2); 
		
		foreach($standcats_id as $id)
	{
		$standcats[]=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."terms WHERE term_id=".$id);
		
	}	
	
	$s=0;
	if ($faq->standcat==0)
	{
	if($cats)
					{
				foreach($cats as $cat)
				{
							
			$rows1 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."spider_faq_question WHERE published='1' AND category=".$cat->id." ORDER BY `ordering`" );	
							
						$rows[$cat->id] = $rows1;
						$s+=count($rows[$cat->id]);	
				}
				}
				
	}
	else{
	if($standcats)
					{
		foreach($standcats as $cat)
				{
					
	$args = array(
      'numberposts'     => 5000,
    'offset'          => 0,
    'category'        => $cat->term_id,
    'post_type'       => 'post',
     'post_status'     => 'publish' );
$rows[$cat->term_id] = get_posts($args);
$s+=count($rows[$cat->term_id]);	
	}
	}
	}
		
	$stls=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spider_faq_theme WHERE id=".$faq->theme);
		
	 front_end_faq ($rows,$cats,$standcats,$stls,$faq,$s);		
	}

	
	add_action( 'wp_enqueue_scripts', 'faq_add_my_stylesheet' );

    /**
     * Enqueue plugin style-file
     */
    function faq_add_my_stylesheet() {
        // Respects SSL, Style.css is relative to the current file
		
			 
        wp_register_style( 'faq-style', plugins_url('elements/style.css', __FILE__) );
             wp_enqueue_style( 'faq-style' );

		
        wp_enqueue_script( 'jquery' );
		
		 	 wp_register_script( 'effects.core.packed', plugins_url('elements/effects.core.packed.js', __FILE__) );
        wp_enqueue_script( 'effects.core.packed' );
		
		
		
		 	 wp_register_script( 'jquery.scrollTo', plugins_url('elements/jquery.scrollTo.js', __FILE__) );
        wp_enqueue_script( 'jquery.scrollTo' );
		
	
	
        wp_register_script( 'loewy_blog', plugins_url('elements/loewy_blog.js', __FILE__) );
             wp_enqueue_script( 'loewy_blog' );
		
    }

		
function front_end_faq($rows,$cats,$standcats,$stl,$faq,$s) {
global $wpdb;
global $many_faqs;

if($faq->standcat==0){
  if (isset($_POST["reset".$faq->id]))
{


  if ($_POST['search'.$faq->id]!="")
  {
  $_POST['search'.$faq->id]="";
  }

}
else
{


if (isset($_POST["submit".$faq->id]))
{

if($cats){
foreach($cats as $cat)
				{
				
				$rows1 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."spider_faq_question WHERE published='1' AND category=".$cat->id." AND (title LIKE '%".$_POST['search'.$faq->id]."%' OR article LIKE '%".$_POST['search'.$faq->id]."%')" );				
                $rows[$cat->id] = $rows1;
						
				}
				}
 }
else 
{

}
}
}
else{
 if (isset($_POST["reset".$faq->id]))
{
 if ($_POST['search'.$faq->id]!="")
  {
  $_POST['search'.$faq->id]="";
  }
}
else
{
if ($_POST["search".$faq->id]!="")
{

$k=0;
if($standcats){

foreach($standcats as $cat)
				{		
				$args = array(
      'numberposts'     => 5000,
    'offset'          => 0,
    'category'        => $cat->term_id,
    'post_type'       => 'post',
     'post_status'     => 'publish' );
$rows[$cat->term_id] = get_posts($args);

	for ($i=0;$i<count($rows[$cat->term_id]);$i++)
	{
	
	if(stripos($rows[$cat->term_id][$i]->post_title, $_POST['search'.$faq->id]) !== FALSE || stripos($rows[$cat->term_id][$i]->post_content, $_POST['search'.$faq->id]) !== FALSE)
	{
	
	$rows1[$cat->term_id][$k]=$rows[$cat->term_id][$i];
	$k++;
	
	}
	
	}

$k=0;

				}
	$rows=$rows1;			
				
				}
 }
}
}


if ($stl->ctpadding)
{
$cattpadding=explode(' ',$stl->ctpadding);
foreach($cattpadding as $padding)
{
if($padding=="")
break;
$ctpadding[]=$padding.'px';
}
$stl->ctpadding=implode(' ',$ctpadding);
}

if ($stl->ctmargin)
{
$cattmargin=explode(' ',$stl->ctmargin);
foreach($cattmargin as $margin)
{
if($margin=="")
break;
$ctmargin[]=$margin.'px';
}
$stl->ctmargin=implode(' ',$ctmargin);
}


if ($stl->cdmargin)
{
$catdmargin=explode(' ',$stl->cdmargin);
foreach($catdmargin as $margin)
{
if($margin=="")
break;
$cdmargin[]=$margin.'px';
}
$stl->cdmargin=implode(' ',$cdmargin);
}


if ($stl->cdpadding)
{
$catdpadding=explode(' ',$stl->cdpadding);
foreach($catdpadding as $padding)
{
if($padding=="")
break;
$cdpadding[]=$padding.'px';
}
$stl->cdpadding=implode(' ',$cdpadding);
}

if ($stl->amargin)
{
$ansmargin=explode(' ',$stl->amargin);
foreach($ansmargin as $margin)
{
if($margin=="")
break;
$amargin[]=$margin.'px';
}
$stl->amargin=implode(' ',$amargin);
}

if ($stl->amarginimage)
{
$ansmarginimage=explode(' ',$stl->amarginimage);
foreach($ansmarginimage as $margin)
{
if($margin=="")
break;
$amarginimage[]=$margin.'px';
}
$stl->amarginimage=implode(' ',$amarginimage);
}

if ($stl->amarginimage2)
{
$ansmarginimage2=explode(' ',$stl->amarginimage2);
foreach($ansmarginimage2 as $margin)
{
if($margin=="")
break;
$amarginimage2[]=$margin.'px';
}
$stl->amarginimage2=implode(' ',$amarginimage2);
}

if ($stl->expcolmargin)
{
$ecmargin=explode(' ',$stl->expcolmargin);
foreach($ecmargin as $margin)
{
if($margin=="")
break;
$expcolmargin[]=$margin.'px';
}
$stl->expcolmargin=implode(' ',$expcolmargin);
}

if ($stl->sformmargin)
{
$sfmargin=explode(' ',$stl->sformmargin);
foreach($sfmargin as $margin)
{
if($margin=="")
break;
$sformmargin[]=$margin.'px';
}
$stl->sformmargin=implode(' ',$sformmargin);
}


if($faq->expand=='1')
{
?>
<script>

$(window).load(function(){ iiiiiiiiiii=<?php echo $many_faqs ?>; $('.post_exp')[0].click();  faq_changeexp<?php echo $faq->id ?>();}) 

</script>
<?php
}
?>	



<style type="text/css" media="screen">	
#content<?php echo $faq->id ?>{
width: <?php echo $stl->width.'px' ?>!important;
}

#post_right<?php echo $faq->id ?> {
width: <?php echo $stl->twidth.'px' ?>;
}

#post_title<?php echo $faq->id ?> {
height: <?php echo $stl->theight.'px' ?>;
width: <?php echo $stl->twidth.'px' ?>;
border-style: <?php echo $stl->tbstyle ?>;
border-width:<?php echo $stl->tbwidth.'px' ?>;
border-color:<?php echo '#'.$stl->tbcolor ?>;
background-size: <?php echo $stl->tbgsize ?>;
background-repeat:no-repeat;
border-radius:<?php echo $stl->tbradius.'px' ?>;
<?php if($stl->titlebg==1) { if ($stl->tbgimage!="") { ?>
background-image:url('<?php echo  JURI::root()."administrator/".$stl->tbgimage ?>');
<?php }} else { if  ($stl->titlebggrad=="0") { ?>
background-color:#<?php echo $stl->tbgcolor ?>;
<?php } else { if($stl->gradtype!="circle") { ?>
background: -webkit-linear-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->gradcolor1 ?>,<?php echo '#'.$stl->gradcolor2 ?>);
background: -moz-linear-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->gradcolor1 ?>,<?php echo '#'.$stl->gradcolor2 ?>);
background: -o-linear-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->gradcolor1 ?>,<?php echo '#'.$stl->gradcolor2 ?>);
<?php } else { ?> 
background: -webkit-radial-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->gradcolor1 ?>,<?php echo '#'.$stl->gradcolor2 ?>);
background: -moz-radial-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->gradcolor1 ?>,<?php echo '#'.$stl->gradcolor2 ?>);
background: -o-radial-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->gradcolor1 ?>,<?php echo '#'.$stl->gradcolor2 ?>);
<?php } } } ?>
display:table;
}	

#tchangeimg<?php echo $faq->id ?>{
display: table-cell;
vertical-align: middle;
}


 .post_title #tchangeimg<?php echo $faq->id ?> img{
margin-left:<?php echo $stl->marginlimage1.'px' ?>;
}

#post_title<?php echo $faq->id ?>:hover{
 <?php if  ($stl->titlebggrad=="0") { ?>
background-color:#<?php echo $stl->tbghovercolor ?> !important;
<?php } else { if($stl->gradtype!="circle") { ?>
background: -webkit-linear-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->tbghovercolor ?>,<?php echo '#'.$stl->tbghovercolor ?>);
background: -moz-linear-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->tbghovercolor ?>,<?php echo '#'.$stl->tbghovercolor ?>);
background: -o-linear-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->tbghovercolor ?>,<?php echo '#'.$stl->tbghovercolor ?>);
<?php } else { ?> 
background: -webkit-radial-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->tbghovercolor ?>,<?php echo '#'.$stl->tbghovercolor ?>);
background: -moz-radial-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->tbghovercolor ?>,<?php echo '#'.$stl->tbghovercolor ?>);
background: -o-radial-gradient(<?php echo $stl->gradtype ?>,<?php echo '#'.$stl->tbghovercolor ?>,<?php echo '#'.$stl->tbghovercolor ?>);
<?php } }
?>
}


#ttext<?php echo $faq->id ?>{
width:<?php echo $stl->ttxtwidth.'%' ?>;
padding-left:<?php echo $stl->ttxtpleft.'px' ?>;
font-size:<?php echo $stl->tfontsize.'px' ?>;
color:<?php echo '#'.$stl->tcolor ?>;
display: table-cell;
vertical-align: middle;

}

#post_content_wrapper<?php echo $faq->id ?> {
width: <?php echo $stl->awidth.'px' ?>;
border-style: <?php echo $stl->abstyle ?>;
border-width:<?php echo $stl->abwidth.'px' ?>;
border-color:<?php echo '#'.$stl->abcolor ?>;
background-size: <?php echo $stl->abgsize ?>;
border-radius:<?php echo $stl->abradius.'px' ?>;
min-height:60px;
padding: 4px 0;
}
	
.post_content_wrapper #imgbefore<?php echo $faq->id ?> img{
width: <?php echo $stl->aimagewidth.'px' ?>;
height: <?php echo $stl->aimageheight.'px' ?>;
margin-top:<?php echo $stl->amarginimage ?>;
}

.post_content_wrapper #imgafter<?php echo $faq->id ?> img {
width: <?php echo $stl->aimagewidth2.'px' ?>;
height: <?php echo $stl->aimageheight2.'px' ?>;
margin-top:<?php echo $stl->amarginimage2 ?>;
}
	
#atext<?php echo $faq->id ?>{
margin:<?php echo $stl->amargin ?>;
font-size:<?php echo $stl->afontsize.'px' ?>;
color:<?php echo '#'.$stl->atxtcolor ?>;
}	


#searchform<?php echo $faq->id ?>{
margin: <?php echo $stl->sformmargin ?>;	
}

.searchform #skey<?php echo $faq->id ?> {
<?php if($stl->sboxbg == 0) { ?>
background:none;
<?php }
else {
?>
background-color: <?php echo '#'.$stl->sboxbgcolor ?> !important;
<?php } 
?>
width: <?php echo $stl->sboxwidth.'px' ?>;
height: <?php echo $stl->sboxheight.'px' ?> !important;
color: <?php echo '#'.$stl->sboxtcolor ?>;
font-size:<?php echo $stl->sboxfontsize.'px' ?>;
border-style: <?php echo $stl->sboxbstyle ?>;
border-width:<?php echo $stl->sboxbwidth.'px' ?>;
border-color:<?php echo '#'.$stl->sboxbcolor ?>;
}

.searchform #srbuts<?php echo $faq->id ?>  {
cursor: pointer;
<?php if($stl->srbg == 0){ ?>
background:none;
<?php } 
else {
?>
background-color: <?php echo '#'.$stl->srbgcolor ?>;
<?php } 
?>

width: <?php echo $stl->srwidth.'px' ?>;
height: <?php echo $stl->srheight.'px' ?>;
color: <?php echo '#'.$stl->srtcolor ?>;
font-size:<?php echo $stl->srfontsize.'px' ?>;
font-weight:<?php echo $stl->srfontweight ?> !important;
border-style: <?php echo $stl->srbstyle ?>;
border-width:<?php echo $stl->srbwidth.'px' ?>;
border-color:<?php echo '#'.$stl->srbcolor ?>;

}


#cattitle<?php echo $faq->id ?>	{
<?php if($stl->ctbg == 0){
	?>
background:none;
<?php } 
else { if($stl->ctbggrad == 0){
?>
background-color: <?php echo '#'.$stl->ctbgcolor ?>;
<?php } else { if($stl->ctgradtype!="circle") { ?>
background: -webkit-linear-gradient(<?php echo $stl->ctgradtype ?>,<?php echo '#'.$stl->ctgradcolor1 ?>,<?php echo '#'.$stl->ctgradcolor2 ?>);
background: -moz-linear-gradient(<?php echo $stl->ctgradtype ?>,<?php echo '#'.$stl->ctgradcolor1 ?>,<?php echo '#'.$stl->ctgradcolor2 ?>);
background: -o-linear-gradient(<?php echo $stl->ctgradtype ?>,<?php echo '#'.$stl->ctgradcolor1 ?>,<?php echo '#'.$stl->ctgradcolor2 ?>);
<?php } else { ?> 
background: -webkit-radial-gradient(<?php echo $stl->ctgradtype ?>,<?php echo '#'.$stl->ctgradcolor1 ?>,<?php echo '#'.$stl->ctgradcolor2 ?>);
background: -moz-radial-gradient(<?php echo $stl->ctgradtype ?>,<?php echo '#'.$stl->ctgradcolor1 ?>,<?php echo '#'.$stl->ctgradcolor2 ?>);
background: -o-radial-gradient(<?php echo $stl->ctgradtype ?>,<?php echo '#'.$stl->ctgradcolor1 ?>,<?php echo '#'.$stl->ctgradcolor2 ?>);
<?php }

}}
?>

color: <?php echo '#'.$stl->cttxtcolor ?>;
font-size:<?php echo $stl->ctfontsize.'px' ?>;
padding:<?php echo $stl->ctpadding ?>;
margin:<?php echo $stl->ctmargin ?>;
border-radius:<?php echo $stl->ctbradius.'px' ?>;
border-style: <?php echo $stl->ctbstyle ?>;
border-width:<?php echo $stl->ctbwidth.'px' ?>;
border-color:<?php echo '#'.$stl->ctbcolor ?>;
}
	
#catdes<?php echo $faq->id ?>{
<?php if($stl->cdbg == 0){
	?>
background:none;
<?php } 
else { if($stl->cdbggrad == 0){
?>
background-color: <?php echo '#'.$stl->cdbgcolor ?>;
<?php } else { if($stl->cdgradtype!="circle") { ?>
background: -webkit-linear-gradient(<?php echo $stl->cdgradtype ?>,<?php echo '#'.$stl->cdgradcolor1 ?>,<?php echo '#'.$stl->cdgradcolor2 ?>);
background: -moz-linear-gradient(<?php echo $stl->cdgradtype ?>,<?php echo '#'.$stl->cdgradcolor1 ?>,<?php echo '#'.$stl->cdgradcolor2 ?>);
background: -o-linear-gradient(<?php echo $stl->cdgradtype ?>,<?php echo '#'.$stl->cdgradcolor1 ?>,<?php echo '#'.$stl->cdgradcolor2 ?>);
<?php } else { ?> 
background: -webkit-radial-gradient(<?php echo $stl->cdgradtype ?>,<?php echo '#'.$stl->cdgradcolor1 ?>,<?php echo '#'.$stl->cdgradcolor2 ?>);
background: -moz-radial-gradient(<?php echo $stl->cdgradtype ?>,<?php echo '#'.$stl->cdgradcolor1 ?>,<?php echo '#'.$stl->cdgradcolor2 ?>);
background: -o-radial-gradient(<?php echo $stl->cdgradtype ?>,<?php echo '#'.$stl->cdgradcolor1 ?>,<?php echo '#'.$stl->cdgradcolor2 ?>);
<?php }

}}
?>

color: <?php echo '#'.$stl->cdtxtcolor ?>;
font-size:<?php echo $stl->cdfontsize.'px' ?>;
margin:<?php echo $stl->cdmargin ?>;	
padding:<?php echo $stl->cdpadding ?>;
border-radius:<?php echo $stl->cdbradius.'px' ?>;
border-style: <?php echo $stl->cdbstyle ?>;
border-width:<?php echo $stl->cdbwidth.'px' ?>;
border-color:<?php echo '#'.$stl->cdbcolor ?>;
}	
	
	a.post_exp, a.post_coll, #post_expcol<?php echo $faq->id ?> {
color:<?php echo '#'.$stl->expcolcolor ?> ;
font-size:<?php echo $stl->expcolfontsize.'px' ?>;
}

a.post_exp:hover, a.post_coll:hover, #post_expcol<?php echo $faq->id ?>:hover {
color:<?php echo '#'.$stl->expcolhovercolor ?> !important;
background:none !important;
}

.expcoll, #expcol<?php echo $faq->id ?> {
margin:<?php echo $stl->expcolmargin ?>;
color:<?php echo '#'.$stl->expcolcolor ?> ;
}

a.more-link, #more-link<?php echo $faq->id ?>{
color:<?php echo '#'.$stl->rmcolor ?> !important; 
font-size:<?php echo $stl->rmfontsize.'px' ?> !important; ;
}

a.more-link, #more-link<?php echo $faq->id ?>:hover{
color:<?php echo '#'.$stl->rmhovercolor ?> !important; ;
}
</style>


	
	

	
<script>
var change = true;

function faq_changesrc<?php echo $faq->id ?>(x)
{
if (document.getElementById('stl<?php echo $faq->id ?>'+x))
{

if(change) {
change = false;

if (document.getElementById('stl<?php echo $faq->id ?>'+x).src=="<?php echo $stl->tchangeimage1; ?>")
{
document.getElementById('stl<?php echo $faq->id ?>'+x).src="<?php echo $stl->tchangeimage2; ?>";
document.getElementById('stl<?php echo $faq->id ?>'+x).style.marginLeft="<?php echo $stl->marginlimage2.'px' ?>";

}
else
{
document.getElementById('stl<?php echo $faq->id ?>'+x).src="<?php echo $stl->tchangeimage1; ?>";
document.getElementById('stl<?php echo $faq->id ?>'+x).style.marginLeft="<?php echo $stl->marginlimage1.'px' ?>";

}

}

setTimeout("change=true",400);
}
}



var changeall = true;
function faq_changeexp<?php echo $faq->id ?>()
{

for (i=0; i<<?php echo $s ?>; i++)
{

if (document.getElementById('stl<?php echo $faq->id ?>'+i))
{

document.getElementById('stl<?php echo $faq->id ?>'+i).src="<?php echo $stl->tchangeimage2; ?>";
document.getElementById('stl<?php echo $faq->id ?>'+i).style.marginLeft="<?php echo $stl->marginlimage2.'px' ?>";

}
}
}


function faq_changecoll<?php echo $faq->id ?>()
{
if(changeall) {
changeall = false;
for (i=0; i<<?php echo $s ?>; i++)
{
if (document.getElementById('stl<?php echo $faq->id ?>'+i))
{
document.getElementById('stl<?php echo $faq->id ?>'+i).src="<?php echo $stl->tchangeimage1; ?>";
document.getElementById('stl<?php echo $faq->id ?>'+i).style.marginLeft="<?php echo $stl->marginlimage1.'px' ?>";

}
}
}
setTimeout("changeall=true",400);
}
</script>	
		

<body>
		<div id="contentOuter"><div id="contentInner">
  <div class="content" id="<?php echo 'content'.$faq->id ?>" >
  
<ul class="posts" style="<?php if ($stl->background=="0") { ?> background-color:<?php echo '#'.$stl->bgcolor;  } else { if ($stl->background=="1") {  if ($stl->bgimage!="") { ?> background-image:url(<?php echo $stl->bgimage ?>) <?php } } }?> ">				                                                                             
			<!-- Loop Starts -->
			<li class="selected" id="post-1236" >

<?php if ($faq->show_searchform == 1)
{ 
?>

<form class="searchform" id="<?php echo 'searchform'.$faq->id ?>" action="<?php echo  $_SERVER['REQUEST_URI']; ?>" method="post">
 
 <div align="right"><input type="text" class="search_keyword" id="<?php echo 'skey'.$faq->id ?>" name="search<?php echo $faq->id ?>"  value="<?php if(isset($_POST['search'.$faq->id])) { echo $_POST['search'.$faq->id]; } ?>"  /></div>
	<div align="right" style="margin-top:10px;"><input class="search_button" id="<?php echo 'srbuts'.$faq->id ?>" type="submit" name="submit<?php echo $faq->id ?>" value="<?php echo __("Search","faq"); ?>"/>
		              <input class="reset_button"  id="<?php echo 'srbuts'.$faq->id ?>" type="submit"  name="reset<?php echo $faq->id ?>" value="<?php echo __("Reset","faq"); ?>"/>
	</div>
		</form>
		
		
<?php	
}
if ($faq->standcat==0)
{	
$a=false;
if ($cats)
{
foreach($cats as $cat)
 {

$a=true;
}
}

if($a)
{
echo '<div class="expcoll" id="expcol'.$faq->id. '">
     <a  class="post_exp" id="post_expcol'.$faq->id. '"><span onclick=" iiiiiiiiiii='.$many_faqs.'; faq_changeexp'.$faq->id.'()">'.__("Expand All","faq").' </span></a><span>|</span>
     <a  class="post_coll" id="post_expcol'.$faq->id. '"><span onclick="jjjjjjjjjjj='.$many_faqs.'; faq_changecoll'.$faq->id.'()">'.__("Collapse All","faq").'</span></a></div>';
}


	 $n=0;
	 if ($cats)
{
foreach($cats as $cat)
 {


if ($cat->show_title==1)
{
if ($cat->title=="Uncategorized")
echo '<div class="cattitle" id="cattitle'.$faq->id. '" >'.__("Uncategorized","faq").'</div>';
else
echo '<div class="cattitle" id="cattitle'.$faq->id. '">'.$cat->title.'</div>';
}
if ($cat->show_description==1 && $cat->description!="")
echo '<div class="catdes" id="catdes'.$faq->id. '" >'.$cat->description.'</div>';
else{
echo '<div style="padding-top:18px"></div>';
}


if(count($rows[$cat->id]))
{
$p=1;
 for ($i=0;$i<count($rows[$cat->id]);$i++)
 {
 $row = &$rows[$cat->id][$i];


	echo '</li><li id="post-1236" class="selected" style="margin-left:'.$stl->marginleft.'px !important"><div class="post_top">
				  <div class="post_right" id="post_right'.$faq->id.'">
					  <a href="#" class="post_ajax_title"><span onclick="faq_changesrc'.$faq->id.'('.$n.')"><h2 class="post_title" id="post_title'.$faq->id.'" style="'?><?php if($stl->titlebg==1) { if ($stl->tbgimage!="") { echo 'background-image:url('.$stl->tbgimage.')'?><?php } echo '">' ?><?php } else echo 'background-color:#'.$stl->tbgcolor.'">
					  '?><?php if ($stl->tchangeimage1!=""){ echo'<div class="tchangeimg" id="tchangeimg'.$faq->id.'"><img src="'.$stl->tchangeimage1.'"  id="stl'.$faq->id.$n.'" /></div>'  ?><?php } echo '<div class="ttext" id="ttext'.$faq->id.'">'.$p.'. '.$row->title.'</div></h2></span></a>
				    </div>
			    </div>';
			if (strlen($row->fullarticle)>1){
			echo '<div class="post_content">
				  <div class="post_content_wrapper" id="post_content_wrapper'.$faq->id.'" style="'?><?php if($stl->abg==1) { if ($stl->abgimage!="") { echo 'background-image:url('.$stl->abgimage.')'?><?php } echo '">' ?><?php } else echo 'background-color:#'.$stl->abgcolor.'">
				    '?><?php if ($stl->aimage!=""){ echo'<div class="imgbefore" id="imgbefore'.$faq->id. '"><img src="'.$stl->aimage.'"  /></div>'  ?><?php } echo '<div class="post_right" id="post_right'.$faq->id.'"><div class="atext" id="atext'.$faq->id. '">'.$row->article.'<p><a href="#" class="more-link" id="more-link'.$faq->id. '">More</a></p>
			            <div class="post_content_more" style="margin-top:-6px;">'.$row->fullarticle.'</div>	    
			               </div></div>'?><?php if ($stl->aimage2!=""){ echo'<div class="imgafter" id="imgafter'.$faq->id. '"><img src="'.$stl->aimage2.'"  /></div>'  ?><?php } echo '
			       </div></div>
				</li>';
			
			}
			else{
			echo '<div class="post_content">
				  <div class="post_content_wrapper" id="post_content_wrapper'.$faq->id.'" style="'?><?php if($stl->abg==1) { if ($stl->abgimage!="") { echo 'background-image:url('.$stl->abgimage.')'?><?php } echo '">' ?><?php } else echo 'background-color:#'.$stl->abgcolor.'">
				    '?><?php if ($stl->aimage!=""){ echo'<div class="imgbefore" id="imgbefore'.$faq->id. '"><img src="'.$stl->aimage.'"  /></div>'  ?><?php } echo '<div class="post_right" id="post_right'.$faq->id.'"><div class="atext" id="atext'.$faq->id. '">'.$row->article.'	    
			               </div></div>'?><?php if ($stl->aimage2!=""){ echo'<div class="imgafter" id="imgafter'.$faq->id. '"><img src="'.$stl->aimage2.'"  /></div>'  ?><?php } echo '
			       </div></div>
				</li>';
			
		}

	echo '<div style="padding-bottom:'.$stl->paddingbq.'px"></div>';	
		
	$n++;	
	$p++;	
}

	
	}
	else{
if(isset($_POST['submit'.$faq->id]))
{
echo 'Question(s) not found';
}
else
echo 'There are no questions in this category';	
	
	}
	echo '<div style="padding-bottom:30px;"></div>';	
	}
	}
	}
	
	else{                               	/////////////// stand category////////////////////
$a=false;
if ($standcats)
{
foreach($standcats as $cat)
 {

$a=true;
}
}

if($a)
{	
echo '<div class="expcoll" id="expcol'.$faq->id. '">
     <a  class="post_exp" id="post_expcol'.$faq->id. '"><span onclick="iiiiiiiiiii='.$many_faqs.'; faq_changeexp'.$faq->id.'()">'.__("Expand All","faq").' </span></a><span>|</span>
     <a  class="post_coll" id="post_expcol'.$faq->id. '"><span onclick="jjjjjjjjjjj='.$many_faqs.'; faq_changecoll'.$faq->id.'()">'.__("Collapse All","faq").'</span></a></div>';
}	
	
	
$k=0;	
if ($standcats)
{
foreach($standcats as $cat)
 {



if ($cat->name=="")
{
echo '<div style="padding-bottom:60px"></div>';
}
else
echo '<div class="cattitle" id="cattitle'.$faq->id. '">'.$cat->name.'</div>';
if (category_description($cat->term_id)!="")
echo '<div class="catdes" id="catdes'.$faq->id. '">'.category_description($cat->term_id).'</div>';
else{
echo '<div style="padding-top:18px"></div>';
}

if(count($rows[$cat->term_id])){
 for ($i=0;$i<count($rows[$cat->term_id]);$i++)
 {
 $row = &$rows[$cat->term_id][$i];

if (stripos($row->post_content, "<!--more-->") !== false)
{

$answer1=explode('<!--more-->',$row->post_content);
$row->text=$answer1[0];
$row->fulltext=$answer1[1];

}
else{
$row->text=$row->post_content;
$row->fulltext='';
}
 
 

	echo '</li><li id="post-1236" class="selected" style="margin-left:'.$stl->marginleft.'px !important"><div class="post_top">
				  <div class="post_right" id="post_right'.$faq->id.'">
					  <a href="#" class="post_ajax_title"><span onclick="faq_changesrc'.$faq->id.'('.$k.')"><h2 class="post_title" id="post_title'.$faq->id.'" style="'?><?php if ($stl->tbgimage!="") { echo 'background-image:url('.$stl->tbgimage.')'?><?php } echo '">
					  '?><?php if ($stl->tchangeimage1!=""){ echo'<div class="tchangeimg" id="tchangeimg'.$faq->id.'"><img src="'.$stl->tchangeimage1.'" id="stl'.$faq->id.$k.'" /></div>'  ?><?php } echo '<div class="ttext" id="ttext'.$faq->id.'">'.$row->post_title.'</div></h2></span></a>
				    </div>
			    </div>';
			if (strlen($row->fulltext)>1){
			echo '<div class="post_content">
				  <div class="post_content_wrapper" id="post_content_wrapper'.$faq->id.'" style="'?><?php if($stl->abg==1) {  if ($stl->abgimage!="") { echo 'background-image:url('.$stl->abgimage.')'?><?php } echo '">' ?><?php } else echo 'background-color:#'.$stl->abgcolor.'">
				    '?><?php if ($stl->aimage!=""){ echo'<div class="imgbefore" id="imgbefore'.$faq->id. '"><img src="'.$stl->aimage.'"  /></div>'  ?><?php } echo '<div class="post_right" id="post_right'.$faq->id.'"><div class="atext" id="atext'.$faq->id. '">'.$row->text.'<p><a href="#" class="more-link">More</a></p>
			            <div class="post_content_more" style="margin-top:-6px;">'.$row->fulltext.'</div>	    
			               </div></div>'?><?php if ($stl->aimage2!=""){ echo'<div class="imgafter" id="imgafter'.$faq->id. '"><img src="'.$stl->aimage2.'"  /></div>'  ?><?php } echo '
			       </div></div>
				</li>';		
			}
			else{
			echo '<div class="post_content">
				  <div class="post_content_wrapper" id="post_content_wrapper'.$faq->id.'" style="'?><?php if($stl->abg==1) {  if ($stl->abgimage!="") { echo 'background-image:url('.$stl->abgimage.')'?><?php } echo '">' ?><?php } else echo 'background-color:#'.$stl->abgcolor.'">
				    '?><?php if ($stl->aimage!=""){ echo'<div class="imgbefore" id="imgbefore'.$faq->id. '"><img src="'.$stl->aimage.'"  /></div>'  ?><?php } echo '<div class="post_right" id="post_right'.$faq->id.'"><div class="atext" id="atext'.$faq->id. '">'.$row->post_content.'	    
			               </div></div>'?><?php if ($stl->aimage2!=""){ echo'<div class="imgafter" id="imgafter'.$faq->id. '"><img src="'.$stl->aimage2.'"  /></div>'  ?><?php } echo '
			       </div></div>
				</li>';
}
	echo '<div style="padding-bottom:'.$stl->paddingbq.'px"></div>';	
		
	$k++;	

}

}

else{
if(isset($_POST['submit'.$faq->id]))
{
echo 'Question(s) not found';
}
else
echo 'There are no questions in this category';

}
	
	echo '<div style="padding-bottom:30px;"></div>';
	}
	}	
	}	
$many_faqs++;
?>
		</ul>		
	  </div></div>	  	

<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
	try {
		var pageTracker = _gat._getTracker("UA-9222847-1");
		// Cookied already: 
		pageTracker._trackPageview();
	} catch(err) {}
</script>
</body>1

<?php
}
//// add editor new mce button
add_filter('mce_external_plugins', "Spider_Faq_register");
add_filter('mce_buttons', 'Spider_Faq_add_button', 0);

/// function for add new button
function Spider_Faq_add_button($buttons)
{
    array_push($buttons, "Spider_Faq_mce");
    return $buttons;
}


 /// function for registr new button
function Spider_Faq_register($plugin_array)
{   
    $url = plugins_url( 'js/editor_plugin.js' , __FILE__ ); 
    $plugin_array["Spider_Faq_mce"] = $url;
    return $plugin_array;	
}


function add_button_style_Spider_Faq()
{
echo '<style type="text/css">
.wp_themeSkin span.mce_Spider_Faq_mce {background:url('.plugins_url( 'images/faq.png' , __FILE__ ).') no-repeat !important; margin-left:1px; margin-top:1px;}
.wp_themeSkin .mceButtonEnabled:hover span.mce_Spider_Faq_mce,.wp_themeSkin .mceButtonActive span.mce_Spider_Faq_mce
{background:url('.plugins_url( 'images/faq_hover.png' , __FILE__ ).') no-repeat !important;}
</style>';
}

add_action('admin_head', 'add_button_style_Spider_Faq');



add_action('admin_menu', 'Spider_Faq_options_panel');
function Spider_Faq_options_panel(){
  add_menu_page(	'Theme page title', 'Spider FAQ', 'manage_options', 'Spider_Faq', 'Spider_Faq')  ;
  add_submenu_page( 'Spider_Faq', 'Spider Faq', 'FAQs', 'manage_options', 'Spider_Faq', 'Spider_Faq');
   add_submenu_page( 'Spider_Faq', 'Questions', 'Questions', 'manage_options', 'Spider_Faq_Questions', 'Spider_Faq_Questions');
  add_submenu_page( 'Spider_Faq', 'Categories', 'Categories', 'manage_options', 'Spider_Faq_Categories', 'Spider_Faq_Categories');
  $page_theme=add_submenu_page( 'Spider_Faq', 'Themes', 'Themes', 'manage_options', 'Spider_Faq_Themes', 'Spider_Faq_Themes');
   add_submenu_page( 'Spider_Faq', 'Licensing', 'Licensing', 'manage_options', 'Spider_FAQ_Licensing', 'Spider_FAQ_Licensing');

  add_submenu_page( 'Spider_Faq', 'Uninstall Spider_Faq ', 'Uninstall Spider FAQ', 'manage_options', 'Uninstall_Spider_FAQ', 'Uninstall_Spider_Faq');
	add_action('admin_print_styles-' . $page_theme, 'sp_faq_admin_styles_scripts');
  }
  
  function Spider_FAQ_Licensing(){
	?>
    
   <div style="width:95%"> <p>
This plugin is the non-commercial version of the Spider FAQ. Use of the FAQ is free.<br /> The only
limitation is the use of the themes. If you want to use one of the 17 standard themes or create a new one that
satisfies the needs of your web site, you are required to purchase a license.<br /> Purchasing a license will add 17
standard themes and give possibility to edit the themes of the Spider FAQ. </p>
<br /><br />
<a href="http://web-dorado.com/files/fromFAQWP.php" class="button-primary" target="_blank">Purchase a License</a>
<br /><br /><br />
<p>After the purchasing the commercial version follow this steps:</p>
<ol>
	<li>Deactivate Spider FAQ Plugin</li>
	<li>Delete Spider FAQ Plugin</li>
	<li>Install the downloaded commercial version of the plugin</li>
</ol>
</div>

    
    
    <?php
	
	
	}
  
   function sp_faq_admin_styles_scripts()
  {
	 if(get_bloginfo('version')>3.3){
	wp_enqueue_script("jquery");
	
	}
	else
	{
		 wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js');
		wp_enqueue_script( 'jquery' );
	

	}
	
	wp_enqueue_script("colcor_js",plugins_url('jscolor/jscolor.js', __FILE__));
	wp_enqueue_script("theme_reset",plugins_url('js/theme_reset.js', __FILE__));
	
  }



require_once("nav_function/nav_html_func.php");

add_filter('admin_head','faq_ShowTinyMCE');
function faq_ShowTinyMCE() {
	// conditions here
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}

function Spider_Faq()
{
global $wpdb;
	require_once("spider_faq_functions.php");
	require_once("spider_faq_functions.html.php");
	

	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
	
		$id=$_GET["id"];
		
	}
	else
	{
		$id=0;
	
	}
	
	
	switch($task){
	case 'Spider_Faq':
		show_spider_faq();
		break;
		

	
	case 'add_Spider_Faq':
		add_spider_faq();
		break;
	
	
	case 'save':
	if($id)
	{	
	
	apply_spider_faq($id);
		
	}
	else
	{
		save_spider_faq();
	}
		show_spider_faq();
		break;
			
	case 'apply':

		if($id)	
		{
			
			apply_spider_faq($id);
		}
		else
		{
			
			save_spider_faq();
			$id=$wpdb->get_var("SELECT MAX(id) FROM ".$wpdb->prefix."spider_faq_faq");
		}
		
		edit_spider_faq($id);
		break;	
		

		
	case 'edit_Spider_Faq':
       
	   edit_spider_faq($id);
		break;	

	
	case 'remove_Spider_Faq':
		remove_spider_faq($id);
		show_spider_faq();
		break;
			
		
			default:
			show_spider_faq();
			break;
	}
}

function Spider_Faq_Questions()
{
global $wpdb;
	require_once("spider_faq_question_functions.php");// add functions for player
	require_once("spider_faq_question_functions.html.php");// add functions for vive player
	

	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
	
		$id=$_GET["id"];
		
	}
	else
	{
		$id=0;
	}
	
	
	
	
switch($task){
	case 'Spider_Faq_Questions':
		show_spider_ques();
		break;
		case "unpublish_Spider_Faq_Questions":
		change_spider_ques($id);		
		show_spider_ques();
		
		break;
	


	
	case 'add_Spider_Faq_Questions':
		add_spider_ques();
		break;
	
	
	case 'save':
	if($id)
	{		
	apply_spider_ques($id);
		
	}
	else
	{
		save_spider_ques();
	}
		show_spider_ques();
		break;
			
	case 'apply':	
		if($id)	
		{
			
			apply_spider_ques($id);
		}
		else
		{
			
			save_spider_ques();
			$id=$wpdb->get_var("SELECT MAX(id) FROM ".$wpdb->prefix."spider_faq_question");
		}
		
		edit_spider_ques($id);
		break;	
		

		
	case 'edit_Spider_Faq_Questions':
	
        edit_spider_ques($id);
   	
    		break;	
	

	
	case 'remove_Spider_Faq_Questions':
		remove_spider_ques($id);
		show_spider_ques();
		break;
			
	
			default:
			show_spider_ques();
			break;
	}
}

function Spider_Faq_Categories()
{
global $wpdb;
	require_once("spider_faq_category_functions.php");// add functions for player
	require_once("spider_faq_category_functions.html.php");// add functions for vive player
	

	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
	
		$id=$_GET["id"];
		
	}
	else
	{
		$id=0;
	
	}
		
	
	
	switch($task){
	case 'Spider_Faq_Categories':
		show_spider_cat();
		break;
		case "unpublish_Spider_Faq_Categories":
		change_spider_cat($id);		
		show_spider_cat();
		
		break;
	
	
	case 'add_Spider_Faq_Categories':
		add_spider_cat();
		break;
	
	
	case 'save':
	if($id)
	{	
	
	apply_spider_cat($id);
		
	}
	else
	{
		save_spider_cat();
	}
		show_spider_cat();
		break;
			
	case 'apply':	
		if($id)	
		{
			
			apply_spider_cat($id);
		}
		else
		{
			
			save_spider_cat();
			$id=$wpdb->get_var("SELECT MAX(id) FROM ".$wpdb->prefix."spider_faq_category");
		}
		
		edit_spider_cat($id);
		break;	
		

		
	case 'edit_Spider_Faq_Categories':
		
        edit_spider_cat($id);
		
			
    		break;	
	


	
	case 'remove_Spider_Faq_Categories':
		remove_spider_cat($id);
		show_spider_cat();
		break;
			
	
		
		
			default:
			show_spider_cat();
			break;
	}
}



function Spider_Faq_Themes(){
global $wpdb;
	require_once("spider_faq_theme_functions.php");// add functions for player

	

	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
	
		$id=$_GET["id"];
		
	}
	else
	{
		$id=0;
	}
	
	
	
	
	switch($task){
	case 'Spider_Faq_Themes':
		show_spider_theme();
		break;
		

	
	
			default:
			show_spider_theme();
			break;
	}
}





//////////////////////////////////////////////////////////////////////////actions for popup and xmls
require_once('functions_for_ajax_and_xml.php'); //include all functions for down call ajax
add_action('wp_ajax_spiderFaqselectfaq'			,   'spider_faq_select_faq');
add_action('wp_ajax_spiderFaqselectcategory' 	,     'spider_faq_select_category');
add_action('wp_ajax_spiderFaqselectstandcategory'	, 'spider_faq_select_standcategory');




function Uninstall_Spider_FAQ(){
global $wpdb;
$base_name = plugin_basename('Spider_Faq');
$base_page = 'admin.php?page='.$base_name;
$mode = trim($_GET['mode']);


if(!empty($_POST['do'])) {

	if($_POST['do']=="UNINSTALL Spider FAQ") {
			check_admin_referer('Spider_Faq uninstall');
			if(trim($_POST['Spider_FAQ_yes']) == 'yes') {
				
				echo '<div id="message" class="updated fade">';
				echo '<p>';
				echo "Table 'spider_faq_question' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spider_faq_question");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo '<p>';
				echo "Table 'spider_faq_category' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spider_faq_category");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo "Table 'spider_faq_theme' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spider_faq_theme");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
                echo '<p>';
				echo "Table 'spider_faq_faq' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spider_faq_faq");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';				
				echo '</div>'; 
				
				$mode = 'end-UNINSTALL';
			}
		}
    }



switch($mode) {
		case 'end-UNINSTALL':
			$deactivate_url = wp_nonce_url('plugins.php?action=deactivate&amp;plugin='.plugin_basename(__FILE__), 'deactivate-plugin_'.plugin_basename(__FILE__));
			echo '<div class="wrap">';
			echo '<h2>Uninstall Spider FAQ</h2>';
			echo '<p><strong>'.sprintf('<a href="%s">Click Here</a> To Finish The Uninstallation And Spider FAQ Will Be Deactivated Automatically.', $deactivate_url).'</strong></p>';
			echo '</div>';
			break;
	// Main Page
	default:
?>
<form method="post" action="<?php echo admin_url('admin.php?page=Uninstall_Spider_FAQ'); ?>">
<?php wp_nonce_field('Spider_Faq uninstall'); ?>
<div class="wrap">
	<div id="icon-Spider_Faq" class="icon32"><br /></div>
	<h2><?php echo 'Uninstall Spider FAQ'; ?></h2>
	<p>
		<?php echo 'Deactivating Spider FAQ plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.'; ?>
	</p>
	<p style="color: red">
		<strong><?php echo 'WARNING:'; ?></strong><br />
		<?php echo 'Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.'; ?>
	</p>
	<p style="color: red">
		<strong><?php echo 'The following WordPress Options/Tables will be DELETED:'; ?></strong><br />
	</p>
	<table class="widefat">
		<thead>
			<tr>
				<th><?php echo 'WordPress Tables'; ?></th>
			</tr>
		</thead>
		<tr>
			<td valign="top">
				<ol>
				<?php
						echo '<li>spider_faq_faq</li>'."\n";
						echo '<li>spider_faq_question</li>'."\n";
						echo '<li>spider_faq_category</li>'."\n";
						echo '<li>spider_faq_theme</li>'."\n";
						
				?>
				</ol>
			</td>
		</tr>
	</table>
	<p style="text-align: center;">
		<?php echo 'Do you really want to uninstall Spider FAQ?'; ?><br /><br />
		<input type="checkbox" name="Spider_FAQ_yes" value="yes" />&nbsp;<?php echo 'Yes'; ?><br /><br />
		<input type="submit" name="do" value="<?php echo 'UNINSTALL Spider FAQ'; ?>" class="button-primary" onclick="return confirm('<?php echo 'You Are About To Uninstall Spider FAQ From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.'; ?>')" />
	</p>
</div>
</form>
<?php
} // End switch($mode)	
}



function Spider_FAQ_activate()
{
global $wpdb;

$sql_faq="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."spider_faq_faq` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `standcat` tinyint(1) NOT NULL,
  `category`  varchar(255) NOT NULL,
  `standcategory`  varchar(255) NOT NULL, 
  `theme` varchar(255) NOT NULL,
  `show_searchform` tinyint(1) NOT NULL,
  `expand` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

$sql_question="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."spider_faq_question` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
    `category` int(11) NOT NULL,
  `article` longtext NOT NULL,
  `fullarticle` longtext NOT NULL,
  `ordering` int(11) NOT NULL, 
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


$sql_category="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."spider_faq_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `show_title` tinyint(1) NOT NULL,
  `show_description` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";



$sql_theme="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."spider_faq_theme` (
`id` int(10) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `background` tinyint(2) NOT NULL,
  `bgimage` varchar(200) NOT NULL,
  `bgcolor` text NOT NULL,
  `width` varchar(200) NOT NULL,
  `ctbg` tinyint(1) NOT NULL,
  `ctbggrad` tinyint(1) NOT NULL,
  `ctbgcolor` text NOT NULL,
  `ctgradtype` varchar(200) NOT NULL,
  `ctgradcolor1` text NOT NULL,
  `ctgradcolor2` text NOT NULL,
  `cttxtcolor` text NOT NULL,
  `ctfontsize` varchar(200) NOT NULL,
  `ctmargin` varchar(200) NOT NULL,
  `ctpadding` varchar(200) NOT NULL,
  `ctbstyle` text NOT NULL,
  `ctbwidth` varchar(200) NOT NULL,
  `ctbcolor` text NOT NULL,
  `ctbradius` varchar(200) NOT NULL,
  `cdbg` tinyint(1) NOT NULL,
  `cdbggrad` tinyint(1) NOT NULL,
  `cdbgcolor` text NOT NULL,
  `cdgradtype` varchar(200) NOT NULL,
  `cdgradcolor1` text NOT NULL,
  `cdgradcolor2` text NOT NULL,
  `cdtxtcolor` text NOT NULL,
  `cdfontsize` varchar(200) NOT NULL,
  `cdmargin` varchar(200) NOT NULL,
  `cdpadding` varchar(200) NOT NULL,
  `cdbstyle` varchar(200) NOT NULL,
  `cdbwidth` varchar(200) NOT NULL,
  `cdbcolor` text NOT NULL,
  `cdbradius` varchar(200) NOT NULL,
  `paddingbq` varchar(200) NOT NULL,
  `marginleft` varchar(200) NOT NULL,
  `theight` varchar(200) NOT NULL,
  `twidth` varchar(200) NOT NULL,
  `tfontsize` varchar(200) NOT NULL,
  `ttxtwidth` varchar(200) NOT NULL,
  `ttxtpleft` varchar(200) NOT NULL,
  `tcolor` text NOT NULL,
  `titlebg` tinyint(1) NOT NULL,
  `tbgcolor` text NOT NULL,
  `tbgimage` varchar(200) NOT NULL,
  `titlebggrad` tinyint(1) NOT NULL,
  `gradtype` varchar(200) NOT NULL,
  `gradcolor1` text NOT NULL,
  `gradcolor2` text NOT NULL,
  `tbghovercolor` text NOT NULL,
  `tbgsize` varchar(200) NOT NULL,
  `tbstyle` varchar(200) NOT NULL,
  `tbwidth` varchar(200) NOT NULL,
  `tbcolor` text NOT NULL,
  `tbradius` varchar(200) NOT NULL,
  `tchangeimage1` varchar(200) NOT NULL,
  `marginlimage1` varchar(200) NOT NULL,
  `tchangeimage2` varchar(200) NOT NULL,
  `marginlimage2` varchar(200) NOT NULL,
  `awidth` varchar(200) NOT NULL,
  `amargin` varchar(200) NOT NULL,
  `afontsize` varchar(200) NOT NULL,
  `abg` tinyint(1) NOT NULL,
  `abgcolor` text NOT NULL,
  `abgimage` varchar(200) NOT NULL,
  `abgsize` varchar(200) NOT NULL,
  `abstyle` varchar(200) NOT NULL,
  `abwidth` varchar(200) NOT NULL,
  `abcolor` text NOT NULL,
  `abradius` varchar(200) NOT NULL,
  `aimage` varchar(200) NOT NULL,
  `aimage2` varchar(200) NOT NULL,
  `aimagewidth` varchar(200) NOT NULL,
  `aimageheight` varchar(200) NOT NULL,
  `amarginimage` varchar(200) NOT NULL,
  `aimagewidth2` varchar(200) NOT NULL,
  `aimageheight2` varchar(200) NOT NULL,
  `amarginimage2` varchar(200) NOT NULL,
  `atxtcolor` text NOT NULL,
  `expcolcolor` text NOT NULL,
  `expcolfontsize` varchar(200) NOT NULL,
  `expcolmargin` varchar(200) NOT NULL,
  `expcolhovercolor` text NOT NULL,
  `sformmargin` varchar(200) NOT NULL,
  `sboxwidth` varchar(200) NOT NULL,
  `sboxheight` varchar(200) NOT NULL,
  `sboxbg` tinyint(1) NOT NULL,
  `sboxbgcolor` text NOT NULL,
  `sboxbstyle` text NOT NULL,
  `sboxbwidth` varchar(200) NOT NULL,
  `sboxbcolor` text NOT NULL,
  `sboxfontsize` varchar(200) NOT NULL,
  `sboxtcolor` text NOT NULL,
  `srwidth` varchar(200) NOT NULL,
  `srheight` varchar(200) NOT NULL,
  `srbg` tinyint(1) NOT NULL,
  `srbgcolor` text NOT NULL,
  `srbstyle` text NOT NULL,
  `srbwidth` varchar(200) NOT NULL,
  `srbcolor` text NOT NULL,
  `srfontsize` varchar(200) NOT NULL,
  `srfontweight` varchar(200) NOT NULL,
  `srtcolor` text NOT NULL,
  `rmcolor` text NOT NULL,
  `rmhovercolor` text NOT NULL,
  `rmfontsize` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";



$table_name=$wpdb->prefix."spider_faq_category";
$sql_category_insert_row1="INSERT INTO `".$table_name."` VALUES(1, 'Uncategorized', '',1, 1, 1)";

$table_name=$wpdb->prefix."spider_faq_theme";
$sql_theme1="INSERT INTO `".$table_name."` VALUES(1, 'White', 2, '', 'FFFFFF', '600', 1, 1, '44A9CF', 'top', '44A9CF', '54DDFF', 'FFFFFF', '20', '0 60 0 0', '9 20 12', 'solid', '2', 'E0E0E0', '2', 1, 0, 'C4C4C4', 'top', 'FFFFFF', 'FFFFFF', '000000', '12', '10 90 12 21', '4 8', 'double', '3', 'FFFFFF', '2', '', '', '30', '512', '14', '', '6', '000000', 0, 'FFFFFF', '', 0, 'top', 'FFFFFF', 'FFFFFF', 'EDEAD8', '100%', 'solid', '1', 'C7C7C7', '4', '', '', '', '', '513', '0 15 25', '13', 0, 'FFFFFF', '', '', 'none', '', 'FFFFFF', '', '', '".plugins_url("upload/style1/style1a.png",__FILE__)."', '', '', '', '512', '5', '', '44A9CF', '000000', '14', '12 60 18 0', '8F8F8F', '0 60 12 0', '300', '25', 0, 'FFFFFF', 'solid', '2', 'A6A6A6', '12', '000000', '60', '30', 0, 'FFFFFF', 'solid', '2', '828282', '14', '', '000000', '000000', '9E9E9E', '12')";
$sql_theme2="INSERT INTO `".$table_name."` VALUES(2, 'Cyan', 2, '', 'FFFFFF', '600', 1, 0, '242424', 'top', 'FFFFFF', 'FFFFFF', 'FFFFFF', '20', '0 60 10 8', '10 15 8 ', 'solid', '2', '5EBDB0', '', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '212121', '13', '10 90 14 30', '6', 'dashed', '2', '5EBDB0', '', '1', '4', '35', '510', '14', '', '5', '2B2727', 0, '70E0D1', '', 0, 'top', 'FFFFFF', 'FFFFFF', 'FFFFFF', '100% 100%', 'outset', '1', 'ABABAB', '3', '', '', '', '', '511', '0 8 24', '13', 0, '70E0D1', '', '', 'none', '', 'FFFFFF', '', '', '', '', '', '', '', '', '', '2B2727', '000000', '16', '12 60 18 0', '58B0A4', '0 60 12 0', '220', '25', 1, '242424', 'solid', '2', '5EBDB0', '14', 'FFFFFF', '70', '28', 1, '242424', 'solid', '2', '5EBDB0', '14', 'bold', 'FFFFFF', '000000', '9E9E9E', '12')";
$sql_theme3="INSERT INTO `".$table_name."` VALUES(3, 'Green Gradient', 2, '', 'FFFFFF', '600', 1, 1, 'BDBDBD', 'top', 'B3B3B3', 'DEDEDE', '000000', '18', '8 60 0 2', '9 6 12', 'outset', '2', '20BD1A', '', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '12', '12 87 18 28', '4 6', 'double', '3', 'C7C7C7', '', '', '', '25', '520', '14', '', '6', 'FFFFFF', 0, 'CCCCCC', '', 1, 'top', '20BD1A', '6FCF46', 'B5B5B5', '100% 100%', 'solid', '2', '6B9999', '2', '', '', '', '', '520', '', '12', 0, 'C2C2C2', '', '100% 100%', 'solid', '2', '6B9999', '', '', '', '', '', '', '', '', '', '000000', '315221', '14', '12 60 18 0', '9E9E9E', '0 60 12 0', '220', '25', 0, 'FFFFFF', 'solid', '3', '6BB347', '14', '000000', '75', '27', 1, '6BB347', 'solid', '2', 'C9C9C9', '', '', 'FFFFFF', '1EB319', 'CFCFCF', '12')";
$sql_theme4="INSERT INTO `".$table_name."` VALUES(4, 'Black & Gold', 2, '', 'FFFFFF', '600', 1, 1, 'FFFFFF', 'top', '000000', '3D3D3D', 'FFFFFF', '18', '5 59 20 3', '9 4 12 ', 'outset', '2', 'F5A403', '6', 1, 0, 'FFBE3B', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '8 90 30 30', '4 6', 'groove', '1', '828282', '12', '', '', '30', '520', '14', '', '6', 'F5A403', 0, 'CCCCCC', '', 1, 'top', '000000', '242424', 'FFFFFF', '100% 100%', 'outset', '1', '878787', '4', '', '', '', '', '521', '', '12', 0, 'ADADAD', '', '', 'none', '', 'FFFFFF', '', '', '', '', '', '', '', '', '', 'FFFFFF', '000000', '14', '12 60 18 0', 'CCCCCC', '0 60 14 0', '220', '25', 1, '121212', 'solid', '', 'F5A403', '14', 'FFFFFF', '70', '25', 1, '0F0F0F', 'solid', '', 'F5A403', '', '', 'FFFFFF', 'F5A403', '919191', '12')";
$sql_theme5="INSERT INTO `".$table_name."` VALUES(5, 'Light Blue', 2, '', 'FFFFFF', '600', 1, 0, 'D7EBF9', 'top', 'FFFFFF', 'FFFFFF', '000000', '18', '0 60 0 0', '6', 'outset', '2', 'AED0EA', '2', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '23376E', '14', '10 60 14 30', '6', 'solid', '1', 'CFCFCF', '5', '', '', '30', '520', '14', '', '6', '2779B1', 0, 'D7EBF9', '', 0, 'top', '00FFCC', '636363', 'EEF6FC', '', 'solid', '1', 'AED0EA', '3', '', '', '', '', '520', '', '12', 0, 'F9FAFB', '', '', 'solid', '1', 'D6D6D6', '2', '', '', '', '', '', '', '', '', '000000', '2779B1', '14', '12 60 18 0', '36DDFF', '0 60 12 0', '220', '25', 1, 'D7EBF9', 'solid', '2', '2779B1', '14', '000000', '70', '30', 1, 'D7EBF9', 'solid', '1', '2779B1', '', '', '2779B1', '6699CC', '000000', '12')";
$sql_theme6="INSERT INTO `".$table_name."` VALUES(6, 'Black', 2, '', 'FFFFFF', '600', 1, 1, 'FFFFFF', 'circle', '008BE8', '00498F', 'FFFFFF', '18', '0 60 0 0', '10 4', 'outset', '2', 'CCCCCC', '2', 1, 0, '5C5C5C', 'top', 'FFFFFF', 'FFFFFF', 'FFFFFF', '14', '10 60 18 30', '4 6', 'solid', '1', '008BE8', '12', '', '', '30', '520', '14', '', '6', 'FFFFFF', 0, '474747', '', 1, 'circle', '242424', '474747', '00498F', '', 'none', '', 'FFFFFF', '4', '', '', '', '', '520', '', '12', 0, '141414', '', '', 'none', '', 'FFFFFF', '', '', '', '', '', '', '', '', '', 'FFFFFF', '00498F', '14', '12 60 18 0', '4F4F4F', '0 60 14 0', '220', '25', 1, '303030', 'ridge', '2', '00498F', '14', 'FFFFFF', '70', '25', 1, '303030', 'ridge', '1', '00498F', '', '', 'FFFFFF', 'FFFFFF', '00498F', '12')";
$sql_theme7="INSERT INTO `".$table_name."` VALUES(7, 'Blue', 2, '', 'FFFFFF', '600', 1, 0, 'A3DFE3', 'top', 'FFFFFF', 'FFFFFF', '080808', '18', '0 60 0 0', '8 6', 'outset', '2', 'E59600', '2', 1, 0, 'E59600', 'top', 'FFFFFF', 'FFFFFF', 'FCFCFC', '14', '10 78 12 22', '4 6', 'solid', '1', '59FFFF', '20', '', '', '30', '520', '14', '', '6', 'FFFFFF', 0, '1283E5', '', 1, 'circle', '1283E5', '2D90E8', 'E59600', '100% 100%', 'solid', '1', 'FFFFFF', '6', '', '', '', '', '518', '', '12', 0, 'EEEEEE', '', '100% 100%', 'solid', '1', 'BABABA', '6', '', '', '', '', '', '', '', '', '000000', '2D90E8', '14', '10 60 14 0', '878787', '0 60 14 0', '220', '25', 1, '1283E5', 'solid', '2', 'E59600', '14', 'FFFFFF', '70', '25', 1, '1283E5', 'solid', '2', 'E59600', '', '', 'FFFFFF', '2D90E8', '6E6E6E', '12')";
$sql_theme8="INSERT INTO `".$table_name."` VALUES(8, 'Black & Green', 2, '', 'FFFFFF', '600', 1, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '18', '0 60 0 2', '8 4 10', 'outset', '1', '9BCC60', '4', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '10 85 12 35', '4 6', 'solid', '1', '616161', '12', '', '', '30', '520', '14', '', '6', '9BCC60', 0, 'CCCCCC', '', 1, 'top', '312C24', '262017', '50443A', '100% 100%', 'solid', '2', 'FFFFFF', '4', '', '', '', '', '520', '', '12', 0, '50443A', '', '', 'solid', '2', 'FFFFFF', '4', '', '', '', '', '', '', '', '', 'FFFFFF', '000000', '14', '12 60 11 0', '878787', '0 60 14 0', '220', '25', 1, '312C24', 'solid', '2', '9BCC60', '14', 'FFFFFF', '70', '27', 1, '312C24', 'solid', '2', '9BCC60', '', '', 'FFFFFF', '9BCC60', 'D9D9D9', '12')";
$sql_theme9="INSERT INTO `".$table_name."` VALUES(9, 'Grey', 2, '', 'FFFFFF', '600', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '18', '0 60 0 4', '8 4 6', 'none', '', 'FFFFFF', '', 1, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '13', '10 80 14 20', '4 6', 'dashed', '1', 'BABABA', '', '', '', '30', '520', '14', '', '6', 'FFFFFF', 0, '8390A0', '', 0, 'top', 'FFFFFF', 'FFFFFF', '384454', '', 'none', '', 'FFFFFF', '4', '', '', '', '', '520', '', '12', 0, '384454', '', '', 'none', '', 'FFFFFF', '4', '', '', '', '', '', '', '', '', 'FFFFFF', '000000', '14', '8 60 14 0', 'CCCCCC', '0 60 14 0', '220', '25', 0, 'FFFFFF', 'solid', '', '000000', '14', '000000', '70', '27', 0, 'FFFFFF', 'solid', '', '000000', '', '', '000000', 'FFFFFF', '6E6E6E', '12')";
$sql_theme10="INSERT INTO `".$table_name."` VALUES(10, 'Tomato', 2, '', 'FFFFFF', '600', 1, 1, '434544', 'top', '262626', '757575', 'FFFFFF', '18', '0 60 0 4', '8 4', 'none', '', 'FFFFFF', '8', 1, 0, 'D9D9D9', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '10 60 14 35', '4 6', 'solid', '1', 'B5B5B5', '5', '', '', '30', '520', '14', '', '6', 'FFFFFF', 0, 'C44F45', '', 0, 'top', 'FFFFFF', 'FFFFFF', '7C7E7D', '100% 100%', 'solid', '1', 'A1A1A1', '5', '', '', '', '', '520', '', '12', 0, 'D9D4CE', '', '', 'solid', '1', 'A1A1A1', '5', '', '', '', '', '', '', '', '', '000000', '000000', '14', '10 60 14 0', 'CCCCCC', '0 60 16 0', '220', '25', 1, 'FFFFFF', 'solid', '2', 'C44F45', '14', '000000', '70', '27', 1, 'FFFFFF', 'solid', '2', 'C44F45', '', '', '000000', 'C44F45', 'E6E6E6', '12')";
$sql_theme11="INSERT INTO `".$table_name."` VALUES(11, 'Green', 2, '', 'FFFFFF', '600', 1, 1, 'FFFFFF', 'top', '12FFDA', '0FD1B3', 'FFFFFF', '18', '0 60 0 0', '8 4', 'groove', '1', '0A8E79', '8', 1, 0, 'FFB969', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '10 60 14 35', '5 7', 'outset', '1', 'A6A6A6', '12', '', '', '30', '520', '14', '', '6', 'FFFFFF', 0, '0A8E79', '', 0, 'top', 'FFFFFF', 'FFFFFF', '0EC9AC', '', 'none', '', 'FFFFFF', '5', '', '', '', '', '518', '', '12', 0, 'EDEDED', '', '100% 100%', 'solid', '1', 'A6A6A6', '5', '', '', '', '', '', '', '', '', '000000', '000000', '14', '10 60 14 0', 'A1A1A1', '0 60 16 0', '220', '25', 1, '0EC9AC', 'solid', '2', '087362', '14', 'FFFFFF', '70', '27', 1, '0EC9AC', 'solid', '2', '087362', '', '', 'FFFFFF', '087362', 'C9C9C9', '12')";
$sql_theme12="INSERT INTO `".$table_name."` VALUES(12, 'Yellow', 2, '', 'FFFFFF', '600', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '18', '0 60 0 4', '10 4 8', 'solid', '1', '000000', '12', 1, 0, 'DEDCD9', 'top', 'FFFFFF', 'FFFFFF', '000000', '13', '10 60 14 4', '5 8', 'groove', '1', 'CCCCCC', '20', '', '', '30', '520', '14', '', '8', '000000', 0, 'FEE000', '', 0, 'top', 'FFFFFF', 'FFFFFF', 'FFFFFF', '100% 100%', 'solid', '1', '737373', '12', '', '', '', '', '520', '', '12', 0, 'F2F2F2', '', '100% 100%', 'solid', '1', 'B3B3B3', '12', '', '', '', '', '', '', '', '', '000000', '000000', '14', '12 60 18 0', 'CCCCCC', '0 60 14 0', '220', '25', 0, 'FFFFFF', 'solid', '', '000000', '14', '000000', '70', '27', 0, 'FFFFFF', 'solid', '', '000000', '', '', '000000', '000000', '919191', '12')";
$sql_theme13="INSERT INTO `".$table_name."` VALUES(13, 'White & Blue', 2, '', 'FFFFFF', '600', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '18', '0 60 0 4', '8 4 10', 'groove', '2', '3BCBFF', '12', 1, 0, 'E6E6E6', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '12 100 14 40', '4 6', 'dotted', '1', '595959', '12', '', '', '30', '520', '14', '', '8', '000000', 0, 'F5F5F5', '', 0, 'top', 'FFFFFF', 'FFFFFF', '3BCBFF', '100% 100%', 'outset', '1', 'C7C7C7', '14', '', '', '', '', '520', '', '12', 0, 'FFFFFF', '', '100% 100%', 'outset', '1', 'C7C7C7', '14', '', '', '', '', '', '', '', '', '000000', '000000', '14', '10 60 14 0', 'CCCCCC', '0 60 16 0', '220', '25', 0, 'FFFFFF', 'outset', '1', '000000', '14', '000000', '70', '27', 0, 'FFFFFF', 'outset', '1', '000000', '', '', '000000', '000000', '8F8F8F', '12')";
$sql_theme14="INSERT INTO `".$table_name."` VALUES(14, 'Light Yellow', 2, '', 'FFFFFF', '600', 1, 0, 'F5F5F5', 'top', 'FFFFFF', 'FFFFFF', '000000', '18', '0 60 0 0', '8 4', 'solid', '1', 'C5A009', '', 1, 0, 'FDF6D2', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '10 82 14 25', '4 8', 'groove', '1', '8F8F8F', '5', '', '', '30', '520', '14', '', '7', '1C94CD', 0, 'F6F6F6', '', 0, 'top', 'FFFFFF', 'FFFFFF', 'FDF6D2', '100% 100%', 'outset', '1', 'FBCB09', '0', '', '', '', '', '520', '', '12', 0, 'EEEEEE', '', '100% 100%', 'outset', '1', 'D1D1D1', '', '', '', '', '', '', '', '', '', '000000', '000000', '14', '10 60 14 0', 'A6A6A6', '0 60 16 0', '220', '25', 1, 'F6F6F6', 'outset', '2', 'FBCB09', '14', '000000', '70', '27', 1, 'F6F6F6', 'outset', '2', 'FBCB09', '', '', '000000', '1C94CD', '7A7A7A', '12')";
$sql_theme15="INSERT INTO `".$table_name."` VALUES(15, 'Yellow Gradient', 2, '', 'FFFFFF', '600', 1, 1, 'FEF9D9', 'top', 'FEF9D9', 'F3E157', '000000', '18', '0 60 0 0', '8 4', 'ridge', '1', 'B3B3B3', '', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '10 86 14 31', '4 8', 'ridge', '1', 'CFCFCF', '2', '', '', '30', '520', '14', '95', '', '000000', 0, 'CCCCCC', '', 1, 'top', 'FEF9D9', 'F3E157', 'FFFFFF', '100% 100%', 'outset', '1', 'CEB80D', '', '".plugins_url("upload/style15/style15a.png",__FILE__)."', '6', '".plugins_url("upload/style15/style15b.png",__FILE__)."', '', '520', '', '12', 0, 'FCF8D5', '', '100% 100%', 'solid', '1', 'DBDBDB', '', '', '', '', '', '', '', '', '', '000000', '000000', '14', '10 60 14 0', 'CCCCCC', '0 60 16 0', '220', '25', 1, 'FCF8D5', 'outset', '2', 'CEB80D', '14', '000000', '70', '27', 1, 'FCF8D5', 'outset', '2', 'CEB80D', '', '', '000000', '000000', '787878', '14')";
$sql_theme16="INSERT INTO `".$table_name."` VALUES(16, 'Grey & White', 2, '', 'FFFFFF', '600', 0, 1, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '20', '0 60 0 0', '6 4 8', 'none', '', 'FFFFFF', '', 1, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '10 60 14 42', '4 8', 'ridge', '1', 'CCCCCC', '', '', '', '30', '520', '14', '94', '', '000000', 0, 'D3D3D3', '', 0, 'top', 'FFFFFF', 'FFFFFF', 'FFFFFF', '100% 100%', 'outset', '1', '000000', '', '".plugins_url("upload/style16/style16a.png",__FILE__)."', '10', '".plugins_url("upload/style16/style16b.png",__FILE__)."', '', '520', '', '12', 0, 'EBEBEB', '', '100% 100%', 'outset', '1', 'B8B8B8', '', '', '', '', '', '', '', '', '', '000000', '000000', '14', '10 60 14 0', 'CCCCCC', '0 60 16 0', '220', '25', 0, 'FFFFFF', 'solid', '', '000000', '14', '000000', '70', '27', 0, 'FFFFFF', 'solid', '', '000000', '', '', '000000', '000000', '616161', '12')";
$sql_theme17="INSERT INTO `".$table_name."` VALUES(17, 'Green & Blue', 2, '', 'FFFFFF', '600', 1, 0, 'E0CA3B', 'top', 'FFFFFF', 'FFFFFF', '000000', '18', '0 20 0 0', '8 4 6', 'groove', '1', 'AED2D9', '8', 0, 0, 'FFFFFF', 'top', 'FFFFFF', 'FFFFFF', '000000', '14', '9 20 14 42', '8', 'outset', '1', 'E3E3E3', '5', '', '', '30', '560', '14', '95', '', '000000', 0, 'AED2D9', '', 0, 'top', 'FFFFFF', 'FFFFFF', 'CCD232', '100% 100%', 'dotted', '1', '3B3B3B', '18', '".plugins_url("upload/style17/style17a.png",__FILE__)."', '8', '".plugins_url("upload/style17/style17b.png",__FILE__)."', '', '560', '', '12', 0, 'E8E8E8', '', '100% 100%', 'outset', '1', 'D4D4D4', '18', '', '', '', '', '', '', '', '', '000000', '000000', '14', '10 40 14 0', 'B2B82C', '0 40 16 0', '220', '25', 0, 'FFFFFF', 'inset', '', '000000', '14', '000000', '70', '27', 0, 'FFFFFF', 'inset', '', '000000', '', '', '000000', '000000', 'C9C9C9', '12')";
//create tables

$wpdb->query($sql_faq);
$wpdb->query($sql_question);
$wpdb->query($sql_category);
$wpdb->query($sql_theme);



////// insert themes rows
$wpdb->query($sql_theme1);
$wpdb->query($sql_theme2);
$wpdb->query($sql_theme3);
$wpdb->query($sql_theme4);
$wpdb->query($sql_theme5);
$wpdb->query($sql_theme6);
$wpdb->query($sql_theme7);
$wpdb->query($sql_theme8);
$wpdb->query($sql_theme9);
$wpdb->query($sql_theme10);
$wpdb->query($sql_theme11);
$wpdb->query($sql_theme12);
$wpdb->query($sql_theme13);
$wpdb->query($sql_theme14);
$wpdb->query($sql_theme15);
$wpdb->query($sql_theme16);
$wpdb->query($sql_theme17);


////// insert category rows
$wpdb->query($sql_category_insert_row1);
}
register_activation_hook( __FILE__, 'Spider_FAQ_activate' );
?>