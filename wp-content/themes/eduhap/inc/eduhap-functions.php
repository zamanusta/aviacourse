<?php

function eduhap_header(){
	global $eduhap;

	$eduhap_header_style_opt					 = '';
	$eduhap_preloader_opt					 = '';
	$eduhap_homepage_opt					 = '';
	$eduhap_header_btn_option					 = '';
	$eduhap_header_btn_text					 = '';
	$eduhap_header_btn_link					 = '';

	if ( isset( $eduhap['eduhap_preloader_opt'] ) ) {
		$eduhap_preloader_opt = $eduhap['eduhap_preloader_opt'];
	}		
	
	if ( isset( $eduhap['eduhap_header_style_opt'] ) ) {
		$eduhap_header_style_opt = $eduhap['eduhap_header_style_opt'];
	}	
	

	if ( isset( $eduhap['eduhap_homepage_opt'] ) ) {
		$eduhap_homepage_opt = $eduhap['eduhap_homepage_opt'];
	}
	
	if ( isset( $eduhap['eduhap_header_btn_option'] ) ) {
		$eduhap_header_btn_option = $eduhap['eduhap_header_btn_option'];
	}	
	
	if ( isset( $eduhap['eduhap_header_btn_text'] ) ) {
		$eduhap_header_btn_text = $eduhap['eduhap_header_btn_text'];
	}		
	
	if ( isset( $eduhap['eduhap_header_btn_link'] ) ) {
		$eduhap_header_btn_link = $eduhap['eduhap_header_btn_link'];
	}	


	$eduhap_default_logo_img = get_template_directory_uri() . '/assets/images/dark-logo.png';
	$eduhap_custom_logo_id = get_theme_mod( 'custom_logo' );
	$eduhap_custom_logo = wp_get_attachment_image_src( $eduhap_custom_logo_id , 'full' );	
	
	$eduhap_header_style = get_post_meta(get_the_ID(), '_eduhap_header_style', true);
?>

<?php if($eduhap_preloader_opt == '1' && !$eduhap_homepage_opt == '1') { ?>
		<!-- START PRELOADER -->
		<div class="preloader">
			<div class="status">
				<div class="status-mes"></div>
			</div>
		</div>
		 <!--  END PRELOADER -->		 
	
	<?php }elseif($eduhap_preloader_opt == '1' && $eduhap_homepage_opt == '1'){ ?>	

	<?php if(is_front_page()) {?>
		<!-- START PRELOADER -->
		<div class="preloader">
			<div class="status">
				<div class="status-mes"></div>
			</div>
		</div>
		<!-- END PRELOADER -->
	<?php } }
	
 	
		if(!empty($eduhap_header_style)){
			if($eduhap_header_style == '1'){
				eduhap_header_one();			
			}elseif($eduhap_header_style == '2'){
				eduhap_header_two();			
			}elseif($eduhap_header_style == '3'){
				eduhap_header_three();
			}elseif($eduhap_header_style == '4'){
				eduhap_header_four();
			}

		}else{
			if($eduhap_header_style_opt == '1'){
				eduhap_header_one();			
			}elseif($eduhap_header_style_opt == '3'){
				eduhap_header_three();
			}elseif($eduhap_header_style_opt == '4'){
				eduhap_header_four();
			}else{
				eduhap_header_two();	
			}		
		}
	
	
}


function eduhap_mobile_menu() {?>
	<div class="mobile-menu">
		<div class="top-close-menu"><i class="fa fa-times" aria-hidden="true"></i></div>
		 <?php eduhap_main_menu();?>
	</div>
<?php
}

