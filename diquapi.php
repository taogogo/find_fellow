<?php
$provincecode=intval($_GET['provincecode']);//接收省键值
$citycode=intval($_GET['citycode']);//接收城市键值
include './inc/conn.php';
if($provincecode!=""){//如果传递过来的不为空则执行
	$sql="select * from city where provincecode=$provincecode";//查询城市符合属于上边传递过来的省的字段
	$result=mysql_query($sql);//执行SQL查询语句
?>
	<select  name="city"  onchange='queryArea(this.options[this.selectedIndex].value)'><!--下拉列表框开头-->
	<option value='-1' selected>城市</option><!--下拉列表框值开头-->
	<?php while($row=mysql_fetch_row($result)){//循环记录集?>
		<option value="<?= $row[1]?>"><?=$row[2]?></option>
	<?php }?>
	</select>
<?php }?>
<?php
	if($citycode!=""){
	$sql="select * from area where citycode=$citycode";
	$result=mysql_query($sql);
	echo "<select  name=\"area\" >";
          echo "<option value='-1' selected>县/区</option>";
	while($row=mysql_fetch_row($result)){
		echo "<option value='$row[1]'>$row[2]</option>";
	}
	echo "</select>";
}
?>