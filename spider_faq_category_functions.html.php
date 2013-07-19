<?php   
function html_add_cat(){
	
	
	
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
        	<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-faq-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create categories of questions <a href="http://web-dorado.com/spider-faq-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromFAQWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
  <tr>
  <td width="100%"><h2>Add Category</h2></td>
  <td align="right"><input type="button" onclick="submitbutton('save')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('apply')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=Spider_Faq_Categories'" value="Cancel" class="button-secondary action"> </td> 
  </tr>
  </tbody></table>
  <br />
  <br />
<form action="admin.php?page=Spider_Faq_Categories" method="post" name="adminForm" id="adminForm">

<table class="admintable">
<tr>
<td width="100" align="right" class="key">
Title:
</td>
<td>
<input class="text_area" type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $row->title;?>" />
</td>
</tr>





<tr>
<td width="100" align="right" class="key">
Description:
</td>
<td>

<textarea name="description" rows="5" cols="80"><?php echo htmlspecialchars($row->description); ?></textarea>

</td>
</tr>

<tr>
<td width="100" align="right" class="key">Show Title:</td>
<td>
	<input type="radio" name="show_title" id="show_title0" value="0" class="inputbox">
	<label for="show_title0">No</label>
	<input type="radio" name="show_title" id="show_title1" value="1" checked="checked" class="inputbox">
	<label for="show_title1">Yes</label>
</td>
<?php

?>
</td>
</tr>

<tr>
<td width="100" align="right" class="key">Show Description:</td>
<td>
	<input type="radio" name="show_description" id="show_description0" value="0" class="inputbox">
	<label for="show_title0">No</label>
	<input type="radio" name="show_description" id="show_description1" value="1" checked="checked" class="inputbox">
	<label for="show_description1">Yes</label>
</td>
<?php

?>
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








function 	html_show_cat($rows, $pageNav,$sort){
	global $wpdb;
	?>
    <script language="javascript">
	function ordering(name,as_or_desc)
	{
		document.getElementById('asc_or_desc').value=as_or_desc;		
		document.getElementById('order_by').value=name;
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
    <form method="post"  onkeypress="doNothing()" action="admin.php?page=Spider_Faq_Categories" id="admin_form" name="admin_form">
	<table cellspacing="10" width="100%">
	   <tr>
        	<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-faq-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create categories of questions <a href="http://web-dorado.com/spider-faq-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromFAQWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
    <tr>
    <td style="width:80px">
    <?php echo "<h2>".'Categories'. "</h2>"; ?>
    </td>
    <td  style="width:90px; text-align:right;"><p class="submit" style="padding:0px; text-align:left"><input type="button" value="Add a Category" name="custom_parametrs" onclick="window.location.href='admin.php?page=Spider_Faq_Categories&task=add_Spider_Faq_Categories'" /></p></td>
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
		 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=Spider_Faq_Categories\'" class="button-secondary action">
    </div>';
	 print_html_nav1($pageNav['total'],$pageNav['limit'],$serch_fields);	
	
	?>
  <table class="wp-list-table widefat fixed pages" style="width:95%">
 <thead>
 <TR>
   <th scope="col" id="id" class="<?php if($sort["sortid_by"]=="id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:30px" ><a href="javascript:ordering('id',<?php if($sort["sortid_by"]=="id") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>ID</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="title" class="<?php if($sort["sortid_by"]=="title") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('title',<?php if($sort["sortid_by"]=="title") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Title</span><span class="sorting-indicator"></span></a></th>
<th scope="col" id="description" class="<?php if($sort["sortid_by"]=="description") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('description',<?php if($sort["sortid_by"]=="description") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Description</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="published"  class="<?php if($sort["sortid_by"]=="published") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:100px" ><a href="javascript:ordering('published',<?php if($sort["sortid_by"]=="published") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Published</span><span class="sorting-indicator"></span></a></th>
 <th style="width:80px">Edit</th>
 <th style="width:80px">Delete</th>
 </TR>
 </thead>
 <tbody>
 <?php 
  for($i=0; $i<count($rows);$i++){ 
	  
  		
  ?>
 <tr>
         <td><?php echo $rows[$i]->id; ?></td>
         <td><a  href="admin.php?page=Spider_Faq_Categories&task=edit_Spider_Faq_Categories&id=<?php echo $rows[$i]->id?>"><?php echo $rows[$i]->title; ?></a></td>
         <td><?php echo $rows[$i]->description; ?></td>
         
         <td><a  href="admin.php?page=Spider_Faq_Categories&task=unpublish_Spider_Faq_Categories&id=<?php echo $rows[$i]->id?>"<?php if(!$rows[$i]->published){ ?> style="color:#C00;" <?php }?> ><?php if($rows[$i]->published)echo "Yes"; else echo "No"; ?></a></td>
         <td ><a  href="admin.php?page=Spider_Faq_Categories&task=edit_Spider_Faq_Categories&id=<?php echo $rows[$i]->id?>">Edit</a></td>
         
		 <td><a href="javascript:confirmation('admin.php?page=Spider_Faq_Categories&task=remove_Spider_Faq_Categories&id=<?php echo $rows[$i]->id ?>','<?php if($rows[$i]->title!="") echo addslashes($rows[$i]->title); else echo "" ?>')">Delete</a> </td>
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

	
	
	
	
	
	
	
 function html_edit_cat($row){
 
 	
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
        	<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-faq-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create categories of questions <a href="http://web-dorado.com/spider-faq-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromFAQWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
  <tr>
  <td width="100%"><h2>Category - <?php echo stripslashes($row->title) ?></h2></td>
  <td align="right"><input type="button" onclick="submitbutton('save')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('apply')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=Spider_Faq_Categories'" value="Cancel" class="button-secondary action"> </td> 
  </tr>
  </tbody></table>
  <br />
  <br />
<form action="admin.php?page=Spider_Faq_Categories&id=<?php echo $row->id; ?>" method="post" name="adminForm1" id="adminForm1">

<table class="admintable">
<tr>
<td width="100" align="right" class="key">
Title:
</td>
<td>
<input class="text_area" type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $row->title;?>" />
</td>
</tr>





<tr>
<td width="100" align="right" class="key">
Description:
</td>
<td>

<textarea name="description" rows="5" cols="80"><?php echo htmlspecialchars($row->description); ?></textarea>

</td>
</tr>

<tr>
<td width="100" align="right" class="key">Show Title:</td>
<td>
	<input type="radio" name="show_title" id="show_title0" value="0" <?php if($row->show_title==0) echo 'checked="checked"'; ?> class="inputbox">
	<label for="show_title0">No</label>
	<input type="radio" name="show_title" id="show_title1" value="1" <?php if($row->show_title==1) echo 'checked="checked"'; ?> class="inputbox">
	<label for="show_title1">Yes</label>
</td>
<?php

?>
</td>
</tr>

<tr>
<td width="100" align="right" class="key">Show Description:</td>
<td>
	<input type="radio" name="show_description" id="show_description0" value="0" <?php if($row->show_description==0) echo 'checked="checked"'; ?> class="inputbox">
	<label for="show_description0">No</label>
	<input type="radio" name="show_description" id="show_description1" value="1" <?php if($row->show_description==1) echo 'checked="checked"'; ?> class="inputbox">
	<label for="show_description1">Yes</label>
</td>
<?php

?>
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