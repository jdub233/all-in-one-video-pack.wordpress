<?php KalturaHelpers::protectView( $this ); ?>
<!--
<div id="filter-media-owner-type-wrap">
	<label for="filter-media-owner-type"><b>Filter Media</b></label>
	<select id="filter-media-owner-type" name="ownertype">
		<?php if ( KalturaHelpers::getOption( 'kaltura_show_media_from' ) === 'all_account' ): ?>
			<option value="all-media" <?php selected( $this->filterOwnerType, 'all-media' ); ?>>All Media</option>
		<?php endif; ?>
		<option value="my-media" <?php selected( $this->filterOwnerType, 'my-media' ); ?>>My Media</option>
		<option value="media-publish" <?php selected( $this->filterOwnerType, 'media-publish' ); ?>>Media I Can Publish</option>
		<option value="media-edit" <?php selected( $this->filterOwnerType, 'media-edit' ); ?>>Media I Can Edit</option>
	</select>
</div>
-->

<div id="filter-media-owner-type-wrap" class="pull-left">
	<div class="dropdown">
		<button class="btn btn-default dropdown-toggle" type="button" id="filter-media-owner-type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			Filter Media By
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" aria-labelledby="filter-media-owner-type">
			<?php if ( KalturaHelpers::getOption( 'kaltura_show_media_from' ) === 'all_account' ): ?>
				<li data-value="all-media"><a href="#">All Media</a></li>
			<?php endif; ?>
			<li><a href="#">My Media</a></li>
			<li><a href="#">Media I Can Publish</a></li>
			<li><a href="#">Media I can Edit</a></li>
		</ul>
	</div>
</div>