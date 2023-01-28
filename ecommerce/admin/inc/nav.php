<?php

/**
 * nav.php
 *
 * Author: pixelcave
 *
 * The sidebar of the page, contains the main search and navigation as well as some theme options
 *
 */
?>
<!-- Sidebar -->
<aside id="page-sidebar" class="collapse navbar-collapse navbar-main-collapse">
    <!-- Sidebar search -->
    <form id="sidebar-search" action="page_search_results.php" method="post">
        <div class="input-group">
            <input type="text" id="sidebar-search-term" name="sidebar-search-term" placeholder="Search..">
            <button><i class="fa fa-search"></i></button>
        </div>
    </form>
    <!-- END Sidebar search -->

    <!-- Primary Navigation -->
    <nav id="primary-nav">
        <?php if ($primary_nav) { ?>
            <ul>
                <?php foreach ($primary_nav as $key => $link) {
                    // Get vital info of links
                    $url = (isset($link['url']) && $link['url']) ? "?" . $link['url'] : '#';
                    $active = (isset($link['url']) && ($template['active_page'] == $link['url'])) ? ' class="active"' : '';
                    $icon = (isset($link['icon']) && $link['icon']) ? '<i class="' . $link['icon'] . '"></i>' : '';

                    // Check if we need add the class active to the li element (only if a sublink is active)
                    $li_active = '';

                    if (isset($link['sub']) && $link['sub']) {
                        foreach ($link['sub'] as $sub_link) {
                            if (in_array($template['active_page'], $sub_link)) {
                                $li_active = ' class="active"';
                                break;
                            }
                        }
                    }
                ?>
                    <li<?php echo $li_active; ?>>
                        <a href="<?php echo $url; ?>" <?php echo $active ?>><?php echo $icon . $link['name']; ?></a>
                        <?php if (isset($link['sub']) && $link['sub']) { ?>
                            <ul>
                                <?php foreach ($link['sub'] as $sub_link) {
                                    // Get vital info of sublinks
                                    $url = (isset($sub_link['url']) && $sub_link['url']) ? "?" . $sub_link['url'] : '#';
                                    $active = (isset($sub_link['url']) && ($template['active_page'] == $sub_link['url'])) ? ' class="active"' : '';
                                    $icon = (isset($sub_link['icon']) && $sub_link['icon']) ? '<i class="' . $sub_link['icon'] . '"></i>' : '';
                                ?>
                                    <li>
                                        <a href="<?php echo $url; ?>" <?php echo $active ?>><?php echo $icon . $sub_link['name']; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        </li>
                    <?php } ?>
            </ul>
        <?php } ?>
    </nav>
    <!-- END Primary Navigation -->
</aside>
<!-- END Sidebar -->