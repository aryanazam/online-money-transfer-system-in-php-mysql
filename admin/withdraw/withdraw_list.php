<?php
 include("../template/header.php");
?>
<script type="text/javascript" src="../../js/jquery.js"></script>
<link rel="stylesheet" href="../../datepicker/jquery-ui.css">
<script src="../../datepicker/jquery-1.10.2.js"></script>
<script src="../../datepicker/jquery-ui.js"></script>


<script type="text/javascript" src="../../js/selectize.js"></script>
<link rel='stylesheet' href='../../css/selectize.css'>
<link rel='stylesheet' href='../../css/selectize.default.css'>


<style type="text/css">
    .selectize-input {
      width: 100% !important;
      height: 62px !important;
    }
</style>

 <div class="row">
        <div class="col-md-12">
        
            <form name="form_selected_users"   id="form_selected_users"> 
                <input type="text" name="selected_users_id" id="selected_users_id"  value="<?=$_SESSION['selected_users_id']?>" style="width:400px;" required>                        
                <input type="hidden" name="cmd"  od="cmd" value="select_users" />
            </form>
            <?php
                    unset($info);					 
                $info["table"] = "users";
                $info["fields"] = array("users.*"); 
                $info["where"]   = "1";
                $resusers =  $db->select($info);							
            ?>
            <script language="javascript">
              $(document).ready(function() {												 
                         var eventHandler = function(name) {
                                  return function() {
                                      
                                     ////////////////////////////////////////////////
                                        document.forms["form_selected_users"].submit();										
                                      //////////////////////////////////////////
                                     
                                  };
                                };					
    
                           $('#selected_users_id')
                                    .selectize({
                                            plugins: ['remove_button'],
                                            persist: false,
                                            create: true,
                                            maxItems: null,
                                            valueField: 'id',
                                            placeholder: 'Email ...',
                                            labelField: 'title',
                                            searchField: 'title',
                                            options: [
                                                      <?php
                                                        for($m=0;$m<count($resusers);$m++)
                                                        {
                                                      ?>
                                                         {id: '<?=$resusers[$m]['id']?>', title: '<?=$resusers[$m]['email']?>', url: ''},
                                                      <?php
                                                        }
                                                      ?>
                                                      
                                                    ],
                                                    onChange  : eventHandler('onChange'),
                                                });
                });																		
            </script>
            <br>
         </div>
  </div> 
