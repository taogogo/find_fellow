<?php
class test{

 function _uploadImg( $name , $width =16 ,$height = 16 )
	{
		if( !class_exists( 'SaeStorage' ) )
		{
			$this->redirect( '新浪SaeStorage功能无法使用');
		}
		if ( !$_FILES ) return '';
		$filePath = SAE_TMP_PATH;
		$uuid = md5( uniqid( rand() , true ) );
		$filePath .= $uuid;
		if( move_uploaded_file( $_FILES[ $name ]['tmp_name'] , $filePath ) )
		{
			$data = file_get_contents( $filePath );
			$s = new SaeStorage();
			$pathinfo = pathinfo($_FILES[ $name ]['name']);
			$filename = $uuid .'.'. $pathinfo['extension'];
			try
			{
				$config['storage'] = 'img';
                                $img = new SaeImage();
					$img->setData( $data );
					$img->resize(  110 , 0 );
					$data = $img->exec();
                                        
				$s->write( $config['storage'] , $filename , $data );
			}
			catch( WeiyouxiException $e )
			{
				$this->redirect( $e->getErrorMessage( 'cn' ) );
			}
			$url = $s->getCDNUrl( $config['storage'] , $filename );
                  //var_dump($url);
			if( !$url )
			{
				$this->redirect( '无法获取图片地址' );
			}
			return $url;
                        
		}
		return '';
	}
	function redirect($m)
	{
		echo $m;
		die();
	}
}

if($_FILES['test'])
{
$pic = new test();
  echo "<script>parent.callback('" .  $pic->_uploadImg('test') . "');</script>";
}
else
{
?>  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/static/css/common.css" media="screen" />
<style>
  body,form{margin:0;padding:0;}
</style>
<form action="upload.php" id="form1" name="form1" encType="multipart/form-data"  method="post" target="hidden_frame" >   
   <style>
  </style>
  
  头像:<a href="javascript:void(0);" class="input-file">选择上传<input type="file" id="file"  name="test" style=""  onchange="parent.document.getElementById('picUrl').innerHTML = '上传中…';document.form1.submit()" >  
   </a>
   <!--
  头像:<a href="http://www.baidu.com" target="" class="input-file">选择上传<input type="file" id="file"  name="test" style=""  onchange="parent.document.getElementById('picUrl').innerHTML = '上传中…';document.form1.submit()" >  
   </a>
   -->
<!--
    <div id="picUrl"></div>   -->        
    <iframe name='hidden_frame' id="hidden_frame" style='display:none'></iframe>   
</form>      
  <script type="text/javascript">   
function callback(msg)   
{   
  //alert('ddd');
  // document.getElementById("file").outerHTML = document.getElementById("file").outerHTML;   
  //document.getElementById("msg").innerHTML = "<font color=red>成功</font>";   
  //document.getElementById("picUrl").innerHTML = "<img src='"+msg+"' />"; 
  if( msg == '' )
  {
  alert( '请选择图片' );
   parent.document.getElementById("picUrl").innerHTML='';
  return true;
  }
  parent.document.getElementById("picUrl").innerHTML = '<img style="margin:2px;" height="30" src="'+msg+'" />';
  parent.document.getElementById("avater").value = msg; 
  //document.getElementById("picUrl").innerHTML =
  //'<object type="application/x-shockwave-flash" data="copy.swf?u='+msg+'" width="100" height="40"> <param name="movie" value="copy.swf?u='+msg+'"></object>'
}   
</script> 
<?php ;

}


?>
