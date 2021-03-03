<?php
/**
 * 2016 Smart Soft
 *
 *  @author    Marcin Kubiak <zlecenie@poczta.onet.pl>
 *  @copyright Smart Soft
 *  @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_2_5_0($module)
{
    $module_path = $module->getLocalPath();
    $tmp_folder_path = $module_path.'tmp';
    $css_folder_path = $module_path.'css';
    $js_folder_path = $module_path.'js';

    $images_folder_path = $module->getLocalPath().'css'.DIRECTORY_SEPARATOR.'images';
    $img_folder_path = $module->getLocalPath().'views'.DIRECTORY_SEPARATOR.'img';

    $module->recurseCopy($images_folder_path, $img_folder_path);
    $module->deleteDirectory($tmp_folder_path);
    $module->deleteDirectory($css_folder_path);
    $module->deleteDirectory($js_folder_path);
    Tools::clearCache(Context::getContext()->smarty, $module->getTemplatePath('modernfooter.tpl'));
    Tools::clearCache(Context::getContext()->smarty, $module->getTemplatePath('modernfooter-admin.tpl'));

    //database
    if (!Db::getInstance()->Execute(
        "ALTER TABLE `" . _DB_PREFIX_ . "modernfooter_info_lang` ADD `info1name` VARCHAR( 255 ) NOT NULL"
    )) {
        return false;
    }
    if (!Db::getInstance()->Execute(
        "ALTER TABLE `" . _DB_PREFIX_ . "modernfooter_info_lang` ADD `info2name` VARCHAR( 255 ) NOT NULL"
    )) {
        return false;
    }
    if (!Db::getInstance()->Execute(
        "ALTER TABLE `" . _DB_PREFIX_ . "modernfooter_info_lang` ADD `info3name` VARCHAR( 255 ) NOT NULL"
    )) {
        return false;
    }
    if (!Db::getInstance()->Execute(
        "ALTER TABLE `" . _DB_PREFIX_ . "modernfooter_info_lang` ADD `info4name` VARCHAR( 255 ) NOT NULL"
    )) {
        return false;
    }

    $languages = Language::getLanguages(false);
    $mf = new ModernFooterInfoClass(1);

    foreach ($languages as $language) {
        $mf->info1name[(int)($language['id_lang'])] =
            "Satisfaction Guaranteed";
        $mf->info2name[(int)($language['id_lang'])] =
            "Secure Payment";
        $mf->info3name[(int)($language['id_lang'])] =
            "Delivery";
        $mf->info4name[(int)($language['id_lang'])] =
            "Customer Service";
    }

    $mf->save();

    return true;
}
