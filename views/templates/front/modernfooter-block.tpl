{*
*  @author Marcin Kubiak <support@add-ons.eu>
*  @copyright  Smart Soft
*  @license    Commercial license
*  International Registered Trademark & Property of Smart Soft
*}

<div class="ds-link_box col-xs-12 col-sm-6 col-md-3">
    <div class="ds-link_border">
        <h3 id="ds-f-block{$id_block|escape:'htmlall':'UTF-8'}_name">
            {$name|escape:'htmlall':'UTF-8'}<span class="hideList">+</span>
        </h3>
        <ul>
            {foreach from=$links item=blocklink name=blocklink}
                {if $blocklink.id_block == $id_block}
                    <li>
                        <a  href="{$blocklink.url|escape:'htmlall':'UTF-8'}"  id="ds-f-link-{$blocklink.id_modernfooter|escape:'htmlall':'UTF-8'}" >
                            <img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/user/{$id_shop|escape:'htmlall':'UTF-8'}/link_image.png"/>
                            {$blocklink.name|escape:'htmlall':'UTF-8'}
                        </a>
                    </li>
                {/if}
            {/foreach}
        </ul>
    </div>
</div>
