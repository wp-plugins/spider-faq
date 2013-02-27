<?php   
function html_add_ques($cat_row,$ord_elem){
	
	
	
?>
<script type="text/javascript">
function submitbutton(pressbutton) 
{
	if(!document.getElementById('title').value){
	alert("Title is required.");
	return;
	
	}
	
	document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task="+pressbutton;
	document.getElementById("adminForm").submit();
	
}



</script>




<table width="95%">
  <tbody>
<tr>
        	<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-faq-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create questions <a href="http://web-dorado.com/spider-faq-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromFAQWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>

  <tr>
  <td width="100%"><h2>Add Question</h2></td>
  <td align="right"><input type="button" onclick="submitbutton('save')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('apply')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=Spider_Faq_Questions'" value="Cancel" class="button-secondary action"> </td> 
  </tr>
  </tbody></table>
  <br />
  <br />
<form action="admin.php?page=Spider_Faq_Questions" method="post" name="adminForm" id="adminForm">

<table class="admintable">

<tr>
<td width="100" align="right" class="key">
Question:
</td>
<td>
<input class="text_area" type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $row->title;?>" />
</td>
</tr>

<tr>
<td align="right" class="key">Category:</td>
<td>
<?php
	$cat_select.='<select style=" text-align:left;" name="cat_search" id="cat_search" class="inputbox" onchange="change_select();">';
	foreach($cat_row as $catt)
	{
		 if (strlen($catt->title)<30){
		 $cat_title=$catt->title;
		 }
		 else{
		 $cat_title=substr_replace($catt->title,"...",30);
		 }
		$cat_select.='<option value="'.$catt->id.'"';
		
		$cat_select.='>'.$cat_title.'</option>';
	}
	echo $cat_select;
?>
</td>
</tr>



<tr>
<td width="100" align="right" class="key">
Answer:
</td>
<td>

<div id="main_editor"><div  style=" width:600px; text-align:left" id="poststuff">
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea"><?php the_editor("","content","title" ); ?>
</div>
</div>
</div>

</td>
</tr>


<tr>
<td width="100" align="right" class="key">
Order:
</td>
<td>
<select name="ordering"  >
<?php
$count_ord=count($ord_elem);

 
for($i=0;$i<$count_ord;$i++)
{
    if (strlen($ord_elem[$i]->title)<30){
		 $row_title=$ord_elem[$i]->title;
		 }
		 else{
		 $row_title=substr_replace($ord_elem[$i]->title,"...",30);
		 }
?>
<option value="<?php echo $ord_elem[$i]->ordering  ?>"  > <?php echo  $ord_elem[$i]->ordering." "; echo $row_title; ?></option>

<?php 
}
?>
<option value="<?php echo  $ord_elem[$i-1]->ordering+1; ?>" selected="selected"><?php echo  $ord_elem[$i-1]->ordering+1; ?> Last</option>
</select>

</td>
</tr>





<tr>
<td width="100" align="right" class="key">Published:</td>
<td>
	<input type="radio" name="published" id="published0" value="0" class="inputbox">
	<label for="published0">No</label>
	<input type="radio" name="published" id="published1" value="1" checked="checked" class="inputbox">
	<label for="published1">Yes</label>
</td>
<?php

?>
</td>
</tr>
</table>
<input type="hidden" name="id"
value="<?php echo $row->id; ?>" />
<input type="hidden" name="task" value="" />
</form>
<?php


}