function eduhap_header_one(){
	global $eduhap;
	
	$eduhap_header_top_opt					 = '';
	$eduhap_header_top_text					 = '';
	$eduhap_header_social_option					 = '';
	
	if ( isset( $eduhap['eduhap_header_top_opt'] ) ) {
		$eduhap_header_top_opt = $eduhap['eduhap_header_top_opt'];
	}	
	
	if ( isset( $eduhap['eduhap_header_top_text'] ) ) {
		$eduhap_header_top_text = $eduhap['eduhap_header_top_text'];
	}		
	
	if ( isset( $eduhap['eduhap_header_social_option'] ) ) {
		$eduhap_header_social_option = $eduhap['eduhap_header_social_option'];
	}	
	
	$eduhap_default_logo_img = get_template_directory_uri() . '/assets/images/dark-logo.png';
	$eduhap_custom_logo_id = get_theme_mod( 'custom_logo' );
	$eduhap_custom_logo = wp_get_attachment_image_src( $eduhap_custom_logo_id , 'full' );
	
	if($eduhap_header_top_opt){
	?>
	<header id="top-header"> 
		<div class="header-top header-one">
			<div class="container-fluid container-padding">
				<div class="row align-items-center">
					<div class="col-lg-6 col-md-6">
						<p><?php echo eduhap_wp_kses($eduhap_header_top_text);?></p>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="header-right float-lg-end">
						   <?php eduhap_top_menu();?>
						</div>
					</div>
				</div>
			</div>    
		</div>
	<?php } ?>
	
		<!-- Main Menu Start -->   
		<div class="site-navigation main_menu menu-transparent" id="mainmenu-area">
			<nav class="navbar navbar-expand-lg">
				<div class="container-fluid container-padding">
					<?php if(get_custom_logo()){ ?>				  
						<a href="<?php echo esc_url(home_url('/'));?>" class="navbar-brand"><img src="<?php echo esc_url($eduhap_custom_logo[0]);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
							<?php	}else { ?>
						 <a href="<?php echo esc_url(home_url('/'));?>" class="navbar-brand"><img src="<?php echo esc_url($eduhap_default_logo_img);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
					<?php } ?>
					<div class="menu-toggle"> <i class="fa fa-bars" aria-hidden="true"></i> </div>
					<!-- Collapse -->
					<div class="collapse navbar-collapse" id="navbarMenu">
						<?php eduhap_main_menu();?>
						<div class="d-flex align-items-center">
							<div class="header-socials social-links d-none d-lg-none d-xl-block">
							<?php foreach((array) $eduhap_header_social_option as $social){ 
					
								$title = $url = '';

								if ( isset( $social['title'] ) )
									$title = $social['title'] ;

								if ( isset( $social['url'] ) )
									$url = $social['url'] ;
							
								?>
								
								<a href="<?php echo esc_url($url);?>"><i class="<?php echo esc_attr($title);?>"></i></a>
								
								<?php } ?>	
							</div>
		
							<?php eduhap_header_search_form();?>
						</div>
					   
					</div> <!-- / .navbar-collapse -->
				</div> <!-- / .container -->
			</nav>
		</div>
	</header>	
<?php 	
}

function eduhap_header_two(){ 

	global $eduhap;
	
	$eduhap_header_log_btn_text					 = '';
	$eduhap_header_log_btn_link					 = '';
	$eduhap_header_sign_btn_text					 = '';
	$eduhap_header_sign_btn_link					 = '';

	if ( isset( $eduhap['eduhap_header_log_btn_text'] ) ) {
		$eduhap_header_log_btn_text = $eduhap['eduhap_header_log_btn_text'];
	}
	
	if ( isset( $eduhap['eduhap_header_log_btn_link'] ) ) {
		$eduhap_header_log_btn_link = $eduhap['eduhap_header_log_btn_link'];
	}
	
	if ( isset( $eduhap['eduhap_header_sign_btn_text'] ) ) {
		$eduhap_header_sign_btn_text = $eduhap['eduhap_header_sign_btn_text'];
	}
	
	if ( isset( $eduhap['eduhap_header_sign_btn_link'] ) ) {
		$eduhap_header_sign_btn_link = $eduhap['eduhap_header_sign_btn_link'];
	}
	
	$eduhap_default_logo_img = get_template_directory_uri() . '/assets/images/dark-logo.png';
	$eduhap_custom_logo_id = get_theme_mod( 'custom_logo' );
	$eduhap_custom_logo = wp_get_attachment_image_src( $eduhap_custom_logo_id , 'full' );
?>

<div class="site-navigation main_menu menu-style-2" id="mainmenu-area">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
				<?php if(get_custom_logo()){ ?>				  
					<a href="<?php echo esc_url(home_url('/'));?>" class="navbar-brand"><img src="<?php echo esc_url($eduhap_custom_logo[0]);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
						<?php	}else { ?>
					 <a href="<?php echo esc_url(home_url('/'));?>" class="navbar-brand"><img src="<?php echo esc_url($eduhap_default_logo_img);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
				<?php } ?>

              <div class="menu-toggle"> <i class="fa fa-bars" aria-hidden="true"></i> </div>

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbarMenu">
                    <?php eduhap_main_menu();?>
                    
                    <div class="header-login">
						<?php if(!is_user_logged_in()) {
							if($eduhap_header_log_btn_link){ ?>
							<a href="<?php echo esc_url($eduhap_header_log_btn_link);?>" class="btn btn-solid-border btn-sm"><?php echo esc_html($eduhap_header_log_btn_text);?></a>
							<?php } if($eduhap_header_sign_btn_link){ ?>
							<a href="<?php echo esc_url($eduhap_header_sign_btn_link);?>" class="btn btn-main btn-sm"><?php echo esc_html($eduhap_header_sign_btn_text);?></a>
						<?php } }else{ echo esc_attr('You are Logged in');} ?>
					</div>
                </div> <!-- / .navbar-collapse -->
            </div> <!-- / .container -->
        </nav>
    </div>	
<?php 

}

