<!-- BEGIN SIDEBAR -->
<?php
# Query Menu from Models
$CI = & get_instance();
$CI->load->model('menu_model', 'menu');
$schMenu = $CI->menu->gen_full();
?>

<!-- BEGIN: Aside Menu -->
                    <div 
                        id="m_ver_menu" 
                        class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light "
                        m-menu-vertical="1"
                        m-menu-scrollable="0" m-menu-dropdown-timeout="500"  
                        >
						<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
							<?php foreach ($schMenu as $key => $row): ?>
                            <?php if (in_array($this->session->userdata('scu_pms_fk'), $row['permission']) || in_array('all', $row['permission']) || in_array($this->session->userdata('scu_id'), explode(',', $row['permission'][0]))): ?>
                                <?php $checkSubmenu[$key] = (string) array_search(@$page_url, array_column(array_column($row['subdomain'], 'main_link'), '1')); ?>

                                        <li class="m-menu__item  
                                        <?php echo (@$page_url == $row['main_link'][1]) ? ' m-menu__item--open ' : ''; ?> m-menu__item--submenu m-menu__item--expanded" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                                            <a href="<?php echo base_url($row['main_link'][1]); ?>" class="m-menu__link m-menu__toggle">
                                                <i class="<?php echo $row['icon_class']; ?>"></i>
                                                <span class="m-menu__link-text">
                                                    <?php echo $row['main_link'][0]; ?>
                                                </span>
                                                <?php if (count($row['subdomain']) > 0): ?>
                                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                                <?php endif; ?>
                                            </a>
                                            <?php if (count($row['subdomain']) > 0): ?>
                                                <div class="m-menu__submenu ">
                                                    <ul class="m-menu__subnav">
                                                        <?php foreach ($row['subdomain'] as $skey => $srow): ?>
                                                            <li class="m-menu__item  m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" >
                                                                <a href="<?php echo base_url($srow['main_link'][1]); ?>" class="m-menu__link">
                                                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="m-menu__link-text">
                                                                    <?php echo $srow['main_link'][0]; ?>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                        <!-- <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                                                            <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="m-menu__link-text">
                                                                    User Pages
                                                                </span>
                                                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                                                            </a>
                                                            <div class="m-menu__submenu ">
                                                                <span class="m-menu__arrow"></span>
                                                                <ul class="m-menu__subnav">
                                                                    <li class="m-menu__item " aria-haspopup="true" >
                                                                        <a target="_blank" href="../snippets/pages/user/login-1.html" class="m-menu__link ">
                                                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="m-menu__link-text">
                                                                                Login - 1
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
						</ul>
					</div>
					<!-- END: Aside Menu -->





            
                            