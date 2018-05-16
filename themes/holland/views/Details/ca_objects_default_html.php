<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Catalog Number</H6>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.book_title"><div class="unit"><H6>Title</H6><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.book_title.bookpaintingtitle<ifdef code="ca_objects.book_title.trans"><br/>^ca_objects.book_title.trans</ifdef></unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.fmp_date_of_origin"><div class="unit"><H6>Date of Origin</H6>^ca_objects.fmp_date_of_origin</div></ifdef>}}}
				{{{<ifdef code="ca_objects.manufacturer"><div class="unit"><H6>Manufacturer</H6>^ca_objects.manufacturer</div></ifdef>}}}
				{{{<ifdef code="ca_objects.author"><div class="unit"><H6>Artist/Author</H6>^ca_objects.author.auth</div></ifdef>}}}
				{{{<ifdef code="ca_objects.material"><div class="unit"><H6>Materials</H6>^ca_objects.material%delimiter=,_</div></ifdef>}}}
<?php
				$va_dimensions_pieces = array();
				$va_dimensions = array();
				if($t_object->get("ca_objects.dimensions")){
					print "<div class='unit'><H6>Dimensions</H6>";
					$va_dimension_fields = array("dimensions_height", "dimensions_length", "dimensions_width", "dimensions_depth");
					foreach($va_dimension_fields as $vs_dim_field){
						if($vs_tmp = $t_object->get("ca_objects.dimensions.".$vs_dim_field)){
							$va_dimensions_pieces[] = $vs_tmp;
						}
					}
					if(sizeof($va_dimensions_pieces)){
						$va_dimensions[] = join(" X ", $va_dimensions_pieces)." in.";
					}
					$va_more_dimensions_fields = array("dimensions_weight", "dimensions_diameter", "dimensions_circumference");
					foreach($va_more_dimensions_fields as $vs_dim_field){
						if($vs_tmp = $t_object->get("ca_objects.dimensions.".$vs_dim_field)){
							$va_dimensions[] = $vs_tmp." in.";
						}
					}
					if(sizeof($va_dimensions)){
						print join(", ", $va_dimensions);
						if($vs_dim_notes = $t_object->get("ca_objects.dimensions.meas_line1")){
							print "<br/>";
						}
					}
					print $vs_dim_notes;
					print "</div>";
				}
?>
				{{{<ifdef code="ca_objects.descriptions">
					<div class='unit'><h6>Description</h6>
						<span class="trimText">^ca_objects.descriptions</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.doninf.name"><div class="unit"><H6>Gift of</H6>^ca_objects.doninf.name</div></ifdef>}}}					
<?php
				if($vs_history = nl2br($t_object->get("ca_objects.provenance"))){
?>					
					<div class='unit'><h6>History</h6>
						<span class="trimText"><?php print $vs_history; ?></span>
					</div>				
<?php
				}		
?>
				{{{<ifdef code="ca_objects.obn.nos"><div class="unit"><H6>Notes</H6>^ca_objects.obn.nos</div></ifdef>}}}
				
						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>