function eduhap_header_three(){ 

	global $eduhap;
	
	$eduhap_header_social_option					 = '';
	$eduhap_header_log_btn_text					 = '';
	$eduhap_header_log_btn_link					 = '';

	if ( isset( $eduhap['eduhap_header_social_option'] ) ) {
		$eduhap_header_social_option = $eduhap['eduhap_header_social_option'];
	}	

	if ( isset( $eduhap['eduhap_header_log_btn_text'] ) ) {
		$eduhap_header_log_btn_text = $eduhap['eduhap_header_log_btn_text'];
	}
	
	if ( isset( $eduhap['eduhap_header_log_btn_link'] ) ) {
		$eduhap_header_log_btn_link = $eduhap['eduhap_header_log_btn_link'];
	}
	
	
	$eduhap_default_logo_img = get_template_directory_uri() . '/assets/images/dark-logo.png';
	$eduhap_custom_logo_id = get_theme_mod( 'custom_logo' );
	$eduhap_custom_logo = wp_get_attachment_image_src( $eduhap_custom_logo_id , 'full' );
?>

<div class="site-navigation main_menu menu-style-2" id="mainmenu-area">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-4">
				<?php if(get_custom_logo()){ ?>				  
					<a href="<?php echo esc_url(home_url('/'));?>" class="navbar-brand"><img src="<?php echo esc_url($eduhap_custom_logo[0]);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
						<?php }else { ?>
					 <a href="<?php echo esc_url(home_url('/'));?>" class="navbar-brand"><img src="<?php echo esc_url($eduhap_default_logo_img);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
				<?php } ?>

				<div class="menu-toggle"> <i class="fa fa-bars" aria-hidden="true"></i> </div>
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbarMenu">
                   <?php eduhap_header_search_form();?>

					<?php eduhap_main_menu();?>
                    
                    <div class="d-flex align-items-center">
                        <div class="header-socials social-links d-none d-lg-none d-xl-block">
							<?php foreach((array) $eduhap_header_social_option as $social){ 
					
								$title = $url = '';

								if ( isset( $social['title'] ) )
									$title = $social['title'] ;

								if ( isset( $social['url'] ) )
									$url = $social['url'] ;
							
								?>
								
								<a href="<?php echo esc_url($url);?>"><i class="<?php echo esc_attr($title);?>"></i></a>
								
								<?php } ?>							

                        </div>
						
                       <?php 
					    if(!is_user_logged_in()) {
					   if($eduhap_header_log_btn_link){ ?>
                        <div class="header-login ms-3">						
                            <a href="<?php echo esc_url($eduhap_header_log_btn_link);?>" class="btn btn-solid-border btn-sm "><?php echo esc_html($eduhap_header_log_btn_text);?></a>							
                        </div>
					   <?php 					   
					   } 
						}else{ echo eduhap_wp_kses('<span class="head_log">You are Logged in</span>');};
					   ?>
						
                    </div>
                </div> <!-- / .navbar-collapse -->
            </div> <!-- / .container -->
        </nav>
    </div>
<?php	

}


