{*
*  @author Marcin Kubiak <support@add-ons.eu>
*  @copyright  Smart Soft
*  @license    Commercial license
*  International Registered Trademark & Property of Smart Soft
*}

<div id="ds-footer">
	<div class="">
		<div id="ds-info" class="row ds-back-1">
			<div class="col-xs-12 col-sm-6 col-md-3" style="padding: 0px 5px;">
				<div class="ds-shadow">
					<div class="ds-info_image">
						<img id="ds-f-info_image_1" src="{$this_path|escape:'htmlall':'UTF-8'}views/img/user/{$id_shop|escape:'htmlall':'UTF-8'}/info_image_1.png">
						<span id="ds-f-info1name">{$info.info1name|escape:'htmlall':'UTF-8'}</span>
					</div>
					<p id="ds-f-info1">
						{$info.info1|escape:'htmlall':'UTF-8'}
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3" style="padding: 0px 5px;">
				<div class="ds-shadow">
					<div id="ds-f-info_image_2" class="ds-info_image">
						<img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/user/{$id_shop|escape:'htmlall':'UTF-8'}/info_image_2.png">
						<span id="ds-f-info2name">{$info.info2name|escape:'htmlall':'UTF-8'}</span>
					</div>
					<p id="ds-f-info2">
					  {$info.info2|escape:'htmlall':'UTF-8'}
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3" style="padding: 0px 5px;">
				<div class="ds-shadow">
					<div id="ds-f-info_image_3" class="ds-info_image">
						<img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/user/{$id_shop|escape:'htmlall':'UTF-8'}/info_image_3.png">
						<span id="ds-f-info3name">{$info.info3name|escape:'htmlall':'UTF-8'}</span>
					</div>
					<p id="ds-f-info3">
						{$info.info3|escape:'htmlall':'UTF-8'}
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3" style="padding: 0px 5px;">
				<div class="ds-shadow">
					<div  id="ds-f-info_image_4" class="ds-info_image">
						<img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/user/{$id_shop|escape:'htmlall':'UTF-8'}/info_image_4.png">
						<span id="ds-f-info4name">{$info.info4name|escape:'htmlall':'UTF-8'}</span>
					</div>
					<p id="ds-f-info4">
						{$info.info4|escape:'htmlall':'UTF-8'}
					</p>
				</div>
			</div>
		</div>
		<div class="row ds-back-2" id="ds-links">
			<div id="ds-links_left" class="col-lg-3 col-md-12 col-sm-12">
				<div id="ds-about">
					<h3 id="ds-f-about_block">
						{$info.about_block|escape:'htmlall':'UTF-8'}<span class="hideText">+</span>
					</h3>
					<p id="ds-f-about">
						{$info.about|escape:'htmlall':'UTF-8'}
					</p>
				</div>
			</div>
			<div id="ds-links_right" class="col-xs-12 col-md-9">
                {include file="$modernfooter_block" links=$links info=$info id_block=1 name=$info.block1_name}
                {include file="$modernfooter_block" links=$links info=$info id_block=2 name=$info.block2_name}
                {include file="$modernfooter_block" links=$links info=$info id_block=3 name=$info.block3_name}
                {include file="$modernfooter_block" links=$links info=$info id_block=4 name=$info.block4_name}
            </div>
		</div>
		<div class="row ds-back-3" id="ds-connect">
			{if $admin == 1}
				<div class="block_newsletter col-lg-8 col-md-12 col-sm-12">
					<div class="row">
						<p class="col-md-5 col-xs-12">Get our latest news and special sales</p>
						<div class="col-md-7 col-xs-12">
							<form>
								<div class="row">
									<div class="col-xs-12">
										<img src="../modules/modernfooter/views/img/newsletter.png" width="100%" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="block-social col-lg-4 col-md-12 col-sm-12">
					<img src="../modules/modernfooter/views/img/social.png" width="100% " />
				</div>
			{else}
				{hook h='displayModernFooter'}
			{/if}
		</div>
		<div class="row ds-back-4" id="ds-contact">
			<div id="ds-adress_box" class="col-lg-4 col-md-12 col-sm-12">
				<p id="ds-f-company_name">
					<img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/adres.png"/>
					{$info.company_name|escape:'htmlall':'UTF-8'}
				</p>
				<p id="ds-f-email">
					<img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/e-mail.png"/>
					{$info.email|escape:'htmlall':'UTF-8'}
				</p>
				<p id="ds-f-phone">
					<img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/telefon.png"/>
					{$info.phone|escape:'htmlall':'UTF-8'}
				</p>
			</div>
			<div id="ds-payment" class="col-lg-8 col-md-12 col-sm-12">
				<h3 id="ds-f-payment_block">{$info.payment_block|escape:'htmlall':'UTF-8'}</h3>
				{foreach from=$payments item=payment name=payment}
					{if $admin == 1}
						<div  class="col-md-2 col-xs-6 col-sm-4">
							<img {if $payment.disable == true}class="lessopacity"{/if}
								 src="{$this_path|escape:'htmlall':'UTF-8'}views/img/user/{$id_shop|escape:'htmlall':'UTF-8'}/payment/{$payment.src|escape:'htmlall':'UTF-8'}"/>
						</div>
					{else}
						{if $payment.disable == false}
						<div  class="col-md-2 col-xs-6 col-sm-4">
							<img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/user/{$id_shop|escape:'htmlall':'UTF-8'}/payment/{$payment.src|escape:'htmlall':'UTF-8'}"/>
						</div>
						{/if}
					{/if}
				{/foreach}
			</div>
		</div>
		<div class="row ds-back-5" id="ds-copyrights">
			<p  id="ds-f-info">
				{$info.info|escape:'htmlall':'UTF-8'}
			</p>
		</div>
	</div>
</div>
