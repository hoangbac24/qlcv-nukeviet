<?php

/**
 * @Project Module Nukeviet 4.x
 * @Author Generated
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 03/02/2026
 */

function nv_theme_qlcv_main()
{
    global $module_file, $lang_module, $lang_global, $module_info;

    $template = (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file . '/main.tpl')) ? $module_info['template'] : 'default';

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    $xtpl->parse('main');
    return $xtpl->text('main');
}