function eduhap_header_four(){ 

	global $eduhap;

	$eduhap_header_top_opt					 = '';
	$eduhap_header_top_text					 = '';
	$eduhap_header_social_option					 = '';
	$eduhap_header_log_btn_text					 = '';
	$eduhap_header_log_btn_link					 = '';

	if ( isset( $eduhap['eduhap_header_top_opt'] ) ) {
		$eduhap_header_top_opt = $eduhap['eduhap_header_top_opt'];
	}

	if ( isset( $eduhap['eduhap_header_top_text'] ) ) {
		$eduhap_header_top_text = $eduhap['eduhap_header_top_text'];
	}
	
	if ( isset( $eduhap['eduhap_header_social_option'] ) ) {
		$eduhap_header_social_option = $eduhap['eduhap_header_social_option'];
	}		

	if ( isset( $eduhap['eduhap_header_log_btn_text'] ) ) {
		$eduhap_header_log_btn_text = $eduhap['eduhap_header_log_btn_text'];
	}
	
	if ( isset( $eduhap['eduhap_header_log_btn_link'] ) ) {
		$eduhap_header_log_btn_link = $eduhap['eduhap_header_log_btn_link'];
	}
	
	
	$eduhap_default_logo_img = get_template_directory_uri() . '/assets/images/dark-logo.png';
	$eduhap_custom_logo_id = get_theme_mod( 'custom_logo' );
	$eduhap_custom_logo = wp_get_attachment_image_src( $eduhap_custom_logo_id , 'full' );


if($eduhap_header_top_opt){

	?>
	<div class="header-top ">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-8 text-center text-md-start ">
					<p><?php echo eduhap_wp_kses($eduhap_header_top_text);?></p>
				</div>
				<div class="col-lg-6 col-md-4">
					<div class="header-right float-md-end text-center">
						<div class="header-socials">
							<?php foreach((array) $eduhap_header_social_option as $social){ 

							$title = $url = '';

							if ( isset( $social['title'] ) )
								$title = $social['title'] ;

							if ( isset( $social['url'] ) )
								$url = $social['url'] ;

							?>

							<a href="<?php echo esc_url($url);?>"><i class="<?php echo esc_attr($title);?>"></i></a>

							<?php } ?>							

						</div>
					</div>
				</div>
			</div>
		</div>    
	</div>
	
	<?php } ?>

<div class="site-navigation main_menu menu-style-2" id="mainmenu-area">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
				<?php if(get_custom_logo()){ ?>				  
					<a href="<?php echo esc_url(home_url('/'));?>" class="navbar-brand"><img src="<?php echo esc_url($eduhap_custom_logo[0]);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
						<?php }else { ?>
					 <a href="<?php echo esc_url(home_url('/'));?>" class="navbar-brand"><img src="<?php echo esc_url($eduhap_default_logo_img);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
				<?php } ?>

				<div class="menu-toggle"> <i class="fa fa-bars" aria-hidden="true"></i> </div>
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbarMenu">                  
					<?php eduhap_main_menu();?>
                    
                    <div class="d-flex align-items-center">
                       <?php 
					    if(!is_user_logged_in()) {
					   if($eduhap_header_log_btn_link){ ?>
                        <div class="header-login ms-3">						
                            <a href="<?php echo esc_url($eduhap_header_log_btn_link);?>" class="btn btn-solid-border btn-sm "><?php echo esc_html($eduhap_header_log_btn_text);?></a>							
                        </div>
					   <?php 					   
					   } 
						}else{ echo eduhap_wp_kses('<span class="head_log">You are Logged in</span>');};
					   ?>
						
                    </div>
                </div> <!-- / .navbar-collapse -->
            </div> <!-- / .container -->
        </nav>
    </div>
<?php	

}

