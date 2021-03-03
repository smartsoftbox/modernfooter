<?php
/**
 * 2016 Smart Soft.
 *
 *  @author    Marcin Kubiak <zlecenie@poczta.onet.pl>
 *  @copyright Smart Soft
 *  @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

class ModernFooterInfoClass extends ObjectModel
{
    /** @var integer modern footer id*/
    public $id;
     
    /** @var integer modern footer id*/
    public $id_shop;
     
    /** @var string info1 */
    public $info1;
    
    /** @var string info2 */
    public $info2;
    
    /** @var string info3 */
    public $info3;
    
    /** @var string info4 */
    public $info4;

    /** @var string block1_name */
    public $block1_name;

    /** @var string block2_name */
    public $block2_name;

    /** @var string block3_name */
    public $block3_name;

    /** @var string block4_name */
    public $block4_name;

    /** @var string payment_block */
    public $payment_block;

    /** @var string about_block */
    public $about_block;

    /** @var string about */
    public $about;

    /** @var string company_name */
    public $company_name;

    /** @var string phone */
    public $phone;

    /** @var string email */
    public $email;
      
    /** @var string info */
    public $info;
  
    /** @var string subscribe */
    public $subscribe;

    /** @var string info1name */
    public $info1name;

    /** @var string info2name */
    public $info2name;

    /** @var string info3name */
    public $info3name;

    /** @var string info4name */
    public $info4name;
            
    public static $definition = array(
        'table' => 'modernfooter_info',
        'primary' => 'id_modernfooter_info',
        'multilang' => true,
        'fields' => array(
            // Lang fields
            'block1_name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isName'),
            'block2_name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isName'),
            'block3_name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isName'),
            'block4_name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isName'),
            'company_name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isName'),
            'info1' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'info2' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'info3' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'info4' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'subscribe' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'about_block' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isName'),
            'payment_block' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isName'),
            'phone' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'email' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isEmail'),
            'info' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'about' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'info1name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'info2name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'info3name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'info4name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
        )
    );
    
    /**
      * Check then return multilingual fields for database interaction
      *
      * @return array Multilingual fields
      */
    public function getTranslationsFieldsChild()
    {
        parent::validateFieldsLang();

        $fieldsArray = array(
            'block1_name',
            'block2_name',
            'block3_name',
            'block4_name',
            'info1',
            'info2',
            'info3',
            'info4',
            'about_block',
            'about',
            'payment_block',
            'company_name',
            'phone',
            'email',
            'info',
            'subscribe',
            'info1name',
            'info2name',
            'info3name',
            'info4name',
        );
                    
        $fields = array();
        $languages = Language::getLanguages(false);
        $defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
        foreach ($languages as $language) {
            $fields[$language['id_lang']]['id_lang'] = (int)($language['id_lang']);
            $fields[$language['id_lang']][$this->identifier] = (int)($this->id);
            foreach ($fieldsArray as $field) {
                if (!Validate::isTableOrIdentifier($field)) {
                    die(Tools::displayError());
                }
                if (isset($this->{$field}[$language['id_lang']]) and !empty($this->{$field}[$language['id_lang']])) {
                    $fields[$language['id_lang']][$field] = pSQL($this->{$field}[$language['id_lang']], true);
                } elseif (in_array($field, $this->fieldsRequiredLang)) {
                    $fields[$language['id_lang']][$field] = pSQL($this->{$field}[$defaultLanguage], true);
                } else {
                    $fields[$language['id_lang']][$field] = '';
                }
            }
        }
        return $fields;
    }

    public function copyFromPost()
    {
        /* Classical fields */
        foreach ($_POST as $key => $value) {
            if (key_exists($key, $this) and $key != 'id_'.$this->table) {
                $this->{$key} = $value;
            }
        }

        /* Multilingual fields */
        if (sizeof($this->fieldsValidateLang)) {
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                foreach (array_keys($this->fieldsValidateLang) as $field) {
                    if (Tools::getValue($field.'_'.(int)($language['id_lang']))) {
                        $this->{$field}[(int)($language['id_lang'])] =
                            Tools::getValue($field.'_'.(int)($language['id_lang']));
                    }
                }
            }
        }
    }
  
    public function getFields()
    {
        parent::validateFields();
        $fields = array();
        $fields['id_modernfooter_info'] = (int)($this->id);
        $fields['id_shop'] = (int)($this->id_shop);
  
        return $fields;
    }

      /*
      *getField returns field value from moderfooter_info table
      */
    public static function getField($fieldname, $id_shop = 0)
    {
        $field = Db::getInstance()->ExecuteS('
            SELECT '.$fieldname.', mfil.`id_lang`
            FROM `'._DB_PREFIX_.'modernfooter_info` mfi
            LEFT JOIN `'._DB_PREFIX_.'modernfooter_info_lang` mfil
            ON (mfi.`id_modernfooter_info` = mfil.`id_modernfooter_info`)
            WHERE mfi.`id_shop` = '.(int)$id_shop.' GROUP BY mfil.`id_lang` ASC');
           
        $output = array();
        foreach ($field as $value) {
            $output[ $value['id_lang'] ] = $value[$fieldname];
        }
                       
        return $output;
    }

       /*
    * Insert default data
    */
    public static function insertDefaultData($id_shop)
    {
        //delete data
        if (!Db::getInstance()->Execute('DELETE    mi, mil
								      FROM     `'._DB_PREFIX_.'modernfooter_info`as mi
									LEFT JOIN `'._DB_PREFIX_.'modernfooter_info_lang` as mil
									ON        mil.id_modernfooter_info = mi.id_modernfooter_info
									WHERE     mi.`id_shop` = '.(int)$id_shop)) {
            return false;
        }
        $languages = Language::getLanguages(false);
        $mf = new ModernFooterInfoClass();
        $mf->id_shop = $id_shop;
        foreach ($languages as $language) {
            $mf->info1name[(int)($language['id_lang'])] =
                "Satisfaction Guaranteed";
        }
        foreach ($languages as $language) {
            $mf->info2name[(int)($language['id_lang'])] =
                "Secure Payment";
        }
        foreach ($languages as $language) {
            $mf->info3name[(int)($language['id_lang'])] =
                "Delivery";
        }
        foreach ($languages as $language) {
            $mf->info4name[(int)($language['id_lang'])] =
                "Customer Service";
        }
        foreach ($languages as $language) {
            $mf->info1[(int)($language['id_lang'])] =
                "Lorem ipsum dolor sit amet, consectetur adipisicing elit, " .
                "sed do eiusmod tempor incididunt ut labore et dolore .";
        }
        foreach ($languages as $language) {
            $mf->info2[(int)($language['id_lang'])] =
                "Lorem ipsum dolor sit amet, consectetur adipisicing elit, " .
                "sed do eiusmod tempor incididunt ut labore et dolore .";
        }
        foreach ($languages as $language) {
            $mf->info3[(int)($language['id_lang'])] =
                "Lorem ipsum dolor sit amet, consectetur adipisicing elit, " .
                "sed do eiusmod tempor incididunt ut labore et dolore .";
        }
        foreach ($languages as $language) {
            $mf->info4[(int)($language['id_lang'])] =
                "Lorem ipsum dolor sit amet, consectetur adipisicing elit, " .
                "sed do eiusmod tempor incididunt ut labore et dolore .";
        }
        foreach ($languages as $language) {
            $mf->block1_name[(int)($language['id_lang'])] = "Information";
        }
        foreach ($languages as $language) {
            $mf->block2_name[(int)($language['id_lang'])] = "Categories";
        }
        foreach ($languages as $language) {
            $mf->block3_name[(int)($language['id_lang'])] = "New Products";
        }
        foreach ($languages as $language) {
            $mf->block4_name[(int)($language['id_lang'])] = "Partners";
        }
        foreach ($languages as $language) {
            $mf->payment_block[(int)($language['id_lang'])] = "Payments";
        }
        foreach ($languages as $language) {
            $mf->about[(int)($language['id_lang'])] =
                "Lorem ipsum dolor sit amet, consectetur adipisicing elit, " .
                "sed do eiusmod tempor incididunt ut labore et dolore magna ".
                "aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamc";
        }
        foreach ($languages as $language) {
            $mf->about_block[(int)($language['id_lang'])] = "About us";
        }
        foreach ($languages as $language) {
            $mf->company_name[(int)($language['id_lang'])] = "Company Name";
        }
        foreach ($languages as $language) {
            $mf->phone[(int)($language['id_lang'])] = "+44600123321";
        }
        foreach ($languages as $language) {
            $mf->email[(int)($language['id_lang'])] = "companyname@email.com";
        }
        foreach ($languages as $language) {
            $mf->info[(int)($language['id_lang'])] = "Copyrighy All right reserver 2011-2012";
        }
        foreach ($languages as $language) {
            $mf->subscribe[(int)($language['id_lang'])] = "subscribe to our newslette";
        }
        
        $mf->save();
        
        return true;
    }
}
