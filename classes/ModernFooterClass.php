<?php
/**
 * 2016 Smart Soft.
 *
 *  @author    Marcin Kubiak <zlecenie@poczta.onet.pl>
 *  @copyright Smart Soft
 *  @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

class ModernFooterClass extends ObjectModel
{
    /** @var integer modern footer id*/
    public $id;
    
    /** @var integer id shop*/
    public $id_shop;
    
    /** @var integer position*/
    public $position=null;

    /** @var string name*/
    public $name;

    /** @var string description*/
    public $description;

    /** @var string url*/
    public $url;
  
    /** @var integer id block*/
    public $id_block;
        
    public static $definition = array(
        'table' => 'modernfooter',
        'primary' => 'id_modernfooter',
        'multilang' => true,
        'fields' => array(
            // Lang fields
            'name' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isName'),
            'description' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
            'url' =>        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl')
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

        $fieldsArray = array('name', 'description', 'url');
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
        $fields['id_modernfooter'] = (int)($this->id);
        $fields['id_block'] = (int)($this->id_block);
        $fields['id_shop'] = (int)($this->id_shop);
    
        return $fields;
    }
    
    /*
    * Insert default data
    */
    public static function insertDefaultData($id_shop)
    {
        //delete data
        if (!Db::getInstance()->Execute('DELETE    m, ml
								      FROM     `'._DB_PREFIX_.'modernfooter`as m
									LEFT JOIN `'._DB_PREFIX_.'modernfooter_lang` as ml
									ON        ml.id_modernfooter = m.id_modernfooter
									WHERE     m.`id_shop` = '.(int)$id_shop)) {
            return false;
        }
        
        $languages = Language::getLanguages(false);
                                        
        for ($i=1; $i<=4; $i++) {
            for ($p=1; $p<=5; $p++) {
                $mf = new ModernFooterClass();
                $mf->id_shop = (int)$id_shop;
                $mf->id_block = $i;
                $mf->position = $p;
                foreach ($languages as $language) {
                    $mf->url[(int)($language['id_lang'])] = "http://prestashop.com";
                }
                foreach ($languages as $language) {
                    $mf->name[(int)($language['id_lang'])] = "Lorem ipsum dolar";
                }
                foreach ($languages as $language) {
                    $mf->description[(int)($language['id_lang'])] = "Lorem ipsum dolar";
                }
                $mf->save();
            }
        }
        
        return true;
    }
}
