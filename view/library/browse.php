<?php
KalturaHelpers::protectView( $this );
$kaction = KalturaHelpers::getRequestParam( 'kaction', 'browse' );
?>
<?php if ( ! $this->isLibrary ): ?>
	<?php media_upload_header(); ?>
<?php endif; ?>
<div
	class="container-fluid <?php echo ( is_bool( $this->isLibrary ) ) ? 'wrap kaltura-wrap ' . esc_attr( $kaction ) : 'kaltura-tab' ?>">
	<?php if ( $this->isLibrary ): ?>
		<h2>All in One Video</h2>
		<?php $this->renderView( 'library/library-menu.php' ); ?>
	<?php endif; ?>
	<?php
	$selectedAction      = $kaction == 'browse' ? 'media-upload.php' : 'upload.php';
	$browseFormUrlAction = admin_url( $selectedAction . '?' );

	$pageLinks            = paginate_links(
		array(
			'base'    => add_query_arg( 'paged', '%#%' ),
			'format'  => '',
			'total'   => intval( $this->totalPages ),
			'current' => intval( $this->page ),
			'type'    => 'array',
		)
	);
	$pageLinksAllowedHtml = array(
		'a'    => array(
			'href'  => array(),
			'class' => array(),
		),
		'span' => array(
			'class' => array()
		),
	);
	?>
	<div class="row">
		<form class="form-inline" id="kaltura-browse-form" action="<?php echo esc_url( $browseFormUrlAction ) ?>"
			  method="get">
			<?php if ( ! count( $this->result->objects ) ): ?>
				<?php if ( $kaction == 'library' ) : ?>
					<p class="info">Result not found.</p>
				<?php endif; ?>
			<?php endif; ?>

			<div class="col-md-2 col-xs-3 hidden-xs">
				<div class="filter-side">
					<div class="row">
						<div id="filter-categories-header">
							<label for="filter-categories"><b>Categories
									(<?php echo esc_html( count( $this->filters->objects ) ) ?>)</b></label>
							<a href="javascript:void(0);" class="pull-right" id="clear-categories">
								<small>Clear categories</small>
							</a>
						</div>
					</div>
					<div class="row">
						<?php $this->renderView( 'filter-categories.php' ); ?>
						<input class="btn" id="filter-categories-button" type="submit" value="Filter"/>
					</div>
				</div>
			</div>
			<?php if ( $kaction == 'browse' ) : ?>
				<input type="hidden" name="tab" value="kaltura_browse"/>
				<input type="hidden" name="post_id" value="<?php echo esc_attr( $this->postId ) ?>"/>
				<input type="hidden" name="chromeless"
					   value="<?php echo esc_attr( KalturaHelpers::getRequestParam( 'chromeless' ) ); ?>"/>
			<?php else: ?>
				<input type="hidden" name="page" value="kaltura_library"/>
			<?php endif; ?>
			<input type="hidden" name="paged" value="1"/>
			<div class="col-md-9 col-xs-12 media-gallery-holder">
				<div class="row">
					<?php $this->renderView( 'filter-media-owner.php' ); ?>
					<div class="entry-search-filter">
						<div class="form-group">
							<input type="text" class="form-control" id="entry-search-box"
								   placeholder="Search Entries" title="Search Entries"
								   value="<?php echo esc_attr( $this->searchWord ); ?>">
						</div>
						<input class="btn" type="submit" value="Go"/>
					</div>
				</div>
				<div class="row" style="overflow-y: scroll;">
					<div class="row" style="overflow-y: scroll;">
						<?php if ( ! count( $this->result->objects ) ): ?>
							<div class="alert alert-info">No Media Found</div>
						<?php endif; ?>
						<?php foreach ( $this->result->objects as $mediaEntry ): ?>
							<?php $mediaCategories = KalturaHelpers::getCategoriesString( $mediaEntry ); ?>
							<?php
							$sendToEditorUrl = KalturaHelpers::generateTabUrl( array(
								'tab'      => 'kaltura_browse',
								'kaction'  => 'sendtoeditor',
								'entryIds' => array( $mediaEntry->id )
							) );
							?>
							<?php
							$canUserEditMedia = $mediaEntry->canUserEditMedia;
							$entryNameClass   = $canUserEditMedia ? 'showName' : '';
							?>
							<div class="col-md-3 col-sm-4 col-xs-6 col-lg-2">
								<div class="thumbnail text-center">
									<?php $entryUrl = $mediaEntry->thumbnailUrl . "/width/160/height/90/type/2/bgcolor/000"; ?>
									<?php if ( $this->isLibrary ): ?>
										<img src="<?php echo esc_url( $entryUrl ); ?>"
											 alt="<?php echo esc_attr( $mediaEntry->name ); ?>"
											 title="Categories&#10;<?php echo esc_attr( $mediaCategories ); ?>"
											 class="img-responsive"/>
									<?php else: ?>
										<a href="<?php echo esc_url( $sendToEditorUrl ); ?>">
											<img src="<?php echo esc_url( $entryUrl ); ?>"
												 alt="<?php echo esc_attr( $mediaEntry->name ); ?>"
												 title="Categories&#10;<?php echo esc_attr( $mediaCategories ); ?>"
												 onerror="replaceBrokenImage(this)"/>
										</a>
									<?php endif; ?>
									<div id="entryId_<?php echo esc_attr( $mediaEntry->id ); ?>"
										  class="entryTitle <?php echo $entryNameClass; ?> text-center"
										  title="<?php if ( $canUserEditMedia ) {
											  echo esc_attr( 'Click to edit' );
										  } ?>">
										<small>
											<?php echo esc_html( $mediaEntry->name ); ?>
										</small>
									</div>
									<?php if ( ! $this->isLibrary ): ?>
										<div>
											<a title="Insert into post"
											   href="<?php echo esc_url( $sendToEditorUrl ); ?>">
												<span class="glyphicon glyphicon-ok-sign" style="font-size: 18px; margin-top: 10px; color: green"></span>
											</a>
										</div>
									<?php endif; ?>
									<?php if ( $this->isLibrary && $mediaEntry->isUserMediaOwner ): ?>
										<input type="button" title="Delete video" class="delete"
											   data-id="<?php echo esc_attr( $mediaEntry->id ); ?>"/>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php if ( $pageLinks ): ?>
					<div class="row text-center">
						<ul class="pagination">
							<?php foreach ( $pageLinks as $pageNumber => $pageLink ): ?>
								<li><?php echo $pageLink; ?></li>
							<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
	</div>
	</form>
</div>
</div>
<style>
	.thumbnail {
		width: 160px;
	}
</style>
<script type="text/javascript">
	jQuery(function () {
		jQuery('li div.showName').kalturaEditableName({
			namePostParam: 'entryName',
			idPostParam: 'entryId',
			idPrefix: 'entryId_',
			url: ajaxurl + '?action=kaltura_ajax&kaction=saveentryname'
		});
		jQuery('.pagination li .current').parent().addClass('active');
	});

	function replaceBrokenImage(img) {
		jQuery(img).addClass('default-thumbnail').attr('alt', '').attr('src', '');
	}

	//window.top.Kaltura.restoreModalBoxWp26();
</script>
