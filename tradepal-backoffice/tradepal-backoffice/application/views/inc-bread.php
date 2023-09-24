<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    <li class="m-nav__item m-nav__item--home">
        <a href="<?php echo base_url(); ?>" class="m-nav__link m-nav__link--icon">
            <i class="m-nav__link-icon la la-home"></i>
        </a>
    </li>
    <li class="m-nav__separator">
        -
    </li>
    <li class="m-nav__item">
        <a href="" class="m-nav__link">
            <span class="m-nav__link-text">
                Dashboard
            </span>
        </a>
    </li>
    <li class="m-nav__separator">
        -
    </li>
    <li class="m-nav__item">
        <a href="<?php echo base_url($page_url); ?>" class="m-nav__link">
            <span class="m-nav__link-text">
                <?php echo $page_text; ?>
            </span>
        </a>
    </li>
    <li class="m-nav__separator">
        -
    </li>
    <?php if($dealer_name): ?>
    <li class="m-nav__item">
        <a href="javascript:;" class="m-nav__link">
            <span class="m-nav__link-text">
                (<?php echo $dealer_name; ?>)
            </span>
        </a>
    </li>
    <?php endif; ?>
</ul>