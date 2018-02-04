<?php
	if(isset($_GET['clean'])) { 
		if($_GET['clean'] == 'ok') { 
			update_option('kl_keylink_list',NULL);
		}
}
	if(isset($_POST['do'])) { 
		
		if(!empty($_POST['kl_title']) AND !empty($_POST['kl_link']))  {
			
			$getlast=get_option('kl_keylink_list');
				if (empty($getlast)) { 
					$b=$_POST['kl_title']."|".$_POST['kl_link'].",";
					$final=$getlast.$b;
				}else { 
					$b=$_POST['kl_title']."|".$_POST['kl_link'];
					$final=$getlast.",".$b;	
					}
			update_option('kl_keylink_list',$final);
			update_option('kl_limit',$_POST['kl_limit']);
			
		} else { 
			echo "اطلاعات ناقص وارد شده است . کلمه و لینک مربوطه را وارد کنید ";
		}
		
		echo 'تنظیمات ذخیره شد ';
	}
	
	
	?>
<form method="post">
<table>
		<tr><td>محدودیت لینک در هر صفحه:<br /> برای نامحدود بودن 0 را واردکنید</td><td>حداکثر<input type="text" name="kl_limit" size="1" value="<?php echo get_option('kl_limit'); ?>">لینک در هر صفحه</td></tr>
		<tr><td>کلمه:</td><td><input type="text" name="kl_title"></td></tr>
		<tr><td>لینک:</td><td><input type="text" name="kl_link"></td></tr>
			<input type="hidden" name="do">
	<tr><td><input type="submit"  value="ذخیره">
</table>
			<?php show_keylink_list(); ?>
			<a href="?page=klmenu&clean=ok"> حذف کلمات </a>
</form>