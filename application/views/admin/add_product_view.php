<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Добавить книгу</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">

	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>


		<!--  start step-holder -->
		<div id="step-holder">
			<div class="step-no">1</div>
			<div class="step-dark-left"><a href="">Add product details</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no-off">2</div>
			<div class="step-light-left">Select related products</div>
			<div class="step-light-right">&nbsp;</div>
			<div class="step-no-off">3</div>
			<div class="step-light-left">Preview</div>
			<div class="step-light-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->

		<!-- start id-form -->
    <form method="post" action="/admin/add_product" enctype="multipart/form-data">
    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Название книги:</th>
			<td><input type="text" class="inp-form" name="title" value="<?php echo set_value('title');?>" /></td>
			<td><span style="color: red"><?=form_error('title')?></span></td>
		</tr>
		<tr>
			<th valign="top">Автор:</th>
			<td><input type="text" class="inp-form" name="author" value="<?php echo set_value('author');?>" /></td>
			<td>
				<span style="color: red"><?=form_error('author')?></span>
			</td>
		</tr>
		<tr>
		<th valign="top">Категория:</th>
		<td>
		<select  class="styledselect_form_1" name="category">
			<?=$categorys?>
		</select>
		</td>
		<td><span style="color: red"><?=form_error('category')?></span></td>
		</tr>
		<tr>
		<th valign="top">Жанр:</th>
		<td>
		<select  class="styledselect_form_1" name="genre">
			<option value=""></option>
			<?=$genres?>
		</select>
		</td>
		<td><span style="color: red"><?=form_error('genre')?></span></td>
		</tr>
		<tr>
			<th valign="top">Год публикации:</th>
			<td><input type="text" class="inp-form" name="pubyear" value="<?php echo set_value('pubyear');?>"/></td>
			<td><span style="color: red"><?=form_error('pubyear')?></span></td>
		</tr>
    <tr>
			<th valign="top">Цена:</th>
			<td><input type="text" class="inp-form" name="product_price" value="<?php echo set_value('product_price');?>"/></td>
			<td><span style="color: red"><?=form_error('product_price')?></span></td>
			</tr>

	<tr>
		<th valign="top">Описание:</th>
		<td><textarea rows="" cols="" class="form-textarea" name="product_description"><?php echo set_value('product_description');?></textarea></td>
		<td><span style="color: red"><?=form_error('product_description')?></span></td>
	</tr>
	<tr>
	<th>Image:</th>
	<td><input type="file" class="file_" name="image" /></td>
	<td>
	
	</td>
	<td><span style="color: red"><?=form_error('image')?></span></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td valign="top">
			<input type="submit" value="" name="add" class="form-submit" />
			<input type="reset" value="" class="form-reset"  />
		</td>
		<td></td>
	</tr>
	</table>
</form>
  <!-- end id-form  -->

	</td>
	<td>

	<!--  start related-activities -->
	<div id="related-activities">

		<!--  start related-act-top -->
		<div id="related-act-top">
		<img src="/images/forms/header_related_act.gif" width="271" height="43" alt="" />
		</div>
		<!-- end related-act-top -->

		<!--  start related-act-bottom -->
		<div id="related-act-bottom">

			<!--  start related-act-inner -->
			<div id="related-act-inner">

				<div class="left"><a href=""><img src="/images/forms/icon_plus.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Add another product</h5>
					Lorem ipsum dolor sit amet consectetur
					adipisicing elitsed do eiusmod tempor.
					<ul class="greyarrow">
						<li><a href="">Click here to visit</a></li>
						<li><a href="">Click here to visit</a> </li>
					</ul>
				</div>

				<div class="clear"></div>
				<div class="lines-dotted-short"></div>

				<div class="left"><a href=""><img src="/images/forms/icon_minus.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Delete products</h5>
					Lorem ipsum dolor sit amet consectetur
					adipisicing elitsed do eiusmod tempor.
					<ul class="greyarrow">
						<li><a href="">Click here to visit</a></li>
						<li><a href="">Click here to visit</a> </li>
					</ul>
				</div>

				<div class="clear"></div>
				<div class="lines-dotted-short"></div>

				<div class="left"><a href=""><img src="/images/forms/icon_edit.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Edit categories</h5>
					Lorem ipsum dolor sit amet consectetur
					adipisicing elitsed do eiusmod tempor.
					<ul class="greyarrow">
						<li><a href="">Click here to visit</a></li>
						<li><a href="">Click here to visit</a> </li>
					</ul>
				</div>
				<div class="clear"></div>

			</div>
			<!-- end related-act-inner -->
			<div class="clear"></div>

		</div>
		<!-- end related-act-bottom -->

	</div>
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="/images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>

<div class="clear"></div>


</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>
<div class="clear">&nbsp;</div>
</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>