<!--<a href="index.php?cmd=edit" class="btn green"><i class="fa fa-plus-circle"></i> Add a <?=ucwords(str_replace("_"," ","withdraw"))?></a> <br><br>-->
 <div class="portlet box blue">
           <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i><b><?=ucwords(str_replace("_"," ","withdraw"))?></b>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>             
            <div class="portlet-body">
	         <div class="table-responsive">	
                <table class="table">
                 <tr>
						<td align="center" valign="top">
						  <form name="search_frm" id="search_frm" method="post">
							<div class="portlet-body">
					         <div class="table-responsive">	
				                <table align="right">
									  <TR>
										<TD  nowrap="nowrap">
										  <?php
											  $hash    =  getTableFieldsName("withdraw");
											  $hash    = array_diff($hash,array("id"));
										  ?>
										  Search Key:
										  <select   name="field_name" id="field_name"  class="form-control-static">
											<option value="">--Select--</option>
											<?php
											foreach($hash as $key=>$value)
											{
										    ?>
											<option value="<?=$key?>" <?php if($_SESSION['field_name']==$key) echo "selected"; ?>><?=str_replace("_"," ",$value)?></option>
											<?php
										    }
										  ?>
										  </select>
										</TD>
										<TD  nowrap="nowrap" align="right"><label for="searchbar"><img src="../../images/icon_searchbox.png" alt="Search"></label>
										   <input type="text"    name="field_value" id="field_value" value="<?=$_SESSION["field_value"]?>" class="form-control-static"></TD>
										<td nowrap="nowrap" align="right">
										  <input type="hidden" name="cmd" id="cmd" value="search_withdraw" >
										  <input type="submit" name="btn_submit" id="btn_submit"  value="Search" class="btn blue-hoki" />
										</td>
									  </TR>
									</table>
							</div>
							</div>
						  </form>
						</td>
				   </tr>
				   <tr>
				   <td> 
				
						<div class="portlet-body">
				      <div class="table-responsive">	
				          <table class="table">
							<tr bgcolor="#ABCAE0">
                                <td>Users</td>
                                <td>Subject</td>
                                <td>Description</td>
                                <td>Currency</td>
                                <td>Amount</td>
                                <td>Coin Type</td>
                                <td>Coin</td>
                                <td>Refference</td>
                                <td>Date Time Created</td>
                                <td>Date Time Updated</td>                                
                                <td>Action</td>
							</tr>
						 <?php
								
								if($_SESSION["search"]=="yes")
								  {
									$whrstr = " AND ".$_SESSION['field_name']." LIKE '%".$_SESSION["field_value"]."%'";
								  }
								  else
								  {
									$whrstr = "";
								  }
								  
								  if($_SESSION['selected_users_id']>0)
								  {
								    $whrstr .= " AND users_id='".$_SESSION['selected_users_id']."'";	
								  }
								  else
								  {
									$_SESSION['selected_users_id'] = 'all';
								  }
  
						 
								$rowsPerPage = 10;
								$pageNum = 1;
								if(isset($_REQUEST['page']))
								{
									$pageNum = $_REQUEST['page'];
								}
								$offset = ($pageNum - 1) * $rowsPerPage;  
						 
						 
											  
								$info["table"] = "withdraw";
								$info["fields"] = array("withdraw.*"); 
								$info["where"]   = "1   $whrstr ORDER BY id DESC  LIMIT $offset, $rowsPerPage";
													
								
								$arr =  $db->select($info);
								
								for($i=0;$i<count($arr);$i++)
								{
								
								   $rowColor;
						
									if($i % 2 == 0)
									{
										
										$row="#C8C8C8";
									}
									else
									{
										
										$row="#FFFFFF";
									}
								
						 ?>
							<tr bgcolor="<?=$row?>" onmouseover=" this.style.background='#ECF5B6'; " onmouseout=" this.style.background='<?=$row?>'; ">
                                    <td>
                                        <?php
                                            unset($info2);        
                                            $info2['table']    = users;	
                                            $info2['fields']   = array("email");	   	   
                                            $info2['where']    =  "1 AND id='".$arr[$i]['users_id']."' LIMIT 0,1";
                                            $res2  =  $db->select($info2);
                                            echo $res2[0]['email'];	
                                        ?>
                                    </td>
                                    <td><?=$arr[$i]['subject']?></td>
                                    <td><?=$arr[$i]['description']?></td>
                                    <td>
										<?php
                                            unset($info2);        
                                            $info2['table']    = currency;	
                                            $info2['fields']   = array("code");	   	   
                                            $info2['where']    =  "1 AND id='".$arr[$i]['currency_id']."' LIMIT 0,1";
                                            $res2  =  $db->select($info2);
                                            echo $res2[0]['code'];	
                                        ?>
                                    </td>
                                    <td><?=$arr[$i]['amount']?></td>
                                    <td><?=$arr[$i]['coin_type']?></td>
                                    <td><?=$arr[$i]['coin']?></td>
                                    <td><?=$arr[$i]['refference']?></td>
                                    <td><?=$arr[$i]['date_time_created']?></td>
                                    <td><?=$arr[$i]['date_time_updated']?></td>
                                    
                                    <td nowrap >
                                      <a href="index.php?cmd=edit&id=<?=$arr[$i]['id']?>"  class="btn default btn-xs purple"><i class="fa fa-edit"></i>Edit</a>
                                      <a href="index.php?cmd=delete&id=<?=$arr[$i]['id']?>" class="btn btn-sm red filter-cancel"  onClick=" return confirm('Are you sure to delete this item ?');"><i class="fa fa-times"></i>Delete</a> 
                                    </td>
						
							</tr>
						<?php
								  }
						?>
						
						<tr>
						   <td colspan="10" align="center">
							  <?php              
									  unset($info);
					
									   $info["table"] = "withdraw";
									   $info["fields"] = array("count(*) as total_rows"); 
									   $info["where"]   = "1  $whrstr ORDER BY id DESC";
									  
									   $res  = $db->select($info);  
					
												
										$numrows = $res[0]['total_rows'];
										$maxPage = ceil($numrows/$rowsPerPage);
										$self = 'index.php?cmd=list';
										$nav  = '';
										
										$start    = ceil($pageNum/5)*5-5+1;
										$end      = ceil($pageNum/5)*5;
										
										if($maxPage<$end)
										{
										  $end  = $maxPage;
										}
										
										for($page = $start; $page <= $end; $page++)
										//for($page = 1; $page <= $maxPage; $page++)
										{
											if ($page == $pageNum)
											{
												$nav .= "<li>$page</li>"; 
											}
											else
											{
												$nav .= "<li><a href=\"$self&&page=$page\" class=\"nav\">$page</a></li>";
											} 
										}
										if ($pageNum > 1)
										{
											$page  = $pageNum - 1;
											$prev  = "<li><a href=\"$self&&page=$page\" class=\"nav\">[Prev]</a></li>";
									
										   $first = "<li><a href=\"$self&&page=1\" class=\"nav\">[First Page]</a></li>";
										} 
										else
										{
											$prev  = '<li>&nbsp;</li>'; 
											$first = '<li>&nbsp;</li>'; 
										}
									
										if ($pageNum < $maxPage)
										{
											$page = $pageNum + 1;
											$next = "<li><a href=\"$self&&page=$page\" class=\"nav\">[Next]</a></li>";
									
											$last = "<li><a href=\"$self&&page=$maxPage\" class=\"nav\">[Last Page]</a></li>";
										} 
										else
										{
											$next = '<li>&nbsp;</li>'; 
											$last = '<li>&nbsp;</li>'; 
										}
										
										if($numrows>1)
										{
										  echo '<ul id="navlist">';
										   echo $first . $prev . $nav . $next . $last;
										  echo '</ul>';
										}
									?>     
						   </td>
						</tr>
						</table>
						</div>
					 </div>				
				</td>
				</tr>
				</table>
				</div>
			</div>
		</div>
<?php
include("../template/footer.php");
?>