function 	html_show_ques($rows, $pageNav,$sort){
	global $wpdb;
	?>
    <script language="javascript">
	function ordering(name,as_or_desc)
	{
		document.getElementById('asc_or_desc').value=as_or_desc;		
		document.getElementById('order_by').value=name;
		document.getElementById('admin_form').submit();
	}
	function saveorder()
	{
		document.getElementById('saveorder').value="save";
		document.getElementById('admin_form').submit();
		
	}
	function listItemTask(this_id,replace_id)
	{
		document.getElementById('oreder_move').value=this_id+","+replace_id;
		document.getElementById('admin_form').submit();
	}
				 	function doNothing() {  
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if( keyCode == 13 ) {


        if(!e) var e = window.event;

        e.cancelBubble = true;
        e.returnValue = false;

        if (e.stopPropagation) {
                e.stopPropagation();
                e.preventDefault();
        }
}
}
	</script>
    <form method="post"  onkeypress="doNothing()" action="admin.php?page=Spider_Faq_Questions" id="admin_form" name="admin_form">
	<table cellspacing="10" width="100%">
	<tr>
        	<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-faq-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create questions <a href="http://web-dorado.com/spider-faq-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromFAQWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
	
    <tr>
    <td style="width:80px">
    <?php echo "<h2>".'Questions'. "</h2>"; ?>
    </td>
    <td  style="width:90px; text-align:right;"><p class="submit" style="padding:0px; text-align:left"><input type="button" value="Add a Question" name="custom_parametrs" onclick="window.location.href='admin.php?page=Spider_Faq_Questions&task=add_Spider_Faq_Questions'" /></p></td>
<td style="text-align:right;font-size:16px;padding:20px; padding-right:50px">

	</td>

    </tr>
    </table>
    <?php
	if(isset($_POST['serch_or_not'])) {if($_POST['serch_or_not']=="search"){ $serch_value=$_POST['search_events_by_title']; }else{$serch_value="";}} 
	$serch_fields='<div class="alignleft actions" style="width:180px;">
    	<label for="search_events_by_title" style="font-size:14px">Title: </label>
        <input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="clear_serch_texts()">
    </div>
	<div class="alignleft actions">
   		<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
		 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
		 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=Spider_Faq_Questions\'" class="button-secondary action">
    </div>';
	 print_html_nav1($pageNav['total'],$pageNav['limit'],$serch_fields);	
	
	?>
  <table class="wp-list-table widefat fixed pages" style="width:95%">
 <thead>
 <TR>
   <th scope="col" id="id" class="<?php if($sort["sortid_by"]=="id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:30px" ><a href="javascript:ordering('id',<?php if($sort["sortid_by"]=="id") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>ID</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="title" class="<?php if($sort["sortid_by"]=="title") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('title',<?php if($sort["sortid_by"]=="title") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Question</span><span class="sorting-indicator"></span></a></th>
<th scope="col" id="category" class="<?php if($sort["sortid_by"]=="category") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('category',<?php if($sort["sortid_by"]=="category") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Category</span><span class="sorting-indicator"></span></a></th>
<th scope="col" id="ordering" class="<?php if($sort["sortid_by"]=="ordering") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:95px" ><a style="display:inline" href="javascript:ordering('ordering',<?php if($sort["sortid_by"]=="ordering") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Order</span><span class="sorting-indicator"></span></a><div><a style="display:inline" href="javascript:saveorder(1, 'saveorder')" title="Save Order"><img onclick="saveorder(1, 'saveorder')" src="<?php echo plugins_url("images/filesave.png",__FILE__) ?>" alt="Save Order"></a></div></th>
  <th scope="col" id="published"  class="<?php if($sort["sortid_by"]=="published") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:100px" ><a href="javascript:ordering('published',<?php if($sort["sortid_by"]=="published") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Published</span><span class="sorting-indicator"></span></a></th>
 <th style="width:80px">Edit</th>
 <th style="width:80px">Delete</th>
 </TR>
 </thead>
 <tbody>
 <?php 
  for($i=0; $i<count($rows);$i++){ 
	  if(isset($rows[$i-1]->id))
		  {
		  $move_up='<span><a href="#reorder" onclick="return listItemTask(\''.$rows[$i]->id.'\',\''.$rows[$i-1]->id.'\')" title="Move Up">   <img src="'.plugins_url('images/uparrow.png',__FILE__).'" width="16" height="16" border="0" alt="Move Up"></a></span>';
		  }
	  else
	  	{
			$move_up="";
	  	}
		if(isset($rows[$i+1]->id))
  		$move_down='<span><a href="#reorder" onclick="return listItemTask(\''.$rows[$i]->id.'\',\''.$rows[$i+1]->id.'\')" title="Move Down">  <img src="'.plugins_url('images/downarrow.png',__FILE__).'" width="16" height="16" border="0" alt="Move Down"></a></span>';
  		else
  		$move_down="";
  		
  ?>
 <tr>
         <td><?php echo $rows[$i]->id; ?></td>
         <td><a  href="admin.php?page=Spider_Faq_Questions&task=edit_Spider_Faq_Questions&id=<?php echo $rows[$i]->id?>"><?php echo $rows[$i]->title; ?></a></td>
         <td><?php if ($rows[$i]->cattitle=='') echo 'Uncategorised'; else echo $rows[$i]->cattitle; ?></td>
         <td ><?php echo  $move_up.$move_down; ?><input type="text" name="order_<?php echo $rows[$i]->id; ?>" style="width:40px" value="<?php echo $rows[$i]->ordering; ?>" /></td>
         <td><a  href="admin.php?page=Spider_Faq_Questions&task=unpublish_Spider_Faq_Questions&id=<?php echo $rows[$i]->id?>"<?php if(!$rows[$i]->published){ ?> style="color:#C00;" <?php }?> ><?php if($rows[$i]->published)echo "Yes"; else echo "No"; ?></a></td>
         <td ><a  href="admin.php?page=Spider_Faq_Questions&task=edit_Spider_Faq_Questions&id=<?php echo $rows[$i]->id?>">Edit</a></td>    
		 <td><a href="javascript:confirmation('admin.php?page=Spider_Faq_Questions&task=remove_Spider_Faq_Questions&id=<?php echo $rows[$i]->id ?>','<?php if($rows[$i]->title!="") echo addslashes($rows[$i]->title); else echo "" ?>')">Delete</a> </td>
  </tr> 
 <?php } ?>
 </tbody>
 </table>
 <input type="hidden" name="oreder_move" id="oreder_move" value="" />
 <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo $_POST['asc_or_desc'];?>"  />
 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo $_POST['order_by'];?>"  />
 <input type="hidden" name="saveorder" id="saveorder" value="" />

 <?php
?>
    
    
   
 </form>
    <?php


	}
	
?>	
<script>

 	function confirmation(href,title) {
	
		var answer = confirm("Are you sure you want to delete '"+title+"'?")
		if (answer){
			document.getElementById('admin_form').action=href;
			document.getElementById('admin_form').submit();
		}
		else{
		}
	
	
	
	}
	</script>	
	
	
	
<?php	
	
	
	
	
	
	
	
	
 function html_edit_ques($row,$cat_row,$ord_elem){
 
 	
?>
<script type="text/javascript">
function submitbutton(pressbutton) 
{

	if(!document.getElementById('title').value){
	alert("Title is required.");
	return;
	
	}

	document.getElementById("adminForm1").action=document.getElementById("adminForm1").action+"&task="+pressbutton;
	document.getElementById("adminForm1").submit();
	
}
</script>




<table width="95%">
  <tbody>
<tr>
        	<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-faq-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create questions <a href="http://web-dorado.com/spider-faq-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromFAQWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
  <tr>
  <td width="100%"><h2>Question - <?php echo stripslashes($row->title) ?></h2></td>
  <td align="right"><input type="button" onclick="submitbutton('save')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('apply')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=Spider_Faq_Questions'" value="Cancel" class="button-secondary action"> </td> 
  </tr>
  </tbody></table>
  <br />
  <br />
<form action="admin.php?page=Spider_Faq_Questions&id=<?php echo $row->id; ?>" method="post" name="adminForm1" id="adminForm1">

<table class="admintable">
<tr>
<td width="100" align="right" class="key">
Question:
</td>
<td>
<input class="text_area" type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $row->title;?>" />
</td>
</tr>




<tr>
<td align="right"  class="key">Category:</td>
<td>
<?php
	$cat_select.='<select style=" text-align:left;" name="cat_search" id="cat_search" class="inputbox" onchange="change_select();">';
	foreach($cat_row as $catt)
	{
		
		$cat_select.='<option value="'.$catt->id.'"';
		if($row->category==$catt->id)
		$cat_select.='selected="selected"';
		 if (strlen($catt->title)<30){
		 $cat_title=$catt->title;
		 }
		 else{
		 $cat_title=substr_replace($catt->title,"...",30);
		 }
		$cat_select.='>'.$cat_title.'</option>';
	}
	echo $cat_select;
?>
</td>
</tr>


<tr>
<td width="100" align="right" class="key">
Answer:
</td>
<td>
<?php 
if($row->fullarticle!="")
$row->text=$row->article.'<!--more-->'.$row->fullarticle;
else
$row->text=$row->article;
?>
<div id="main_editor"><div  style=" width:600px; text-align:left" id="poststuff">
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea"><?php the_editor(stripslashes($row->text),"content","title" ); ?>
</div>
</div>
</div>

</td>
</tr>


<tr>
<td width="100" align="right" class="key">
Order:
</td>
<td>
<select name="ordering" >
<?php

$count_ord=count($ord_elem);
for($i=0;$i<$count_ord;$i++)
{
   if (strlen($ord_elem[$i]->title)<30){
		 $row_title=$ord_elem[$i]->title;
		 }
		 else{
		 $row_title=substr_replace($ord_elem[$i]->title,"...",30);
		 }
?>
<option value="<?php echo $ord_elem[$i]->ordering  ?>"<?php if($ord_elem[$i]->ordering==$row->ordering) echo 'selected="selected"'; ?> > <?php echo  $ord_elem[$i]->ordering." "; echo $row_title; ?></option>

<?php 
}
?>
<option value="<?php echo  $ord_elem[$i-1]->ordering+1; ?>"><?php echo  $ord_elem[$i-1]->ordering+1; ?> Last</option>
</select>

</td>
</tr>



<tr>
<td width="100" align="right" class="key">Published:</td>
<td>
	<input type="radio" name="published" id="published0" value="0" <?php if($row->published==0) echo 'checked="checked"'; ?> class="inputbox">
	<label for="published0">No</label>
	<input type="radio" name="published" id="published1" value="1" <?php if($row->published==1) echo 'checked="checked"'; ?> class="inputbox">
	<label for="published1">Yes</label>
</td>
<?php

?>
</td>
</tr>
</table>
<input type="hidden" name="id" value="<?php echo $row->id;?>" />
<input type="hidden" name="task" value="" />
</form>
<?php 
 }	
?>