<?php
/**
 * 2016 Smart Soft.
 *
 *  @author    Marcin Kubiak <zlecenie@poczta.onet.pl>
 *  @copyright Smart Soft
 *  @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

class Modernfooter extends Module
{
    /** @var max image size */
    protected $maxImageSize = 307200;
    private $errors;

    public function __construct()
    {
        $this->name = 'modernfooter';
        $this->tab = 'front_office_features';
        $this->version = '2.5.4';
        $this->author = 'DevSoft';
        $this->module_key = 'a1310080644c9671d5bc5b1d7e477041';
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Modern footer');
        $this->description = $this->l('Modern footer module.');
        $path = dirname(__FILE__);

        if (strpos(__FILE__, 'Module.php') !== false) {
            $path .= '/../modules/' . $this->name;
        }

        include_once($path . '/classes/ModernFooterClass.php');
        include_once($path . '/classes/ModernFooterInfoClass.php');

        if (!defined('_MYSQL_ENGINE_')) {
            define('_MYSQL_ENGINE_', 'MyISAM');
        }
    }

    public function install()
    {
        if (!Db::getInstance()->Execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'modernfooter` (
            `id_modernfooter` int(11) NOT NULL AUTO_INCREMENT,
            `id_shop` int(11) unsigned NOT NULL,
            `id_block` int(10) NOT NULL,
            `position` int(10) unsigned NOT NULL default 0,
            PRIMARY KEY (`id_modernfooter`, `id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')
        ) {
            return false;
        }

        if (!Db::getInstance()->Execute('
                    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'modernfooter_lang` (
                    `id_modernfooter` int(10) unsigned NOT NULL,
                    `id_lang` int(10) NOT NULL,
                    `name` varchar(255) NOT NULL,
                    `description` varchar(255) NOT NULL,
                    `url` varchar(255) NOT NULL,
                    PRIMARY KEY (`id_modernfooter`, `id_lang`))
                    ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')
        ) {
            return false;
        }

        if (!Db::getInstance()->Execute('
                    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'modernfooter_info` (
                    `id_modernfooter_info` int(11) NOT NULL AUTO_INCREMENT,
			        `id_shop` int(11) unsigned NOT NULL,
                    PRIMARY KEY (`id_modernfooter_info`, `id_shop`)
                  ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')
        ) {
            return false;
        }

        if (!Db::getInstance()->Execute('
                    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'modernfooter_info_lang` (
                    `id_modernfooter_info` int(10) unsigned NOT NULL,
                    `id_lang` int(10) NOT NULL,
					`info1` varchar(255) NOT NULL,
					`info2` varchar(255) NOT NULL,
					`info3` varchar(255) NOT NULL,
					`info4` varchar(255) NOT NULL,
                    `block1_name` varchar(255) NOT NULL,
                    `block2_name` varchar(255) NOT NULL,
					`block3_name` varchar(255) NOT NULL,
					`block4_name` varchar(255) NOT NULL,
                    `payment_block` varchar(255) NOT NULL,
			 		`about` text(255) NOT NULL,
			 		`subscribe` text(255) NOT NULL,
                    `about_block` varchar(255) NOT NULL,
                    `company_name` varchar(255) NOT NULL,
                    `phone` varchar(255) NOT NULL,
                    `email` varchar(255) NOT NULL,
                    `info` text NOT NULL,
					`info1name`   varchar(255) NOT NULL,
					`info2name`   varchar(255) NOT NULL,
					`info3name`   varchar(255) NOT NULL,
					`info4name`   varchar(255) NOT NULL,
                    PRIMARY KEY (`id_modernfooter_info`, `id_lang`))
                    ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')
        ) {
            return false;
        }

        //get default store if 1.5.x
        if (version_compare(_PS_VERSION_, '1.5.0.0') == +1) {
            $id_shops = Shop::getCompleteListOfShopsID();
        } else {
            $id_shops = array(0);
        }

        foreach ($id_shops as $id_shop) {
            ModernFooterClass::insertDefaultData($id_shop);
            ModernFooterInfoClass::insertDefaultData($id_shop);

            $src = dirname(__FILE__) . "/views/img/user/default";
            $des = dirname(__FILE__) . "/views/img/user/" . $id_shop;

            $this->deleteDirectory($des);
            $this->recurseCopy($src, $des);
        }

        if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
            $news = Module::getInstanceByName('ps_emailsubscription');
            $follow = Module::getInstanceByName('ps_socialfollow');
        } else {
            $news = Module::getInstanceByName('blocknewsletter');
            $follow = Module::getInstanceByName('blocksocial');
        }

        if (!parent::install() ||
            !$this->registerHook('footer') ||
            !$this->registerHook('displayModernFooter') ||
            !Hook::registerHook($news, 'displayModernFooter', null) ||
            !Hook::registerHook($follow, 'displayModernFooter', null) ||
            !$this->unregisterHook('displayModernFooter') ||
            !Configuration::updateValue('MEGAMENU_BACKGROUND1', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_BACKGROUND2', '#222222') ||
            !Configuration::updateValue('MEGAMENU_BACKGROUND3', '#000000') ||
            !Configuration::updateValue('MEGAMENU_BACKGROUND4', '#222222') ||
            !Configuration::updateValue('MEGAMENU_BACKGROUND5', '#FFFFFF') ||

            !Configuration::updateValue('MEGAMENU_TEXTCOLOR1', '#000000') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR2', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR3', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR4', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR5', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR6', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR7', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR8', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR9', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR10', '#FFFFFF') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR11', '#000000') ||
            !Configuration::updateValue('MEGAMENU_TEXTCOLOR12', '')
        ) {
            return false;
        }

        if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
            $this->registerHook('displayBeforeBodyClosingTag');
        } else {
            $this->registerHook('header');
        }

        //unhook footer modules
        $this->unhookModule(array(
            'ps_contactinfo',
            'ps_linklist',
            'ps_customeraccountlinks',
            'block_myaccount',
            'blockcategories',
            'blockmyaccountfooter',
            'blockcontactinfos',
            'blocknewsletter',
            'blockcms',
            'blocklayered',
            'blocksocial'
        ), 'displayFooter');

        //unhook footer modules
        $this->unhookModule(array(
            'ps_emailsubscription',
            'ps_socialfollow'
        ), 'displayFooterBefore');

        return true;
    }

    public function hookDisplayBeforeBodyClosingTag($params)
    {
        return $this->displayBeforeBodyClosingTag($params);
    }

    public function deleteDirectory($path)
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $this->deleteDirectory(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } elseif (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }

    public function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /*
    * Delete files from directory
    * return string
    */
    public function unhookModule($module_names, $hook_id)
    {
        foreach ($module_names as $module_name) {
            $module = Module::getInstanceByName($module_name);
            if (is_object($module)) {
                $module->unregisterHook($hook_id);
            }
        }
    }

    public function uninstall()
    {
        Db::getInstance()->Execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'modernfooter');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'modernfooter_lang');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'modernfooter_info');
        Db::getInstance()->Execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'modernfooter_info_lang');

        Configuration::deleteByName('MEGAMENU_BACKGROUND1');
        Configuration::deleteByName('MEGAMENU_BACKGROUND2');
        Configuration::deleteByName('MEGAMENU_BACKGROUND3');
        Configuration::deleteByName('MEGAMENU_BACKGROUND4');
        Configuration::deleteByName('MEGAMENU_BACKGROUND5');

        Configuration::deleteByName('MEGAMENU_TEXTCOLOR1');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR2');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR3');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR4');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR5');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR6');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR7');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR8');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR9');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR10');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR11');
        Configuration::deleteByName('MEGAMENU_TEXTCOLOR12');

        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }

    public function getContent()
    {
        if ((int)Tools::getValue('ajax')) {
            $this->hookAjaxCall();
            exit();
        }

        $this->_html = '';
        if ((int)Tools::getValue('loaddata') == 1) {
            $id_shop = (int)Context::getContext()->shop->id;
            $defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));

            $src = dirname(__FILE__) . "/views/img/user/default";
            $des = dirname(__FILE__) . "/views/img/user/" . $id_shop;

            $this->deleteDirectory($des);
            $this->recurseCopy($src, $des);

            ModernFooterClass::insertDefaultData($id_shop, $defaultLanguage);
            ModernFooterInfoClass::insertDefaultData($id_shop, $defaultLanguage);
            Tools::redirectAdmin(
                'index.php?controller=adminmodules&configure=' .
                $this->name . '&token=' . Tools::getValue('token')
            );
        }
        $this->_html .= $this->displayCheck();
        $this->_html .= $this->displayForm();
        return $this->_html;
    }

    /*
    * Add ajax upload for images
    * return string
    */

    public function displayForm()
    {
        $id_shop =  (int)Context::getContext()->shop->id;

        $output = ' <script type="text/javascript" ' .
            'src="../js/jquery/plugins/fancybox/jquery.fancybox.js"></script>';
        $output .= ' <script type="text/javascript" ' .
            'src="../js/jquery/plugins/jquery.colorpicker.js"></script>';
        $output .= '<link href="../js/jquery/plugins/fancybox/jquery.fancybox.css"'.
            ' type="text/css" rel="stylesheet"> ';
        $output .= '<link href="' .
            _MODULE_DIR_ . 'modernfooter/views/css/modernfooter-admin.css" '.
            'type="text/css" rel="stylesheet">';
        $output .= '<script type="text/javascript" src="'
            . _MODULE_DIR_ . 'modernfooter/views/js/modernfooter-admin.js"></script>';
        $output .= '<script type="text/javascript" src="'
            . _MODULE_DIR_ . 'modernfooter/views/js/ajaxupload.3.5.js"></script>';
        $output .= '<script type="text/javascript" src="'
            . _MODULE_DIR_ . 'modernfooter/views/js/jquery-scoped.js"></script>';
        $output .= '<script type="text/javascript">
				         var urlJson = "' . $this->context->link->getAdminLink('AdminModules', false).
                        '&ajax=1&configure='.$this->name.
                        '&token='.Tools::getAdminTokenLite('AdminModules').'";
					     var _MODULE_DIR_ = "' . _MODULE_DIR_ . '";
					     var current_shop = "' . $id_shop . '";
				     </script>
				     <div class="panel">
                        <div class="panel-heading">
							<i class="icon-envelope"></i>Modern Footer
							<span class="panel-heading-action">
							    <a id="getColors" href="" class="list-toolbar-btn">' .
                                    $this->l("Change colors") . '
                                </a>
                                <a id="ds-load-data"
                                    class="list-toolbar-btn"
                                    href="index.php?controller=adminmodules&configure=' . $this->name .
                                    '&token=' . Tools::getValue('token') . '&loaddata=1">' .
                                    $this->l("Default data") . '
                                </a>
                            </span>
                        </div>
                        <div id="styles" class="container">
                            <a href="#" rel="1" class="col-lg-3" >style 1</a>
                            <a href="#" rel="2" class="col-lg-3">style 2</a>
                            <a href="#" rel="3" class="col-lg-3">style 3</a>
                            <a href="#" rel="4" class="col-lg-3">style 4</a>
                        </div>
                        <div id="ds-load">' . $this->displayAdminFooter() . '</div>
                    </div>
                    <div id="ds-image" style="">
                        <div id="content" class="colorsForm bootstrap">'
                            . $this->displayImageForm() .
                        '</div>
                    </div>
                    <div id="ds-add-link-wrap">
                        <div id="content" class="colorsForm bootstrap">'
                            . $this->displayLinkForm(null, $id_shop) .
                        '</div>
                    </div>
                    <div id="ds-colors">
                        <div id="content" class="colorsForm bootstrap">'
                            . $this->displayColorsForm() .
                        '</div>
                    </div>';

        return $output;
    }

    private function displayCheck()
    {
        $blocknewsletter = '';
        $blocksocial = '';
        if (version_compare(_PS_VERSION_, '1.6.9.9')  == +1) {
            $blocknewsletter = AdminController::$currentIndex .
                '&configure=ps_emailsubscription' .
                '&token=' . Tools::getAdminTokenLite('AdminModules');
            $blocksocial = AdminController::$currentIndex.
                '&configure=ps_socialfollow'.
                '&token='.Tools::getAdminTokenLite('AdminModules');
        } else {
            $blocknewsletter = AdminController::$currentIndex .
                '&configure=blocknewsletter' .
                '&token=' . Tools::getAdminTokenLite('AdminModules');
            $blocksocial = AdminController::$currentIndex .
                '&configure=blocksocial' .
                '&token=' . Tools::getAdminTokenLite('AdminModules');
        }

        $this->smarty->assign(
            array(
                'blocknewsletter' => $blocknewsletter,
                'blocksocial' => $blocksocial
            )
        );

        return $this->display(__FILE__, 'infos.tpl');
    }

    public function displayAdminFooter()
    {
        $this->getConfigurationValues();

        $this->smarty->assign(array(
            'admin' => 1,
            'header' => $this->display(__FILE__, 'views/templates/front/modernfooter-header.tpl'),
            'this_path' => $this->_path,
            'id_shop' => (int)Context::getContext()->shop->id,
            'links' => $this->getLinks(),
            'payments' => $this->getPayment(),
            'info' =>$this->getInfo(),
            'url' => __PS_BASE_URI__,
            'modernfooter_block' => _PS_MODULE_DIR_.'modernfooter/views/templates/front/modernfooter-block.tpl'
        ));

        $admin = $this->display(__FILE__, 'views/templates/front/modernfooter.tpl');
        $this->smarty->assign('html', $admin);
        return $this->display(__FILE__, ('views/templates/admin/modernfooter-admin.tpl'));
    }

    public function getPayment()
    {
        $id_shop = (int)Context::getContext()->shop->id;

        $dirname = _PS_ROOT_DIR_ . '/modules/modernfooter/views/img/user/' . $id_shop . '/payment';
        $images = scandir($dirname);
        $ignore = array(".", "..", "index.php");
        $img = array();

        foreach ($images as $key => $curimg) {
            $check = in_array($curimg, $ignore);
            if ($check == false) {
                $img[$key]['disable'] = (strpos($curimg, 'disable-') !== false ? true : false);
                $img[$key]['src'] = $curimg;
            }
        }

        return $img;
    }

    public function displayImageForm()
    {
        $output = '
	      <script type="text/javascript" src="' . _MODULE_DIR_ . 'modernfooter/views/js/ajaxupload.3.5.js"></script>

		<center style="display:none;"><div id="upload" ><span>Upload File<span></div><span id="status" ></span></center> ';

        return $output;
    }

    public function displayLinkForm($id_link = null)
    {
        if ($id_link != null) {
            $link = new ModernFooterClass($id_link);
            $id_form = "formtextarea";
        } else {
            $id_form = "newlink";
        }

        $this->fields_form = array(
            'form' => array(
                'id_form' => $id_form,
                'legend' => array(
                    'title' => $this->l('Change colors'),
                    'icon' => 'icon-link'
                ),
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'id_link',
                        'id' => 'id_link'
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'id_block',
                        'id' => 'id_block'
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'name',
                        'id' => 'name',
                        'label' => $this->l('Name'),
                        'lang' => true,
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'description',
                        'id' => 'description',
                        'label' => $this->l('Description'),
                        'lang' => true,
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'url',
                        'id' => 'url',
                        'label' => $this->l('Href'),
                        'lang' => true,
                        'required' => true
                    )
                ),
                'submit' => array(
                    'name' => 'submit',
                    'id' => ($id_link != null ? "submitlink" : "submitnewlink"),
                    'title' => $this->l('Submit')
                )
            )
        );

        $fields = array();
        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $fields['name'][$language['id_lang']] =
                (isset($link->name[$language['id_lang']]) ?
                    $link->name[$language['id_lang']] : '');
            $fields['description'][$language['id_lang']] =
                (isset($link->description[$language['id_lang']]) ?
                    $link->description[$language['id_lang']] : '');
            $fields['url'][$language['id_lang']] =
                (isset($link->url[$language['id_lang']]) ?
                    $link->url[$language['id_lang']] : '');
        }
        $fields['id_link'] = $id_link;
        $fields['id_block'] = (isset($link->id_block) ? $link->id_block : "");

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit';
        $helper->currentIndex =
            $this->context->link->getAdminLink('AdminModules', false).
            '&configure='.$this->name.'&tab_module='.$this->tab.
            '&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'uri' => $this->getPathUri(),
            'fields_value' => $fields,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array('form' => $this->fields_form));
    }

    public function clearCache()
    {
        $this->_clearCache('modernfooter.tpl');
        $this->_clearCache('modernfooter-header.tpl');
        $this->_clearCache('modernfooter-block.tpl');
    }

    public function hookFooter($params)
    {
        $this->smarty->assign(array(
            'admin' => 0,
            'this_path' => $this->_path,
            'id_shop' => (int)Context::getContext()->shop->id,
            'links' => $this->getLinks(),
            'payments' => $this->getPayment(),
            'info' => $this->getInfo(),
            'url' => __PS_BASE_URI__,
            'modernfooter_block' => _PS_MODULE_DIR_ . 'modernfooter/views/templates/front/modernfooter-block.tpl'
        ));

        return $this->display(__FILE__, 'views/templates/front/modernfooter.tpl');
    }

    public function hookHeader($params)
    {
        if (!$this->isCached('modernfooter-header.tpl', $this->getCacheId())) {
            $this->getConfigurationValues();
        }

        return $this->display(__FILE__, 'views/templates/front/modernfooter-header.tpl');
    }

    public function displayBeforeBodyClosingTag()
    {
        if (!$this->isCached('modernfooter-header.tpl', $this->getCacheId())) {
            $this->getConfigurationValues();
        }

        return $this->display(__FILE__, 'views/templates/front/modernfooter-header.tpl');
    }

    public function hookAjaxCall()
    {
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");

        $action = Tools::getValue('action');
        $id_shop = (int)Context::getContext()->shop->id;
        $fieldname = Tools::getValue('fieldname');
        $id_link = Tools::getValue('id_link');

        switch ($action) {
            case "upload":
                if ($_REQUEST['type'] == "payment") {
                    $uploaddir = '/views/img/user/' . $id_shop . "/payment/";
                } else {
                    $uploaddir = '/views/img/user/' . $id_shop . "/";
                }
                $path = dirname(__FILE__);
                $file = $path . $uploaddir . $_REQUEST['file_name'];

                if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
                } else {
                    echo "error";
                }
                break;
            case "gettextarea":
                echo '<div id="content" class="bootstrap">'
                            . $this->displayTextareaForm($fieldname, $id_shop) .
                        '</div>';
                break;
            case "getinput":
                echo '<div id="content" class="bootstrap">'
                    . $this->displayInputForm($fieldname, $id_shop) .
                    '</div>';
                break;
            case "getlink":
                echo '<div id="content" class="bootstrap">'
                        . $this->displayLinkForm($id_link, $id_shop) .
                    '</div>';
                break;
            case "savecolors":
                Configuration::updateValue('MEGAMENU_BACKGROUND1', Tools::getValue('MEGAMENU_BACKGROUND1'));
                Configuration::updateValue('MEGAMENU_BACKGROUND2', Tools::getValue('MEGAMENU_BACKGROUND2'));
                Configuration::updateValue('MEGAMENU_BACKGROUND3', Tools::getValue('MEGAMENU_BACKGROUND3'));
                Configuration::updateValue('MEGAMENU_BACKGROUND4', Tools::getValue('MEGAMENU_BACKGROUND4'));
                Configuration::updateValue('MEGAMENU_BACKGROUND5', Tools::getValue('MEGAMENU_BACKGROUND5'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR1', Tools::getValue('MEGAMENU_TEXTCOLOR1'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR2', Tools::getValue('MEGAMENU_TEXTCOLOR2'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR3', Tools::getValue('MEGAMENU_TEXTCOLOR3'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR4', Tools::getValue('MEGAMENU_TEXTCOLOR4'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR5', Tools::getValue('MEGAMENU_TEXTCOLOR5'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR6', Tools::getValue('MEGAMENU_TEXTCOLOR6'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR7', Tools::getValue('MEGAMENU_TEXTCOLOR7'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR8', Tools::getValue('MEGAMENU_TEXTCOLOR8'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR9', Tools::getValue('MEGAMENU_TEXTCOLOR9'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR10', Tools::getValue('MEGAMENU_TEXTCOLOR10'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR11', Tools::getValue('MEGAMENU_TEXTCOLOR11'));
                Configuration::updateValue('MEGAMENU_TEXTCOLOR12', Tools::getValue('MEGAMENU_TEXTCOLOR12'));

                echo '<div id="ds-load" style="text-align: left">' . $this->displayAdminFooter() . '</div>';
                break;
            case "savelink":
                if ($id_link) {
                    $MF = new ModernFooterClass($id_link);
                } else {
                    $MF = new ModernFooterClass();
                    $MF->id_shop = (int)Context::getContext()->shop->id;
                }
                $MF->copyFromPost();
                ($id_link ? $MF->save() : $MF->add());
                echo '<div id="ds-load" style="text-align: left">' . $this->displayAdminFooter() . '</div>';
                break;
            case "deletelink":
                $MF = new ModernFooterClass($id_link);
                $MF->delete();
                echo '<div id="ds-load" style="text-align: left">' . $this->displayAdminFooter() . '</div>';
                break;
            case "changestyle":
                $functionName = 'style' . (string)Tools::getValue('id');
                $this->$functionName();
                echo '<div id="ds-load" style="text-align: left">' . $this->displayAdminFooter() . '</div>';
                break;
            case "savefield":
                $id = Db::getInstance()->ExecuteS(
                    'SELECT mfi.`id_modernfooter_info`
                    FROM `' . _DB_PREFIX_ . 'modernfooter_info` mfi
                    WHERE mfi.`id_shop` = ' . (int)$id_shop
                );
                $MF = new ModernFooterInfoClass($id[0]['id_modernfooter_info']);
                $MF->copyFromPost();
                $MF->save();
                echo '<div id="ds-load" style="text-align: left">' . $this->displayAdminFooter() . '</div>';
                break;
            case "enableicon":
                $filename = Tools::getValue('filename');
                if (strpos($filename, 'disable-') !== false) {
                    $filename2 = str_replace('disable-', '', $filename);
                    rename(
                        dirname(__FILE__) . "/views/img/user/" . $id_shop . "/payment/" . $filename,
                        dirname(__FILE__) . "/views/img/user/" . $id_shop . "/payment/" . $filename2
                    );
                } else {
                    rename(
                        dirname(__FILE__) . "/views/img/user/" . $id_shop . "/payment/" . $filename,
                        dirname(__FILE__) . "/views/img/user/" . $id_shop . "/payment/disable-" . $filename
                    );
                    echo(Tools::jsonEncode('disable'));
                }

                break;
        }

        $this->clearCache();
    }

    public function displayTextareaForm($fieldname, $id_shop)
    {
        $field = ModernFooterInfoClass::getField($fieldname, $id_shop);

        $fields_form = array(
            'form' => array(
                'id_form' => 'formtextarea',
                'legend' => array(
                    'title' => $this->l('Change colors'),
                    'icon' => 'icon-link'
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Text'),
                        'lang' => true,
                        'name' => $fieldname,
                        'cols' => 40,
                        'rows' => 10
                    )
                ),
                'submit' => array(
                    'name' => 'submitColors',
                    'id' => 'submitfield',
                    'title' => $this->l('Submit')
                )
            )
        );

        $fields = array();
        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $fields[$fieldname][$language['id_lang']] =
                (isset($field[$language['id_lang']]) ?
                    $field[$language['id_lang']] : '');
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitStoreConf';
        $helper->currentIndex =
            $this->context->link->getAdminLink('AdminModules', false).
            '&configure='.$this->name.'&tab_module='.$this->tab.
            '&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'uri' => $this->getPathUri(),
            'fields_value' => $fields,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array('form' => $fields_form));
    }

    public function displayInputForm($fieldname, $id_shop)
    {
        $field = ModernFooterInfoClass::getField($fieldname, $id_shop);

        $this->fields_form = array(
            'form' => array(
                'id_form' => 'formtextarea',
                'legend' => array(
                    'title' => $this->l('Change colors'),
                    'icon' => 'icon-link'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Text'),
                        'lang' => true,
                        'name' => $fieldname,
                        'required' => true
                    )
                ),
                'submit' => array(
                    'name' => 'submitColors',
                    'id' => 'submitfield',
                    'title' => $this->l('Submit')
                )
            )
        );

        $fields = array();
        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $fields[$fieldname][$language['id_lang']] =
                (isset($field[$language['id_lang']]) ?
                    $field[$language['id_lang']] : '');
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitStoreConf';
        $helper->currentIndex =
            $this->context->link->getAdminLink('AdminModules', false).
            '&configure='.$this->name.'&tab_module='.$this->tab.
            '&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'uri' => $this->getPathUri(),
            'fields_value' => $fields,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array('form' => $this->fields_form));
    }

    public function displayColorsForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Change colors'),
                    'icon' => 'icon-link'
                ),
                'input' => array(
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background block 1'),
                        'name' => 'MEGAMENU_BACKGROUND1'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background block 2'),
                        'name' => 'MEGAMENU_BACKGROUND2'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background block 3'),
                        'name' => 'MEGAMENU_BACKGROUND3'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background block 4'),
                        'name' => 'MEGAMENU_BACKGROUND4'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background block 5'),
                        'name' => 'MEGAMENU_BACKGROUND5'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color description'),
                        'name' => 'MEGAMENU_TEXTCOLOR1'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color about label'),
                        'name' => 'MEGAMENU_TEXTCOLOR2'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color about text'),
                        'name' => 'MEGAMENU_TEXTCOLOR3'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color links label'),
                        'name' => 'MEGAMENU_TEXTCOLOR4'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color links'),
                        'name' => 'MEGAMENU_TEXTCOLOR5'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color newsletter'),
                        'name' => 'MEGAMENU_TEXTCOLOR6'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color company name'),
                        'name' => 'MEGAMENU_TEXTCOLOR7'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color email'),
                        'name' => 'MEGAMENU_TEXTCOLOR8'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color phone'),
                        'name' => 'MEGAMENU_TEXTCOLOR9'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color payment label'),
                        'name' => 'MEGAMENU_TEXTCOLOR10'
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color copyright'),
                        'name' => 'MEGAMENU_TEXTCOLOR11'
                    )
                ),
                'submit' => array(
                    'name' => 'submitColors',
                    'id' => 'submitColors',
                    'title' => $this->l('Submit')
                )
            )
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitStoreConf';
        $helper->currentIndex =
            $this->context->link->getAdminLink('AdminModules', false).
            '&configure='.$this->name.'&tab_module='.$this->tab.
            '&module_name='.$this->name;
        //$helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'uri' => $this->getPathUri(),
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        $fields = array();
        $fields['MEGAMENU_BACKGROUND1'] = Configuration::get('MEGAMENU_BACKGROUND1');
        $fields['MEGAMENU_BACKGROUND2'] = Configuration::get('MEGAMENU_BACKGROUND2');
        $fields['MEGAMENU_BACKGROUND3'] = Configuration::get('MEGAMENU_BACKGROUND3');
        $fields['MEGAMENU_BACKGROUND4'] = Configuration::get('MEGAMENU_BACKGROUND4');
        $fields['MEGAMENU_BACKGROUND5'] = Configuration::get('MEGAMENU_BACKGROUND5');

        $fields['MEGAMENU_TEXTCOLOR1'] = Configuration::get('MEGAMENU_TEXTCOLOR1');
        $fields['MEGAMENU_TEXTCOLOR2'] = Configuration::get('MEGAMENU_TEXTCOLOR2');
        $fields['MEGAMENU_TEXTCOLOR3'] = Configuration::get('MEGAMENU_TEXTCOLOR3');
        $fields['MEGAMENU_TEXTCOLOR4'] = Configuration::get('MEGAMENU_TEXTCOLOR4');
        $fields['MEGAMENU_TEXTCOLOR5'] = Configuration::get('MEGAMENU_TEXTCOLOR5');
        $fields['MEGAMENU_TEXTCOLOR6'] = Configuration::get('MEGAMENU_TEXTCOLOR6');
        $fields['MEGAMENU_TEXTCOLOR7'] = Configuration::get('MEGAMENU_TEXTCOLOR7');
        $fields['MEGAMENU_TEXTCOLOR8'] = Configuration::get('MEGAMENU_TEXTCOLOR8');
        $fields['MEGAMENU_TEXTCOLOR9'] = Configuration::get('MEGAMENU_TEXTCOLOR9');
        $fields['MEGAMENU_TEXTCOLOR10'] = Configuration::get('MEGAMENU_TEXTCOLOR10');
        $fields['MEGAMENU_TEXTCOLOR11'] = Configuration::get('MEGAMENU_TEXTCOLOR11');
        $fields['MEGAMENU_TEXTCOLOR12'] = Configuration::get('MEGAMENU_TEXTCOLOR12');

        return $fields;
    }

    private function getConfigurationValues()
    {
        $this->smarty->assign(array(
            'MEGAMENU_BACKGROUND1' => Configuration::get('MEGAMENU_BACKGROUND1'),
            'MEGAMENU_BACKGROUND2' => Configuration::get('MEGAMENU_BACKGROUND2'),
            'MEGAMENU_BACKGROUND3' => Configuration::get('MEGAMENU_BACKGROUND3'),
            'MEGAMENU_BACKGROUND4' => Configuration::get('MEGAMENU_BACKGROUND4'),
            'MEGAMENU_BACKGROUND5' => Configuration::get('MEGAMENU_BACKGROUND5'),

            'MEGAMENU_TEXTCOLOR1' => Configuration::get('MEGAMENU_TEXTCOLOR1'),
            'MEGAMENU_TEXTCOLOR2' => Configuration::get('MEGAMENU_TEXTCOLOR2'),
            'MEGAMENU_TEXTCOLOR3' => Configuration::get('MEGAMENU_TEXTCOLOR3'),
            'MEGAMENU_TEXTCOLOR4' => Configuration::get('MEGAMENU_TEXTCOLOR4'),
            'MEGAMENU_TEXTCOLOR5' => Configuration::get('MEGAMENU_TEXTCOLOR5'),
            'MEGAMENU_TEXTCOLOR6' => Configuration::get('MEGAMENU_TEXTCOLOR6'),
            'MEGAMENU_TEXTCOLOR7' => Configuration::get('MEGAMENU_TEXTCOLOR7'),
            'MEGAMENU_TEXTCOLOR8' => Configuration::get('MEGAMENU_TEXTCOLOR8'),
            'MEGAMENU_TEXTCOLOR9' => Configuration::get('MEGAMENU_TEXTCOLOR9'),
            'MEGAMENU_TEXTCOLOR10' => Configuration::get('MEGAMENU_TEXTCOLOR10'),
            'MEGAMENU_TEXTCOLOR11' => Configuration::get('MEGAMENU_TEXTCOLOR11'),
            'MEGAMENU_TEXTCOLOR12' => Configuration::get('MEGAMENU_TEXTCOLOR12')
        ));
    }

    /**
     * @return array|false|mysqli_result|null|PDOStatement|resource
     * @throws PrestaShopDatabaseException
     */
    public function getLinks()
    {
        $links = Db::getInstance()->ExecuteS(
            'SELECT * FROM `' . _DB_PREFIX_ . 'modernfooter` as mf
            LEFT JOIN `' . _DB_PREFIX_ . 'modernfooter_lang` as mfl
              ON mf.id_modernfooter = mfl.id_modernfooter
              WHERE mfl.id_lang = ' . (int)Context::getContext()->cookie->id_lang . '
              AND mf.`id_shop` = ' . (int)Context::getContext()->shop->id . '
              ORDER BY mf.id_block, mf.position'
        );
        return $links;
    }

    /**
     * @return null
     * @throws PrestaShopDatabaseException
     */
    public function getInfo()
    {
        $info = Db::getInstance()->ExecuteS(
            'SELECT * FROM `' . _DB_PREFIX_ . 'modernfooter_info` as mfi
            LEFT JOIN `' . _DB_PREFIX_ . 'modernfooter_info_lang` as mfil
            ON mfi.id_modernfooter_info = mfil.id_modernfooter_info
            WHERE mfil.id_lang = ' . (int)Context::getContext()->cookie->id_lang . '
            AND mfi.`id_shop` = ' . (int)Context::getContext()->shop->id
        );

        if ($info) {
            return $info[0];
        } else {
            return null;
        }
    }

    public function style1()
    {
        Configuration::updateValue('MEGAMENU_BACKGROUND1', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_BACKGROUND2', '#222222');
        Configuration::updateValue('MEGAMENU_BACKGROUND3', '#000000');
        Configuration::updateValue('MEGAMENU_BACKGROUND4', '#222222');
        Configuration::updateValue('MEGAMENU_BACKGROUND5', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR1', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR2', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR3', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR4', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR5', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR6', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR7', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR8', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR9', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR10', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR11', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR12', '');
    }

    public function style2()
    {
        Configuration::updateValue('MEGAMENU_BACKGROUND1', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_BACKGROUND2', '#E1E5E3');
        Configuration::updateValue('MEGAMENU_BACKGROUND3', '#2FB5D2');
        Configuration::updateValue('MEGAMENU_BACKGROUND4', '#000000');
        Configuration::updateValue('MEGAMENU_BACKGROUND5', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR1', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR2', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR3', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR4', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR5', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR6', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR7', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR8', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR9', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR10', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR11', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR12', '');
    }

    public function style3()
    {
        Configuration::updateValue('MEGAMENU_BACKGROUND1', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_BACKGROUND2', '#7D7F7E');
        Configuration::updateValue('MEGAMENU_BACKGROUND3', '#F39200');
        Configuration::updateValue('MEGAMENU_BACKGROUND4', '#000000');
        Configuration::updateValue('MEGAMENU_BACKGROUND5', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR1', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR2', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR3', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR4', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR5', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR6', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR7', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR8', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR9', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR10', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR11', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR12', '');
    }

    public function style4()
    {
        Configuration::updateValue('MEGAMENU_BACKGROUND1', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_BACKGROUND2', '#626463');
        Configuration::updateValue('MEGAMENU_BACKGROUND3', '#000000');
        Configuration::updateValue('MEGAMENU_BACKGROUND4', '#222222');
        Configuration::updateValue('MEGAMENU_BACKGROUND5', '#626463');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR1', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR2', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR3', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR4', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR5', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR6', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR7', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR8', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR9', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR10', '#FFFFFF');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR11', '#000000');
        Configuration::updateValue('MEGAMENU_TEXTCOLOR12', '');
    }
}
