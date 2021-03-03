{**
* @author      DevSoft Presta-Modules.net
* @copyright       Copyright DevSoft 2010-2012. All rights reserved.
* @license     GPLv3 License http://www.gnu.org/licenses/gpl-3.0.html
* @version     1.0
*
*}

<script type="text/javascript">
    $( document ).ready(function() {
        $(".hideText").on("click",function(){
            $(this).parent().parent().find("p").slideToggle();
        });
        $(".hideList").on("click",function(){
            $(this).parent().parent().find("ul").slideToggle();
        });
    });
</script>
<style type="text/css">
    {literal}
    .block_newsletter {
      background: none !important;
    }
    .hideText, .hideList {
        display:none;
        margin-left: 5px;
    }
    .block_newsletter {
        margin-bottom: 0px !important;
    }
    #ds-footer, #footer {
        clear: both;
        padding-top: 0px;
        margin-top: 0px;
    }
    div.footer-container{
        margin-top: 0px;
    }
    .ds-shadow {
        padding:10px;
        background-color: #ffffff;
        margin-bottom: 10px;
    }
    #ds-info .col-lg-3:last-of-type .ds-shadow{
        margin-right: 0px;
        padding:10px;
    }
    .footer-container {
        padding-top: 0 !important;
    }
    .shadow1 {
        text-shadow: 0px 1px 1px #fff;
    }
    .shadow2 {
        text-shadow: 0px 1px 1px #000;
    }
    div.ds-info_image {
        font-weight: 700;
    }
    .ds-link_box {
        padding: 0px 0px 0px 0px;
    }
    .ds-link_border{
        padding-right:5px;
        margin-right: 10px;
    }
    #ds-footer .block-social li a {
        color: transparent;
    }
    .ds-link_border img{
        width: 8px;
        margin-top; -4px;
    }
    .ds-shadow
    {
        box-shadow:0 0 5px 3px rgba(0, 0, 0, 0.1);
    }
    #ds-footer .block_newsletter {
        border: none !important;
    }
    #ds-footer .block_newsletter form {
        margin-top:-7px;
        background: #D9D9D9;
        padding:7px;
        -webkit-border-radius: 7px;
        -moz-border-radius: 7px;
        border-radius: 7px;
    }
    #ds-footer .hidden-xs-down {
        -webkit-border-top-right-radius: 7px;
        -webkit-border-bottom-right-radius: 7px;
        -moz-border-radius-topright: 7px;
        -moz-border-radius-bottomright: 7px;
        border-top-right-radius: 7px;
        border-bottom-right-radius: 7px;
        background: #F19124;
    }
    #ds-footer .input-wrapper {
        -webkit-border-top-left-radius: 7px;
        -webkit-border-bottom-left-radius: 7px;
        -moz-border-radius-topleft: 7px;
        -moz-border-radius-bottomleft: 7px;
        border-top-left-radius: 7px;
        border-bottom-left-radius: 7px;
    }
    #ds-info {
        padding-top: 10px;
    }
    #ds-footer .block-social li{
        background-color: {/literal} {$MEGAMENU_BACKGROUND3|escape:'htmlall':'UTF-8'} {literal};
    }
    #ds-info div.ds-shadow{
        background: {/literal} {$MEGAMENU_BACKGROUND1|escape:'htmlall':'UTF-8'} {literal};
        padding-top: 10px;
        padding-left: 8px;
    }
    #ds-links {
        background: {/literal} {$MEGAMENU_BACKGROUND2|escape:'htmlall':'UTF-8'} {literal};
        padding-top: 20px;
        padding-bottom: 10px;
    }
    #ds-connect {
        background-color: {/literal} {$MEGAMENU_BACKGROUND3|escape:'htmlall':'UTF-8'} {literal};
        padding: 20px 0 15px 0px;
        box-shadow: 0 0 5px 3px rgba(0, 0, 0, 0.05);
    }
    #ds-contact {
        background: {/literal} {$MEGAMENU_BACKGROUND4|escape:'htmlall':'UTF-8'} {literal};;
        padding-top: 20px;
    }
    #ds-copyrights {
        background: {/literal} {$MEGAMENU_BACKGROUND5|escape:'htmlall':'UTF-8'} {literal};
        padding-top: 20px;
        text-align: center;
    }
    [id^=ds-f-info] {
        color: {/literal} {$MEGAMENU_TEXTCOLOR1|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    #ds-f-about_block {
        color: {/literal} {$MEGAMENU_TEXTCOLOR2|escape:'htmlall':'UTF-8'} !important;{literal};
        margin-top: 0px;
    }
    #ds-f-about {
        color: {/literal} {$MEGAMENU_TEXTCOLOR3|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    [id^=ds-f-block] {
        color: {/literal} {$MEGAMENU_TEXTCOLOR4|escape:'htmlall':'UTF-8'} !important;{literal};
        margin-top: 0px;
    }
    [id^=ds-f-link-] {
        color: {/literal} {$MEGAMENU_TEXTCOLOR5|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    #ds-footer .block_newsletter p {
        color: {/literal} {$MEGAMENU_TEXTCOLOR6|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    #ds-f-company_name {
        color: {/literal} {$MEGAMENU_TEXTCOLOR7|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    #ds-f-email {
        color: {/literal} {$MEGAMENU_TEXTCOLOR8|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    #ds-f-phone {
        color: {/literal} {$MEGAMENU_TEXTCOLOR9|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    #ds-f-payment_block {
        color: {/literal} {$MEGAMENU_TEXTCOLOR10|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    #ds-f-info {
        color: {/literal} {$MEGAMENU_TEXTCOLOR11|escape:'htmlall':'UTF-8'} !important;{literal};
    }
    #footer .row {
        margin-left: 0;
        margin-right: 0;
    }
    @media (max-width: 768px) {
        .hideText, .hideList {
            display:inline-block;
        }
        .ds-link_border ul {display:none;}
        #ds-about p {display:none;}
    }
    @media (min-width: 768px) {
        .ds-link_border ul {display:block !important;}
        #ds-about p {display:block !important;}
    }
    {/literal}
</style>
