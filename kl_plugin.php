<?php
		/*
		Plugin Name:Keyword Linker
		Plugin URI: http://www.brandsms.ir
		Version: v0.0.0.1
		Author:<a href="http://www.brandsms.ir">M.Shahbazi</a>
		Description:با این افزونه کلمات موردنظر شما به آدرس تعیین شده به صورت اتوماتیک لینک میشوند 
	*/
	
	
add_action('admin_menu','show_kl_setting');
//add_action('the_content','kl_check_post');
//add_filter('wp_insert_post_data','kl_check_post', '99', 2 );
//add_filter('save_post','dumpme', '99', 2 );
add_filter( 'wp_insert_post_data' , 'kl_filter_post_data' , '99', 2 );



function dumpme() { 
	global $post_data;
	print "Dump $ POST :<hr>";
	var_dump($_POST);
	print "<hr>";
	print "Dump $ post_data :<hr>";
	var_dump($post_data);
	if(!empty($post_data)) { 
	die('dumped!');
	}
}	
function show_kl_setting() {
	add_menu_page('klmenu', 'لینکلمه', 10, 'klmenu', 'kl_admin');
	add_submenu_page('klmenu', 'تنظیمات', 'تنظیمات', 10, 'kl_admin', 'kl_admin');
}

function kl_admin() { 
	include('kl_admin_setting.php');
}



function kl_fetch_keywords() { 
	$t=get_option('kl_keylink_list');
	$keyv=explode(',',$t);
	$m=0;
	$p=0;
	foreach ($keyv as $keyn) { 
		$tk=explode('|',$keyn);
		$keywords[$m][0]=$tk[0];
		$keywords[$m][1]=$tk[1];
		$m++;
	}
	return $keywords;
}

function show_keylink_list() { 
	$keyw=kl_fetch_keywords();
	?>
	<table style="border:1px solid #000;">
		<tr><td style="border:1px solid #000;">عنوان </td><td style="border:1px solid #000;">لینک به </td></tr>
	<?

	for ($u=0;$u<count($keyw);$u++) { 
		print '<tr><td style="border:1px solid #000;">'.$keyw[$u][0].'</td><td style="border:1px solid #000;">'.$keyw[$u][1].'</td></tr>';

	}
	?>
		</table>
		<?
}

function kl_filter_post_data( $data , $postarr ) { 
	if(isset($data)) { 
	$keyw=kl_fetch_keywords();
	$cme=0;
	$limit=get_option('kl_limit');
		if ($limit == 0) { $limit = '100000000'; }
			for ($u=0;$u<count($keyw);$u++) { 
				if ( $limit > $cme) { 
					$data['post_content'] = str_replace($keyw[$u][0],'<a href="'.$keyw[$u][1].'">'.$keyw[$u][0].'</a>',$data['post_content']);
				} 
				$cme++;
			}
	}
return $data;
}
?>