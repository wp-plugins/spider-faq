<?php 

function add_spider_faq(){
  global $wpdb;
	  
	  
	 
    $query = "SELECT id,title FROM ".$wpdb->prefix."spider_faq_faq ";
    $rows1 = $wpdb->get_results($query);
	

   
    if (!$row->id)
        $pub = 1;
    else
        $pub = $row->published;
   // $lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $pub);
  
	$theme_row=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."spider_faq_theme ");
	
  
		
// display function
html_add_spider_faq($theme_row);
}

function show_spider_faq(){
		  
	  
  global $wpdb;
	$sort["default_style"]="manage-column column-autor sortable desc";
	
	if(isset($_POST['page_number']))
	{
			
			if($_POST['asc_or_desc'])
			{
				$sort["sortid_by"]=$_POST['order_by'];
				if($_POST['asc_or_desc']==1)
				{
					$sort["custom_style"]="manage-column column-title sorted asc";
					$sort["1_or_2"]="2";
					$order="ORDER BY ".$sort["sortid_by"]." ASC";
				}
				else
				{
					$sort["custom_style"]="manage-column column-title sorted desc";
					$sort["1_or_2"]="1";
					$order="ORDER BY ".$sort["sortid_by"]." DESC";
				}
			}
	if($_POST['page_number'])
		{
			$limit=($_POST['page_number']-1)*20; 
		}
		else
		{
			$limit=0;
		}
	}
	else
		{
			$limit=0;
		}
	if(isset($_POST['search_events_by_title'])){
		$search_tag=$_POST['search_events_by_title'];
		}
		
		else
		{
		$search_tag="";
		}
	if ( $search_tag ) {
		$where= ' WHERE '.$wpdb->prefix.'spider_faq_faq.title LIKE "%'.$search_tag.'%"';
	}
	
	
	
	
	
	
	
	
	// get the total number of records
	$query = "SELECT COUNT(*) FROM ".$wpdb->prefix."spider_faq_faq". $where;
	
	$total = $wpdb->get_var($query);
	$pageNav['total'] =$total;
	$pageNav['limit'] =	 $limit/20+1;
	
	$query =	"SELECT ".$wpdb->prefix."spider_faq_faq.*,".$wpdb->prefix."spider_faq_theme.title as themetitle FROM ".$wpdb->prefix."spider_faq_faq left join ".$wpdb->prefix."spider_faq_theme on  ".$wpdb->prefix."spider_faq_theme.id=".$wpdb->prefix."spider_faq_faq.category ".$where." ". $order." "." LIMIT ".$limit.",20";
	$rows = $wpdb->get_results($query);	

		html_show_spider_faq( $rows, $pageNav,$sort);   	
	
}





function edit_spider_faq($id){
	global $wpdb;
	  
	  $query="SELECT * FROM ".$wpdb->prefix."spider_faq_faq WHERE id='".$id."'";
	   $row=$wpdb->get_row($query);
	   
$theme_row=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."spider_faq_theme");


    html_edit_spider_faq($row,$theme_row);
}






function save_spider_faq(){

	global $wpdb;
	$save_or_no= $wpdb->insert($wpdb->prefix.'spider_faq_faq', array(
		'id'	=> NULL,
        'title'     => $_POST["title"],
		'theme'   => $_POST["theme_search"],
        'category'   => $_POST["params"],
		'standcategory'   => $_POST["contcats"],
		'standcat'				 =>$_POST["standcat"],
		'show_searchform'				 =>$_POST["show_searchform"],
		'expand'				 =>$_POST["expand"],
                ),
				array(
				'%d',
				'%s',
				'%s',
				'%s',	
				'%s',
				'%d',
				'%d',
				'%d',
				)
                );
			
					if(!$save_or_no)
	{
		?>
	<div class="updated"><p><strong><?php _e('Error. Please install plugin again'); ?></strong></p></div>
	<?php
		return false;
	}
	?>
	<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
	<?php
	
    return true;
}

function apply_spider_faq(){

	global $wpdb;
	
	
	 $save_or_no= $wpdb->update($wpdb->prefix.'spider_faq_faq', array(
        
          'title'     => $_POST["title"],
		'theme'   => $_POST["theme_search"],
        'category'   => $_POST["params"],
		'standcategory'   => $_POST["contcats"],
		'standcat'				 =>$_POST["standcat"],
		'show_searchform'				 =>$_POST["show_searchform"],
		'expand'				 =>$_POST["expand"],
                ),
				 array('id'=>$_POST["id"]),
				 
				 
				array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%d',
				)
                );
				?>
	<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
	<?php
	
    return true;
	
}







function remove_spider_faq($id){
   global $wpdb;
 $sql_remov_tag="DELETE FROM ".$wpdb->prefix."spider_faq_faq WHERE id='".$id."'";
 if(!$wpdb->query($sql_remov_tag))
 {
	  ?>
	  <div id="message" class="error"><p>Spider Faq Not Deleted</p></div>
      <?php
	 
 }
 else{
 ?>
 <div class="updated"><p><strong><?php _e('Item Deleted.' ); ?></strong></p></div>
 <?php
 }
}



function change_ques( $id ){
  global $wpdb;
  $published=$wpdb->get_var("SELECT published FROM ".$wpdb->prefix."spider_faq_question WHERE `id`=".$id );
  if($published)
   $published=0;
  else
   $published=1;
  $savedd=$wpdb->update($wpdb->prefix.'spider_faq_question', array(
			'published'    =>$published,
              ), 
              array('id'=>$id),
			  array(  '%d' )
			  );
	if($save_or_no)
	{
		?>
	<div class="error"><p><strong><?php _e('Error. Please install plugin again'); ?></strong></p></div>
	<?php
		return false;
	}
	?>
	<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
	<?php
	
    return true;
}
?>