function eduhap_footer(){
	global $eduhap;

	$eduhap_footer_style					 = '';
	$eduhap_scroll_switch					 = '';


	if ( isset( $eduhap['eduhap_scroll_switch'] ) ) {
		$eduhap_scroll_switch = $eduhap['eduhap_scroll_switch'];
	}	

	if ( isset( $eduhap['eduhap_footer_style'] ) ) {
		$eduhap_footer_style = $eduhap['eduhap_footer_style'];
	}
	
	$eduhap_footer_style_opt = get_post_meta(get_the_ID(), '_eduhap_footer_style', true);

		if(!empty($eduhap_footer_style_opt)){
			if($eduhap_footer_style_opt == '1'){
				eduhap_footer_one();			
			}elseif($eduhap_footer_style_opt == '2'){
				eduhap_footer_two();			
			}

		}else{
			if($eduhap_footer_style == '1'){
				eduhap_footer_one();			
			}else{
				eduhap_footer_two();	
			}		
		}
		
	 if($eduhap_scroll_switch == true){ ?>
	 
	<!-- Start progress-wrap -->
	<div class="progress-wrap">
		<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
			<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
		</svg>
	</div>
	<!-- End progress-wrap -->
	
	<?php } 	

}


function eduhap_footer_one(){
	global $eduhap;

	$eduhap_footer_top_opt					 = '';
	$eduhap_copyright_text					 = '';

	if ( isset( $eduhap['eduhap_footer_top_opt'] ) ) {
		$eduhap_footer_top_opt = $eduhap['eduhap_footer_top_opt'];
	}		

	if ( isset( $eduhap['eduhap_copyright_text'] ) ) {
		$eduhap_copyright_text = $eduhap['eduhap_copyright_text'];
	}		
	
	$eduhap_footer_top_padding = get_post_meta(get_the_ID(), '_eduhap_footer_top_padding', true);

?>
<section class="footer ">
	<?php if($eduhap_footer_top_opt == true){ ?>
	<div class="footer-top <?php if($eduhap_footer_top_padding == '1'){ echo esc_attr('pt-190');}?>">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 me-auto col-sm-6 col-md-6">
					<div class="widget mb-5 mb-lg-0">
						<?php dynamic_sidebar( 'sidebar-2' ); ?>
					</div>
				</div>
				
				<div class="col-xl-7 ms-auto col-lg-7 col-md-12 col-sm-12">
					<div class="row">
						<?php dynamic_sidebar( 'sidebar-4' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="footer-btm">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-xl-6 col-lg-4 col-md-12">
					<div class="copyright">
						<p>
						<?php
						if($eduhap_copyright_text){
							echo eduhap_wp_kses($eduhap_copyright_text);
						}else{ ?>							
							<?php esc_html_e('© Copyright Eduhap Theme All rights reserved.Crafted by Themesvila' , 'eduhap');?>
						<?php } ?>						
						</p>
					</div>
				</div>
				<div class="col-xl-6 col-lg-8 col-md-12">
					<div class="footer_menu">
						<?php eduhap_footer_menu();?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php	
}

function eduhap_footer_two(){
	global $eduhap;

	$eduhap_footer_logo					 = '';
	$eduhap_footer_top_opt					 = '';
	$eduhap_copyright_text					 = '';

	if ( isset( $eduhap['eduhap_footer_logo']['url'] ) ) {
		$eduhap_footer_logo = $eduhap['eduhap_footer_logo']['url'];
	}
	if ( isset( $eduhap['eduhap_footer_top_opt'] ) ) {
		$eduhap_footer_top_opt = $eduhap['eduhap_footer_top_opt'];
	}		

	if ( isset( $eduhap['eduhap_copyright_text'] ) ) {
		$eduhap_copyright_text = $eduhap['eduhap_copyright_text'];
	}		
	$eduhap_footer_top_padding = get_post_meta(get_the_ID(), '_eduhap_footer_top_padding', true);
	$footer_logo = get_template_directory_uri() . '/assets/images/light-logo.png'
?>
<section class="footer-2">
	<?php if($eduhap_footer_top_opt == true){ ?>
	<div class="footer-top <?php if($eduhap_footer_top_padding == '1'){ echo esc_attr('pt-190');}?>">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-sm-6 col-md-8 col-xl-3 col-sm-6">
					<div class="footer-widget footer-about mb-5 mb-lg-0">
						<?php dynamic_sidebar( 'sidebar-3' ); ?>
					</div>
				</div>
				
				<div class="col-xl-7 ms-auto col-lg-7 col-md-12 col-sm-12">
					<div class="row">
						<?php dynamic_sidebar( 'sidebar-4' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="footer-btm">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-xl-6 col-lg-4 col-md-12">
					<div class="footer-logo text-lg-start text-center mb-4 mb-lg-0">
						<?php if($eduhap_footer_logo){ ?>
							<a href="<?php echo esc_url(home_url('/'));?>"><img src="<?php echo esc_url($eduhap_footer_logo);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="img-fluid"></a>
						
						<?php }else{ ?>
							<a href="<?php echo esc_url(home_url('/'));?>"><img src="<?php echo esc_url($footer_logo);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="img-fluid"></a>
					
						<?php } ?>
					</div>
				</div>
				<div class="col-xl-6 col-lg-8 col-md-12">
					<div class="copyright text-lg-end text-center">
						<p>
						<?php
						if($eduhap_copyright_text){
							echo eduhap_wp_kses($eduhap_copyright_text);
						}else{ ?>							
							<?php esc_html_e('© Copyright Eduhap Theme All rights reserved.Crafted by Themesvila' , 'eduhap');?>
						<?php } ?>							
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php	
}

function eduhap_banner_shop_text(){
	global $eduhap;
	$eduhap_shop_title						 = '';

	if ( isset( $eduhap['eduhap_shop_title']) ) {
		$eduhap_shop_title = $eduhap['eduhap_shop_title'];
	}
	
	if($eduhap_shop_title){
		echo esc_html($eduhap_shop_title);
	}else{
		echo esc_html__('Shop' , 'eduhap');
	}
}

function eduhap_banner_blog_text(){
	global $eduhap;
	$eduhap_blog_title						 = '';

	if ( isset( $eduhap['eduhap_blog_title']) ) {
		$eduhap_blog_title = $eduhap['eduhap_blog_title'];
	}
	
	if($eduhap_blog_title){
		echo esc_html($eduhap_blog_title);
	}else{
		echo esc_html__('Blog' , 'eduhap');
	}
}


function eduhap_banner_home_text(){
	global $eduhap;
	$eduhap_home_title						 = '';

	if ( isset( $eduhap['eduhap_home_title']) ) {
		$eduhap_home_title = $eduhap['eduhap_home_title'];
	}
	
	if($eduhap_home_title){
		echo esc_html($eduhap_home_title);
	}else{
		echo esc_html__('Home' , 'eduhap');
	}
}


function eduhap_banner_404_title(){
	global $eduhap;
	$eduhap_404_title_text						 = '';

	if ( isset( $eduhap['eduhap_404_title_text']) ) {
		$eduhap_404_title_text = $eduhap['eduhap_404_title_text'];
	}
	
	if($eduhap_404_title_text){
		echo esc_html($eduhap_404_title_text);
	}else{
		echo esc_html__('404 Error' , 'eduhap');
	}
}



function eduhap_shop_banner(){ 

?>

<section class="page-header">
  <div class="container">
	<div class="row justify-content-center">
	  <div class="col-lg-8 col-xl-8">
		<div class="title-block">
		  <h1><?php eduhap_banner_shop_text();?></h1>
		  <ul class="list-inline mb-0">
			<li class="list-inline-item">
			  <a href="<?php echo esc_url(home_url('/'));?>"><?php eduhap_banner_home_text();?></a>
			</li>
			 <li class="list-inline-item">/</li>
			<li class="list-inline-item">
				<?php eduhap_banner_shop_text();?>
			</li>
		  </ul>
		</div>
	  </div>
	</div>
  </div>
</section>
	
<?php }

function eduhap_single_product_banner(){ 
$shop_url = get_permalink( wc_get_page_id( 'shop' ) );
?>

<section class="page-header">
  <div class="container">
	<div class="row justify-content-center">
	  <div class="col-lg-8 col-xl-8">
		<div class="title-block">
		  <h1><?php the_title();?></h1>
		  <ul class="list-inline mb-0">
			<li class="list-inline-item">
			  <a href="<?php echo esc_url(home_url('/'));?>"><?php eduhap_banner_home_text();?></a>
			</li>			
			<li class="list-inline-item">/</li>
			<li class="list-inline-item">
			  <a href="<?php echo esc_url($shop_url);?>"><?php eduhap_banner_shop_text();?></a>
			</li>
			 <li class="list-inline-item">/</li>
			<li class="list-inline-item">
				<?php the_title();?>
			</li>
		  </ul>
		</div>
	  </div>
	</div>
  </div>
</section>
	
<?php }

function eduhap_blog_banner(){ 

?>

<section class="page-header">
  <div class="container">
	<div class="row justify-content-center">
	  <div class="col-lg-8 col-xl-8">
		<div class="title-block">
		  <h1><?php eduhap_banner_blog_text();?></h1>
		  <ul class="list-inline mb-0">
			<li class="list-inline-item">
			  <a href="<?php echo esc_url(home_url('/'));?>"><?php eduhap_banner_home_text();?></a>
			</li>
			 <li class="list-inline-item">/</li>
			<li class="list-inline-item">
				<?php eduhap_banner_blog_text();?>
			</li>
		  </ul>
		</div>
	  </div>
	</div>
  </div>
</section>


<?php }

function eduhap_single_banner(){ 

?>

<section class="page-header">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-8">
        <div class="title-block">
          <h1><?php the_title();?></h1>
          <ul class="list-inline mb-0">
            <li class="list-inline-item">
              <a href="<?php echo esc_url(home_url('/'));?>"><?php eduhap_banner_home_text();?></a>
            </li>
             <li class="list-inline-item">/</li>
            <li class="list-inline-item">
                <?php the_title();?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<?php }

function eduhap_archive_banner(){ 
	global $eduhap;
	$eduhap_archive_title						 = '';

	if ( isset( $eduhap['eduhap_archive_title']) ) {
		$eduhap_archive_title = $eduhap['eduhap_archive_title'];
	}
?>

<section class="page-header">
  <div class="container">
	<div class="row justify-content-center">
	  <div class="col-lg-8 col-xl-8">
		<div class="title-block">
		  <h1>
			<?php
				if($eduhap_archive_title){
					echo esc_html($eduhap_archive_title);
				}else{
					echo esc_html__('Archive' , 'eduhap');
				}
			?>
		  </h1>
		  <ul class="list-inline mb-0">
			<li class="list-inline-item">
				<a href="<?php echo esc_url(home_url('/'));?>"><?php eduhap_banner_home_text();?></a>
			</li>
			 <li class="list-inline-item">/</li>
			<li class="list-inline-item">
				<?php
				the_archive_title();				
				?>
			</li>
		  </ul>
		</div>
	  </div>
	</div>
  </div>
</section>


<?php }

function eduhap_search_banner(){ 
	global $eduhap;
	$eduhap_search__title						 = '';

	if ( isset( $eduhap['eduhap_search__title']) ) {
		$eduhap_search__title = $eduhap['eduhap_search__title'];
	}
?>

<section class="page-header">
  <div class="container">
	<div class="row justify-content-center">
	  <div class="col-lg-8 col-xl-8">
		<div class="title-block">
		  <h1>
			<?php
				if($eduhap_search__title){
					echo esc_html($eduhap_search__title);
				}else{
					echo esc_html__('Search Result' , 'eduhap');
				}
			?>		  
		  </h1>
		  <ul class="list-inline mb-0">
			<li class="list-inline-item">
			  <a href="<?php echo esc_url(home_url('/'));?>"><?php eduhap_banner_home_text();?></a>
			</li>
			 <li class="list-inline-item">/</li>
			<li class="list-inline-item">
				<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'eduhap' ), '<span>' . get_search_query() . '</span>' );
					?>
			</li>
		  </ul>
		</div>
	  </div>
	</div>
  </div>
</section>


<?php }


function eduhap_course_banner(){ 
	global $eduhap;
	$eduhap_course_title						 = '';

	if ( isset( $eduhap['eduhap_course_title']) ) {
		$eduhap_course_title = $eduhap['eduhap_course_title'];
	}
?>


<section class="page-header">
  <div class="container">
	<div class="row justify-content-center">
	  <div class="col-lg-8 col-xl-8">
		<div class="title-block">
		  <h1>
			<?php
				if($eduhap_course_title){
					echo esc_html($eduhap_course_title);
				}elseif(is_archive()){
					echo get_the_archive_title();
				}else{
					echo esc_html__('Course' , 'eduhap');
				}
			?>			  
		  </h1>
		  <ul class="list-inline mb-0">
			<li class="list-inline-item">
			  <a href="<?php echo esc_url(home_url('/'));?>"><?php eduhap_banner_home_text();?></a>
			</li>
			 <li class="list-inline-item">/</li>
			<li class="list-inline-item">
				<?php
				if($eduhap_course_title){
					echo esc_html($eduhap_course_title);
				}else{
					echo esc_html__('Course' , 'eduhap');
				}
				?>
			</li>
		  </ul>
		</div>
	  </div>
	</div>
  </div>
</section>

<?php }

function eduhap_single_course_banner(){ 
	$eduhap_course_link = get_post_type_archive_link(get_post_type());
?>

<section class="page-header">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-8">
        <div class="title-block">
          <h1><?php the_title();?></h1>
          <ul class="list-inline mb-0">
            <li class="list-inline-item">
              <a href="<?php echo esc_url(home_url('/'));?>"><?php eduhap_banner_home_text();?></a>
            </li>
			<li class="list-inline-item">/</li>
            <li class="list-inline-item"><a href="<?php echo esc_url($eduhap_course_link);?>"><?php esc_html_e('Courses' , 'eduhap');?></a></li>
            <li class="list-inline-item">/</li>
			<li class="list-inline-item">
                <?php the_title();?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<?php }

function eduhap_404_body_title(){
	global $eduhap;
	$eduhap_404_page_title						 = '';

	if ( isset( $eduhap['eduhap_404_page_title']) ) {
		$eduhap_404_page_title = $eduhap['eduhap_404_page_title'];
	}
	
	if($eduhap_404_page_title){
		echo esc_html($eduhap_404_page_title);
	}else{
		echo esc_html__('404' , 'eduhap');
	}	
}

function eduhap_404_body_subtitle(){
	global $eduhap;
	$eduhap_404_page_subtitle						 = '';

	if ( isset( $eduhap['eduhap_404_page_subtitle']) ) {
		$eduhap_404_page_subtitle = $eduhap['eduhap_404_page_subtitle'];
	}
	
	if($eduhap_404_page_subtitle){
		echo esc_html($eduhap_404_page_subtitle);
	}else{
		echo esc_html__('Try using the button below to go to main page of the site' , 'eduhap');
	}	
}

function eduhap_404_body_content(){
	global $eduhap;
	
	$eduhap_404_page_descrption						 = '';

	if ( isset( $eduhap['eduhap_404_page_descrption']) ) {
		$eduhap_404_page_descrption = $eduhap['eduhap_404_page_descrption'];
	}
	
	if($eduhap_404_page_descrption){
		echo esc_html($eduhap_404_page_descrption);
	}else{
		echo esc_html__('It looks like nothing was found at this location. Maybe try one of the links below or a search?' , 'eduhap');
	}	
}

function eduhap_404_content(){
	global $eduhap;
	
	$eduhap_404_btn_text						 = '';

	if ( isset( $eduhap['eduhap_404_btn_text']) ) {
		$eduhap_404_btn_text = $eduhap['eduhap_404_btn_text'];
	}	
	
?>

<div class="page-wrapper 404_page">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mx-auto">
              <div class="error-page text-center error-404 not-found">
                 <div class="error-header">
                    <h2><strong><?php eduhap_404_body_title();?></strong></h2>
                 </div>
                 <div class="error-message">
                    <h3><?php eduhap_404_body_subtitle();?></h3>
                 </div>
                 
                 <div class="error-content">
                    <?php eduhap_404_body_content(); ?><br>
                    <a href="<?php echo esc_url(home_url('/'));?>" class="btn btn-main"><?php echo esc_html($eduhap_404_btn_text);?></a>
                 </div>
              </div>
           </div>
        </div>
    </div><!-- #main -->
</div>	

	<?php
}