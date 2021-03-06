<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
//$root=Yii::getPathOfAlias('webroot');
//$js=Yii::app()->assetManager->publish($root.'/protected/views/site/index.js');
//$css=Yii::app()->assetManager->publish($root.'/protected/views/site/index.css');
//Yii::app()->clientScript->registerScriptFile($js,CClientScript::POS_READY);
Yii::app()->clientScript->registerCss("viewStyle","
.header {border-bottom: 1px solid #ccc;}
#ticker {height:300px; overflow-y:auto;padding:0;margin:0;}
#ticker a{color:inherit;text-decoration:none;}
#ticker li{border-bottom: 1px solid #ccc;padding:5px;margin:0px; cursor:pointer;}
.newsDescr{padding:5px 0px;}
li:hover {background-color:#fafafa;}
.vertical-scroll{overflow-y:auto;}
.block-list .items .thumbnails {margin:0px}
.block-list .items .thumbnails li {float:none;margin:2px}
.productionList{height:300px;}
.productionList .list-view{padding-top:0px;}
.productionList .nav{margin-bottom:10px;}
.fringeproducutionlist .caption {max-height:964px;overflow-y:scroll};
");
Yii::app()->clientScript->registerMetaTag(Yii::app()->name, null, null, array('property' => "og:title"));
Yii::app()->clientScript->registerMetaTag('Theatre Profile is a social website for everyone interested in theatre and the professional theatrical community.', null, null, array('property' => "og:description"));
Yii::app()->clientScript->registerMetaTag(yii::app()->getBaseUrl(true).'/images/logo_522X203.png', null, null, array('property' => "og:image"));
?>

	
	
<?php
if(Yii::app()->user->isGuest)
{
	//$this->widget('bootstrap.widgets.TbCarousel', array('items'=>$items));
?>
<br />

<div class="row-fluid" class="fringeprodcutionlist">
	<div class="span9">
		<div class="thumbnail">
		<a href="http://www.theatreprofile.com/company/131/fort-worth-fringe-fest"><img style="width:220px;height:220px;margin-right:10px" src='.\images\fringefest_2017.png' class="pull-left" /></a>
			<div class="caption">

				<p>
				<strong>Texas Nonprofit Theatres and the Fort Worth Community Arts Center present the inaugural Fort Worth Fringe Fest on September 1 & 2, 2017.</strong>
				<br />
				<br />
				<strong>
				The Fort Worth Fringe Fest is an opportunity for performing artists and groups in a wide variety of disciplines to present work that excites and broadens the cultural offerings for the community. Theatre, dance, music, puppetry, comedy, poetry, spoken word, performance art, magic – all forms of expression are welcome. The concentrated time period for this first iteration of the Fest is geared toward a full immersion experience - but one that lets audiences pick and choose. It’s time to show off your Fort Worth funky side and help create the template for Fort Worth’s first Fringe Fest!
				</strong>



				</p>
			</div>
		</div>
	</div>
	<div class="span3">
		<div class="thumbnail">
		<?php
			$this->widget('application.modules.user.widgets.LoginWidget');
		?>
		</div>
	</div>
</div>

<br />

<div class="row-fluid fringeproducutionlist">
	<div class="span12">
		<div class="thumbnail">
			<div class="caption">
				<h1>Shows in the Fringe Fest</h1>
				<?php
				//$fringefest= Company::model()->findByPK(32);
				$productioncompanycrews=Productioncompanycrew::model()->findAll(array('with'=>'production.show','order'=>'show.showName','condition'=>'companyID=131'));
				foreach($productioncompanycrews as $productioncompanycrew)
				{
					$production=$productioncompanycrew->production;
					if(strtotime($production->startDate)>strtotime('01-01-2017'))
					{
				?>
					<div class="mini-layout clearfix">
						<div class="productionInfo">
							<div class="media">
								<?php
								$profile_image=Profileimage::model()->with('image')->find('profileType=2 AND imageType=1 AND profileID='.$production->id);
								$show=Show::model()->with('category')->with('showcreators')->findByPk($production->show->id);
								if(isset($profile_image->image->imageURL))
								{
									$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w140h220.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
									Yii::app()->clientScript->registerMetaTag(yii::app()->getBaseUrl(true).'/images/uploads/'.$profile_image->image->imageURL, null, null, array('property' => "og:image"));
									//Yii::app()->clientScript->registerMetaTag("140", null, null, array('property' => "og:image:width"));
									//Yii::app()->clientScript->registerMetaTag("220", null, null, array('property' => "og:image:height"));
								}
								else
								{
									$profile_image=Profileimage::model()->with('image')->find('profileType=1 AND imageType=1 AND profileID='.$show->id);
									if(isset($profile_image->image->imageURL))
									{
										$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w140h220.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
										Yii::app()->clientScript->registerMetaTag(yii::app()->getBaseUrl(true).'/images/uploads/'.$profile_image->image->imageURL, null, null, array('property' => "og:image"));
										//Yii::app()->clientScript->registerMetaTag("140", null, null, array('property' => "og:image:width"));
										//Yii::app()->clientScript->registerMetaTag("220", null, null, array('property' => "og:image:height"));
									}
									else
									{					
										$image_url=yii::app()->request->baseUrl.'/images/default/default_140x220.gif';
										//Yii::app()->clientScript->registerMetaTag(yii::app()->getBaseUrl(true).'/images/default/default_140x220.gif', null, null, array('property' => "og:image"));
										//Yii::app()->clientScript->registerMetaTag("140", null, null, array('property' => "og:image:width"));
										//Yii::app()->clientScript->registerMetaTag("220", null, null, array('property' => "og:image:height"));
									}
								}
								
								?>
								<div class="pull-left text-center">
									<div class="pnl-profile-pic">
										<a href='<?php echo $production->createUrl(); ?>'> 
											<img class="media-object" src="<?php echo $image_url; ?>" width="140px" height="220px" alt="" />
										</a>
									</div>
								</div>
							
								<div class="media-body">
									<div class="media-heading"><h1 class="inline">
									<a href='<?php echo $production->createUrl(); ?>'> 
									<?php echo $show->showName; ?><small><?php echo ' '.$production->productionName; ?></small></h1>
									</a>
									</div>
									<div class="clearfix" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
									<?php
									if(!Yii::app()->user->isGuest)
									{	
										$Productionrating = Productionrating::model()->find("productionID=:productionID and userID=:userID",array(':productionID'=>$production->id,':userID'=>Yii::app()->user->id));
										$this->widget('CStarRating',array('allowEmpty'=>false,'id'=>'rating','name'=>'rating','starCount'=>5,'ratingStepSize'=>0.5,'minRating' => 0.5,'maxRating' => 5,'value'=>empty($Productionrating)?'0':(float)$Productionrating->rating,'htmlOptions'=>array('class'=>'hide'),
										'callback'=>'
											function(){
											$.ajax({
												type: "POST",
												url: "'.Yii::app()->createUrl('production/rating').'",
												data: "YII_CSRF_TOKEN='.Yii::app()->request->csrfToken.'&productionID='.$production->id.'&value=" + $(this).val(),
												success: function(msg){
													//alert("Thank you for rating this production a" + msg);
												}
											})}'
										));
									}
									$Productionrating = Productionrating::model()->find("productionID=:productionID",array(':productionID'=>$production->id,));
										
									if(!empty($Productionrating))
									{
										echo '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">Average rating: <span itemprop="average" class="badge badge-important"><strong>'.$production->avgrating.'</strong></span> from <span itemprop="votes">'.$production->ratingcount.'</span> users.';						
									}
									else
									{
										echo "<small>Average rating not available.</small>";
									}
									?>
									
									</div>
									<div class="row-fluid">
										<div class="span12">
											<div>
												<strong>Category: </strong><?php echo $show->category->categoryName; ?>, <strong>Duration: </strong><?php echo isset($production->duration)?$production->duration.' minutes':'NA'; ?>, <strong>Intermissions: </strong><?php echo isset($production->intermissions)?$production->intermissions:'NA'; ?>
											</div>
											<ul class="unstyled">
											<?php
												$book ='';
												$music='';
												$lyrics='';
												$adaptation='';
												$translation='';
												$concept='';
												
												foreach($show->showcreators as $creator)
												{
													$name = $creator->individual->firstName.' '.$creator->individual->middleName.' '.$creator->individual->lastName.' '.$creator->individual->suffix;	
													switch($creator->role->roleName)
													{
														case "Book":$book = $book.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Lyrics":$lyrics = $lyrics.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Music":$music = $music.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Adaptation":$adaptation = $adaptation.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Translation":$translation = $translation.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Concept":$concept = $concept.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														default:break;
													}
												}
												if($book!='')echo '<li><strong>Book: </strong>'.substr($book, 0, -2).'</li>';
												if($music!='')echo '<li><strong>Music: </strong>'.substr($music,0,-2).'</li>';
												if($lyrics!='')echo '<li><strong>Lyrics: </strong>'.substr($lyrics,0,-2).'</li>';
												if($adaptation!='')echo '<li><strong>Adaptation: </strong>'.substr($adaptation,0,-2).'</li>';
												if($translation!='')echo '<li><strong>Translation: </strong>'.substr($translation,0,-2).'</li>';
												if($concept!='')echo '<li><strong>Concept: </strong>'.substr($concept,0,-2).'</li>';
												$venue_count = count($production->productionvenues);
												if($venue_count==1)
												{
													$productionvenue = array_values($production->productionvenues)[0];
													echo '<li>';
													echo '<strong>Venue: </strong><a href="'.$productionvenue->venue->createUrl().'">'.$productionvenue->venue->venueName.', '.$productionvenue->venue->address->addr1.', '.$productionvenue->venue->address->city.', '.$productionvenue->venue->address->state.', '.$productionvenue->venue->address->country->countryName.'</a>';
													$links = Link::model()->findAll('profileType=5 AND profileID='.$productionvenue->id.' and linkType=1');						
													foreach($links as $link)
													{
														echo ' <a href="'.$link->href.'" target="_blank" class="btn btn-mini btn-danger">'.$link->label.'</a>';
													}
													echo '</li>';
												}
												
												else if($venue_count>1)
												{
													echo '<li><a href="#venueList">Multiple venues</a></li>';
												}
												else
												{
													echo '<li>Venue not available</li>';
												}
												
												//echo $model->firstPreviewDate;
												//echo DateTime::createFromFormat('m-d-Y', $model->firstPreviewDate);
												if(!empty($production->firstPreviewDate))
												{
													$newDate = DateTime::createFromFormat('m-d-Y', $production->firstPreviewDate);
													$production->firstPreviewDate = $newDate->format('M d, Y');
												}
												if(!empty($production->startDate))
												{
													$newDate = DateTime::createFromFormat('m-d-Y', $production->startDate);
													$production->startDate = $newDate->format('M d, Y');
												}
												if(!empty($production->endDate))
												{
													$newDate = DateTime::createFromFormat('m-d-Y', $production->endDate);
													$production->endDate = $newDate->format('M d, Y');
												}
												echo '<li><strong>First Preview: </strong>'.$production->firstPreviewDate.'</li>';
												echo '<li><strong>Opening: </strong>'.$production->startDate.'</li>';
												echo '<li><strong>Closing: </strong>'.$production->endDate.'</li>';
												echo '<a class="btn btn-danger pull-right" href='.$production->createUrl().'">More</a>';
											?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
<br />

<div class="row-fluid">
	<div class="span12">
		<div class="thumbnail">
			<div class="caption">
				<h1>Theatre Profile is</h1>
				<p>
					A new way to interact with theatre online. Creating tools, resources and communities to develop the art form and connect people. Create an account for full access or just browse as a guest.<br /><br />
					
					We are always growing and developing so we can provide you with the best experience possible. The best way for us to do this is to hear from you. Join one of our free <a href="<?php echo Yii::app()->request->baseUrl.'/pilot'; ?>">pilot programs</a> to have your voice heard and have your ideas appear as one of the tools on Theatre Profile.
				</p>
			</div>
		</div>
	</div>
</div>

<br />

<div class="row-fluid">
	<div class="thumbnails">
		<div class="span6">
			<div class="thumbnail">
				<div class="caption">
					<h2>For Professionals</h2>
					<p>
						<ul>
						<li>Show your work</li>
						<li>Grow your Audience</li>
						<li>Find your Audience</li>
						<li>Sell tickets</li>
						<li>Find out about your audience</li>
						</ul>
					</p>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="thumbnail">	
				<div class="caption">
					<h2>For Fans</small></h2>
					<p>
						<ul>
						<li>Track of shows and be notified of new productions</li>
						<li>Track artists and be the first to know what they are doing</li>
						<li>Share your favorite shows with friends</li>
						<li>Keep track of shows you have seen and what you thought</li>
						<li>Get recommendations based on your previous likes</li>
						</ul>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<br />

<div class="row-fluid">
	<div class="thumbnail">
		<div class="caption">
			<h2>As a member you will have access to</h2>
		</div>
		<div class="mini-layout">
			<h3>Create and edit profiles</h3>
			<img src="./images/CreateEdit.jpg" class="img-rounded" width="1170px" height="400px">
			
		</div>
		<br />
		<div class="mini-layout">
			<h3>Analytics and statistics for profiles you have claimed</h3>
			<img src="./images/Audience-Knowledge.jpg" class="img-rounded" width="1170px" height="400px">
		</div>
		<br />
		<div class="mini-layout">
			<h3>Recommendations</h3>
			<img src="./images/Auto-Fill-Animation.gif" class="img-rounded" width="1170px" height="400px">
		</div>
		<br />
		<div class="mini-layout">
			<h3>News Feeds</h3>
			<img src="./images/News.jpg" class="img-rounded" width="1170px" height="400px">
		</div>
		<br />
		<div class="mini-layout">
			<h3>Promote & Share</h3>
			<img src="./images/Promote-Connect-V2.jpg" class="img-rounded" width="1170px" height="400px">
		</div>
	</div>
</div>
<br />
<?php
}
else
{
?>
<br />
<div class="row-fluid">
	<h2>Welcome, <?php echo Yii::app()->getModule('user')->user()->profile->getAttribute('firstname'); ?><small><a class="pull-right" href="<?php echo yii::app()->createUrl('/user/profile'); ?>">Account settings</a></small></h2>
	<div class="thumbnail">
		<div class="header">
			<h3>My Watchlist<a class="btn btn-link pull-right" href="<?php echo yii::app()->createUrl('/profileownership'); ?>">View Owned Profiles</a></h3>
		</div>
		<div class="watchList vertical-scroll">
		<?php
		if(!Yii::app()->user->isGuest)
		{
			$criteria1 = new CDbCriteria();
			$criteria1->condition = 'userID=:userID';
			$criteria1->params = array(':userID'=>Yii::app()->user->id);
			$criteria1->order="showName";
			$criteria1->with=array('show');
			$dataProvider1 = new CActiveDataProvider('Showwatchlist',array('criteria'=>$criteria1,));		
			
			$criteria2 = new CDbCriteria();
			$criteria2->condition = 'userID=:userID';
			$criteria2->params = array(':userID'=>Yii::app()->user->id);
			$criteria2->with=array('production.show');
			$criteria2->order="showName";
			$dataProvider2 = new CActiveDataProvider('Productionwatchlist',array('criteria'=>$criteria2,));
			
			$criteria3 = new CDbCriteria();
			$criteria3->condition = 'userID=:userID';
			$criteria3->params = array(':userID'=>Yii::app()->user->id);
			$criteria3->order="firstName";
			$criteria3->with=array('individual');
			$dataProvider3 = new CActiveDataProvider('Individualwatchlist',array('criteria'=>$criteria3,));
			
			$criteria4 = new CDbCriteria();
			$criteria4->condition = 'userID=:userID';
			$criteria4->params = array(':userID'=>Yii::app()->user->id);
			$criteria4->order="venueName";
			$criteria4->with=array('venue');
			$dataProvider4 = new CActiveDataProvider('Venuewatchlist',array('criteria'=>$criteria4,));
			
			$criteria5 = new CDbCriteria();
			$criteria5->condition = 'userID=:userID';
			$criteria5->params = array(':userID'=>Yii::app()->user->id);
			$criteria5->order="companyName";
			$criteria5->with=array('company');
			$dataProvider5 = new CActiveDataProvider('Companywatchlist',array('criteria'=>$criteria5,));
				
			//$this->render('index',array('dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,'dataProvider4'=>$dataProvider4));
		
			if($dataProvider1->totalItemCount+$dataProvider2->totalItemCount+$dataProvider3->totalItemCount+$dataProvider4->totalItemCount+$dataProvider5->totalItemCount==0)
			echo '<div>No items in your watchlist.</div>';
			else
			{
			?>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#shows" data-toggle="tab">Shows</a></li>
				<li><a href="#productions" data-toggle="tab">Productions</a></li>
				<li><a href="#people" data-toggle="tab">People</a></li>
				<li><a href="#venues" data-toggle="tab">Venues</a></li>
				<li><a href="#companies" data-toggle="tab">Companies</a></li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="shows">
				<?php
				if($dataProvider1->totalItemCount>0)
				{
					$this->widget('bootstrap.widgets.TbThumbnails', array(
					'dataProvider'=>$dataProvider1,
					'template'=>"{items}",
					'itemView'=>'_index1',
					'htmlOptions'=>array("class"=>"block-list list-view"),
					));
				}
				?>
				</div>
				<div class="tab-pane" id="productions">
				<?php
				if($dataProvider2->totalItemCount>0)
				{
					$this->widget('bootstrap.widgets.TbThumbnails', array(
					'dataProvider'=>$dataProvider2,
					'template'=>"{items}",
					'itemView'=>'_index2',
					'htmlOptions'=>array("class"=>"block-list list-view"),
					));
				}
				?>
				</div>
				<div class="tab-pane" id="people">
				<?php
				if($dataProvider3->totalItemCount>0)
				{
					$this->widget('bootstrap.widgets.TbThumbnails', array(
					'dataProvider'=>$dataProvider3,
					'template'=>"{items}",
					'itemView'=>'_index3',
					'htmlOptions'=>array("class"=>"block-list list-view"),
					));
				}
				?>
				</div>
				<div class="tab-pane" id="venues">
				<?php
				if($dataProvider4->totalItemCount>0)
				{
					$this->widget('bootstrap.widgets.TbThumbnails', array(
					'dataProvider'=>$dataProvider4,
					'template'=>"{items}",
					'itemView'=>'_index4',
					'htmlOptions'=>array("class"=>"block-list list-view"),
					));
				}
				?>
				</div>
				<div class="tab-pane" id="companies">
				<?php
				if($dataProvider5->totalItemCount>0)
				{
					$this->widget('bootstrap.widgets.TbThumbnails', array(
					'dataProvider'=>$dataProvider5,
					'template'=>"{items}",
					'itemView'=>'_index5',
					'htmlOptions'=>array("class"=>"block-list list-view"),
					));
				}
				?>
				</div>
			</div>
		<?php
			}
		}
		?>
		</div>
	</div>
</div>
<br />


<div class="row-fluid">
	<div class="span12">
		<div class="thumbnail">
			<a href="http://www.theatreprofile.com/company/131/fort-worth-fringe-fest"><img style="width:160px;height:160px;margin-right:10px" src='.\images\fringefest_2017.png' class="pull-left" /></a>
			<div class="caption">
				<strong>Texas Nonprofit Theatres and the Fort Worth Community Arts Center present the Fort Worth Fringe Fest on September 1 & 2, 2017.</strong>
				<br />
				<br />
				<strong>
				The Fort Worth Fringe Fest is an opportunity for performing artists and groups in a wide variety of disciplines to present work that excites and broadens the cultural offerings for the community. Theatre, dance, music, puppetry, comedy, poetry, spoken word, performance art, magic – all forms of expression are welcome. The concentrated time period for this first iteration of the Fest is geared toward a full immersion experience - but one that lets audiences pick and choose. It’s time to show off your Fort Worth funky side and help create the template for Fort Worth’s first Fringe Fest!
				</strong>
				</p>
			</div>
		</div>
	</div>
</div>

<br />


<div class="row-fluid fringeproducutionlist">
	<div class="span12">
		<div class="thumbnail">
			<div class="caption">
				<h1>Shows in the Fringe Fest</h1>
				<?php
				$productioncompanycrews=Productioncompanycrew::model()->findAll(array('with'=>'production.show','order'=>'show.showName','condition'=>'companyID=131'));
				foreach($productioncompanycrews as $productioncompanycrew)
				{
					$production=$productioncompanycrew->production;
					if(strtotime($production->startDate)>strtotime('01-01-2017'))
					{
				?>
					<div class="mini-layout clearfix">
						<div class="productionInfo">
							<div class="media">
								<?php
								$profile_image=Profileimage::model()->with('image')->find('profileType=2 AND imageType=1 AND profileID='.$production->id);
								$show=Show::model()->with('category')->with('showcreators')->findByPk($production->show->id);
								if(isset($profile_image->image->imageURL))
								{
									$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w140h220.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
									Yii::app()->clientScript->registerMetaTag(yii::app()->getBaseUrl(true).'/images/uploads/'.$profile_image->image->imageURL, null, null, array('property' => "og:image"));
									//Yii::app()->clientScript->registerMetaTag("140", null, null, array('property' => "og:image:width"));
									//Yii::app()->clientScript->registerMetaTag("220", null, null, array('property' => "og:image:height"));
								}
								else
								{
									$profile_image=Profileimage::model()->with('image')->find('profileType=1 AND imageType=1 AND profileID='.$show->id);
									if(isset($profile_image->image->imageURL))
									{
										$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w140h220.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
										Yii::app()->clientScript->registerMetaTag(yii::app()->getBaseUrl(true).'/images/uploads/'.$profile_image->image->imageURL, null, null, array('property' => "og:image"));
										//Yii::app()->clientScript->registerMetaTag("140", null, null, array('property' => "og:image:width"));
										//Yii::app()->clientScript->registerMetaTag("220", null, null, array('property' => "og:image:height"));
									}
									else
									{					
										$image_url=yii::app()->request->baseUrl.'/images/default/default_140x220.gif';
										//Yii::app()->clientScript->registerMetaTag(yii::app()->getBaseUrl(true).'/images/default/default_140x220.gif', null, null, array('property' => "og:image"));
										//Yii::app()->clientScript->registerMetaTag("140", null, null, array('property' => "og:image:width"));
										//Yii::app()->clientScript->registerMetaTag("220", null, null, array('property' => "og:image:height"));
									}
								}
								
								?>
								<div class="pull-left text-center">
									<div class="pnl-profile-pic">
										<a href='<?php echo $production->createUrl(); ?>'> 
											<img class="media-object" src="<?php echo $image_url; ?>" width="140px" height="220px" alt="" />
										</a>
									</div>
								</div>
							
								<div class="media-body">
									<div class="media-heading"><h1 class="inline">
									<a href='<?php echo $production->createUrl(); ?>'> 
									<?php echo $show->showName; ?><small><?php echo ' '.$production->productionName; ?></small></h1>
									</a>
									</div>
									<div class="clearfix" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
									<?php
									if(!Yii::app()->user->isGuest)
									{	
										$Productionrating = Productionrating::model()->find("productionID=:productionID and userID=:userID",array(':productionID'=>$production->id,':userID'=>Yii::app()->user->id));
										$this->widget('CStarRating',array('allowEmpty'=>false,'id'=>'rating','name'=>'rating','starCount'=>5,'ratingStepSize'=>0.5,'minRating' => 0.5,'maxRating' => 5,'value'=>empty($Productionrating)?'0':(float)$Productionrating->rating,'htmlOptions'=>array('class'=>'hide'),
										'callback'=>'
											function(){
											$.ajax({
												type: "POST",
												url: "'.Yii::app()->createUrl('production/rating').'",
												data: "YII_CSRF_TOKEN='.Yii::app()->request->csrfToken.'&productionID='.$production->id.'&value=" + $(this).val(),
												success: function(msg){
													//alert("Thank you for rating this production a" + msg);
												}
											})}'
										));
									}
									$Productionrating = Productionrating::model()->find("productionID=:productionID",array(':productionID'=>$production->id,));
										
									if(!empty($Productionrating))
									{
										echo '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">Average rating: <span itemprop="average" class="badge badge-important"><strong>'.$production->avgrating.'</strong></span> from <span itemprop="votes">'.$production->ratingcount.'</span> users.';						
									}
									else
									{
										echo "<small>Average rating not available.</small>";
									}
									?>
									
									</div>
									<div class="row-fluid">
										<div class="span12">
											<div>
												<strong>Category: </strong><?php echo $show->category->categoryName; ?>, <strong>Duration: </strong><?php echo isset($production->duration)?$production->duration.' minutes':'NA'; ?>, <strong>Intermissions: </strong><?php echo isset($production->intermissions)?$production->intermissions:'NA'; ?>
											</div>
											<ul class="unstyled">
											<?php
												$book ='';
												$music='';
												$lyrics='';
												$adaptation='';
												$translation='';
												$concept='';
												
												foreach($show->showcreators as $creator)
												{
													$name = $creator->individual->firstName.' '.$creator->individual->middleName.' '.$creator->individual->lastName.' '.$creator->individual->suffix;	
													switch($creator->role->roleName)
													{
														case "Book":$book = $book.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Lyrics":$lyrics = $lyrics.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Music":$music = $music.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Adaptation":$adaptation = $adaptation.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Translation":$translation = $translation.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														case "Concept":$concept = $concept.'<span itemscope itemtype="http://schema.org/Person"><a itemprop="url" href="'.$creator->individual->createUrl().'"><span class="itemprop" itemprop="name">'.trim($name).'</span></a></span>, ';break;
														default:break;
													}
												}
												if($book!='')echo '<li><strong>Book: </strong>'.substr($book, 0, -2).'</li>';
												if($music!='')echo '<li><strong>Music: </strong>'.substr($music,0,-2).'</li>';
												if($lyrics!='')echo '<li><strong>Lyrics: </strong>'.substr($lyrics,0,-2).'</li>';
												if($adaptation!='')echo '<li><strong>Adaptation: </strong>'.substr($adaptation,0,-2).'</li>';
												if($translation!='')echo '<li><strong>Translation: </strong>'.substr($translation,0,-2).'</li>';
												if($concept!='')echo '<li><strong>Concept: </strong>'.substr($concept,0,-2).'</li>';
												$venue_count = count($production->productionvenues);
												if($venue_count==1)
												{
													$productionvenue = array_values($production->productionvenues)[0];
													echo '<li>';
													echo '<strong>Venue: </strong><a href="'.$productionvenue->venue->createUrl().'">'.$productionvenue->venue->venueName.', '.$productionvenue->venue->address->addr1.', '.$productionvenue->venue->address->city.', '.$productionvenue->venue->address->state.', '.$productionvenue->venue->address->country->countryName.'</a>';
													$links = Link::model()->findAll('profileType=5 AND profileID='.$productionvenue->id.' and linkType=1');						
													foreach($links as $link)
													{
														echo ' <a href="'.$link->href.'" target="_blank" class="btn btn-mini btn-danger">'.$link->label.'</a>';
													}
													echo '</li>';
												}
												
												else if($venue_count>1)
												{
													echo '<li><a href="#venueList">Multiple venues</a></li>';
												}
												else
												{
													echo '<li>Venue not available</li>';
												}
												
												//echo $model->firstPreviewDate;
												//echo DateTime::createFromFormat('m-d-Y', $model->firstPreviewDate);
												if(!empty($production->firstPreviewDate))
												{
													$newDate = DateTime::createFromFormat('m-d-Y', $production->firstPreviewDate);
													$production->firstPreviewDate = $newDate->format('M d, Y');
												}
												if(!empty($production->startDate))
												{
													$newDate = DateTime::createFromFormat('m-d-Y', $production->startDate);
													$production->startDate = $newDate->format('M d, Y');
												}
												if(!empty($production->endDate))
												{
													$newDate = DateTime::createFromFormat('m-d-Y', $production->endDate);
													$production->endDate = $newDate->format('M d, Y');
												}
												echo '<li><strong>First Preview: </strong>'.$production->firstPreviewDate.'</li>';
												echo '<li><strong>Opening: </strong>'.$production->startDate.'</li>';
												echo '<li><strong>Closing: </strong>'.$production->endDate.'</li>';
												echo '<a class="btn btn-danger pull-right" href='.$production->createUrl().'">More</a>';
											?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
<br />





	
<div class="row-fluid">
	<div class="mini-layout">
		<h2>Right now on Theatre Profile</h2>
		<!--<small>Create an account and become a part of the action</small> <a class="btn btn-danger" href="<?php echo Yii::app()->createUrl('user/registration'); ?>">Register</a>
		-->
		</h2>
		<div class="thumbnails">
			<div class="span6">
				<div class="thumbnail">	
					<div class="header">		
						<h3>News & Updates<a class="btn btn-link pull-right" href="<?php echo Yii::app()->getBaseUrl(); ?>/news">View All</a></h3>
					</div>
					<ul id="ticker">
					<?php 
					function formatDateDiff($start, $end=null) { 
						if(!($start instanceof DateTime)) {$start = new DateTime($start);}
						if($end === null) {$end = new DateTime();}
						if(!($end instanceof DateTime)) {$end = new DateTime($start);}
						$interval = $end->diff($start); 
						$doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals 
						$format = array();
						if($interval->y !== 0) {$format[] = "%y ".$doPlural($interval->y, "year");} 
						if($interval->m !== 0) {$format[] = "%m ".$doPlural($interval->m, "month");} 
						if($interval->d !== 0) {$format[] = "%d ".$doPlural($interval->d, "day");} 
						if($interval->h !== 0) {$format[] = "%h ".$doPlural($interval->h, "hour");} 
						if($interval->i !== 0) {$format[] = "%i ".$doPlural($interval->i, "minute");} 
						if($interval->s !== 0) {if(!count($format)) {return "less than a minute ago";} else {$format[] = "%s ".$doPlural($interval->s, "second");}} 
						// We use the two biggest parts 
						if(count($format) > 1) {$format = array_shift($format)." and ".array_shift($format);} else {$format = array_pop($format);} 
						// Prepend 'since ' or whatever you like 
						return $interval->format($format).' ago'; 
					} 
					$criteria = new CDbCriteria;
					$criteria->order = 'publishDate desc';
					$criteria->limit=10;
					$feeditems = Feeditem::model()->with('feed')->findAll($criteria);
					foreach($feeditems as $feeditem)
					{
						echo '<li><a href="'.Yii::app()->getBaseUrl().'/news/'.$feeditem->id.'"><div><strong>'.$feeditem->title.'</strong></div><div><small class="muted">'.formatDateDiff(new DateTime($feeditem->publishDate)).', '.$feeditem->feed->name.'</small></div><div class="newsDescr">'.strip_tags(CHtml::decode($feeditem->descr)).'</div></a></li>';
					}
					?>
					</ul>
				</div>
			</div>
			<div class="span6">
				<div class="thumbnail">
					<div class="header">
						<h3>Top Rated Productions<a class="btn btn-link pull-right" href="<?php echo yii::app()->createUrl('/production'); ?>">View All</a></h3>
					</div>
					<div class="productionList vertical-scroll">
						<div class="block-list list-view" id="yw1">
							<div class="items">
								<ul class="thumbnails">
									<?php
									$data = Yii::app()->db->createCommand('SELECT productionID FROM tbl_productionrating GROUP by productionID ORDER BY AVG(rating)desc,COUNT(*) desc limit 10')->queryAll();
									foreach($data as $data_obj)
									{
										//print_r($data_obj["productionID"]);
										$production=Production::model()->findByPK($data_obj["productionID"])->with('show,productionvenue');
									?>
										<li >
											<div class="media">
												<a href="<?php echo $production->createUrl(); ?>" class="pull-left">
													<?php
													$profile_image=Profileimage::model()->with('image')->find('profileType=2 AND profileID='.$production->id);
													if(isset($profile_image->image->imageURL))
													{
														$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w28h44.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
													}else
													{
														$profile_image=Profileimage::model()->with('image')->find('profileType=1 AND profileID='.$production->showID);
														if(isset($profile_image->image->imageURL))
														{
															$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w28h44.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
														}
														else
														{					
															$image_url=yii::app()->request->baseUrl.'/images/default/default_140x220.gif';
														}
													}
													?>

													<img class="media-object" src="<?php echo $image_url; ?>" width="28px" height="44px" alt="">
												</a>
												
												<div class="media-body">
													<div class="media-heading text-overflow-hide">
														<?php
															$venueInfo='';
															$links=array();
															if(count($production->productionvenues)==1)
															{
																$productionvenue=array_values($production->productionvenues)[0];
																$venueInfo = $productionvenue->venue->venueName.', '.$productionvenue->venue->address->city.', '.$productionvenue->venue->address->state.', '.$productionvenue->venue->address->country->countryName;
																if($productionvenue->startDate < date('m-d-Y') && ($productionvenue->endDate > date('m-d-y')||$productionvenue->endDate =''))
																{
																	$links = Link::model()->findAll('profileType=5 AND profileID='.$productionvenue->id.' and linkType=1');
																}
															}
															else if(count($production->productionvenues)>1)
															{
																$venueInfo = 'Multiple venues';
															}
															else
															{
																$venueInfo = 'Venue not available';
															}
															
														?>
													
														<a href="<?php echo $production->createUrl(); ?>">
															<?php echo $production->show->showName.' - '.(!empty($production->productionName)?$production->productionName:$venueInfo);														//$this->widget('CStarRating',array('name'=>'rating'.$production->id,'id'=>'rating'.$production->id,'readOnly'=>true,'starCount'=>5,'ratingStepSize'=>0.5,'minRating' => 0.5,'maxRating' => 5,'value'=>$production->avgrating,));
															?>
														</a>
														<?php
															echo "<br />Rating: <span class='badge badge-important' rel='tooltip' title='Total ratings: ".$production->ratingcount."' data-placement='right' data-trigger='hover'><strong>".$production->avgrating."</strong></span>";
															if(count($production->productionvenues)==1)
															{
																foreach($links as $link)
																{
																	echo ' <a href="'.$link->href.'" target="_blank" class="btn btn-mini btn-danger">'.$link->label.'</a>';
																}
															}
														?>
													</div>
												</div>
											</div>
										</li>
									<?php
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br />
		<!--
		<div class="row-fluid">
			<div class="thumbnails">
				<div class="span6">
					<div class="thumbnail">
						<div class="header">
							<h3>Current New York Productions</h3>
						</div>
						<div class="productionList vertical-scroll">
							<div class="block-list list-view" id="yw1">
								<div class="items">
									<ul class="thumbnails">
										<?php
										$data = Yii::app()->db->createCommand("SELECT a.id as productionID, b.venueID,b.id as productionVenueID FROM tbl_production a INNER JOIN tbl_productionvenue b ON a.id=b.productionID inner join tbl_venue c on b.venueID = c.id INNER JOIN tbl_address d ON c.addressID = d.id WHERE d.city IN ('New York') AND b.startDate < NOW() AND (b.endDate is NULL or b.endDate > NOW());")->queryAll();
										foreach($data as $data_obj)
										{
											//print_r($data_obj["productionID"]);
											$production=Production::model()->findByPK($data_obj["productionID"]);
											$venue=Venue::model()->findByPK($data_obj["venueID"])->with('address.country');
											$links = Link::model()->findAll('profileType=5 AND profileID='.$data_obj["productionVenueID"].' and linkType=1');
										?>
											<li >
												<div class="media">
													<a href="<?php echo $production->createUrl(); ?>" class="pull-left">
														<?php
														$profile_image=Profileimage::model()->with('image')->find('profileType=2 AND profileID='.$production->id);
														if(isset($profile_image->image->imageURL))
														{
															$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w28h44.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
														}else
														{
															$profile_image=Profileimage::model()->with('image')->find('profileType=1 AND profileID='.$production->showID);
															if(isset($profile_image->image->imageURL))
															{
																$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w28h44.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
															}
															else
															{					
																$image_url=yii::app()->request->baseUrl.'/images/default/default_28x44.gif';
															}
														}
														?>

														<img class="media-object" src="<?php echo $image_url; ?>" width="28px" height="44px" alt="">
													</a>
													
													<div class="media-body">
														<div class="media-heading text-overflow-hide">
															<?php
																$venueInfo='';
																$venueInfo = $venue->venueName.', '.$venue->address->city.', '.$venue->address->state.', '.$venue->address->country->countryName;
															?>
														
															<a href="<?php echo $production->createUrl(); ?>">
																<?php echo $production->show->showName.' - '.(!empty($production->productionName)?$production->productionName:$venueInfo);														//$this->widget('CStarRating',array('name'=>'rating'.$production->id,'id'=>'rating'.$production->id,'readOnly'=>true,'starCount'=>5,'ratingStepSize'=>0.5,'minRating' => 0.5,'maxRating' => 5,'value'=>$production->avgrating,));
																?>
															</a>
															<?php
																echo "<br />Rating: <span class='badge badge-important' rel='tooltip' title='Total ratings: ".$production->ratingcount."' data-placement='right' data-trigger='hover'><strong>".$production->avgrating."</strong></span>";
																foreach($links as $link)
																{
																	echo ' <a href="'.$link->href.'" target="_blank" class="btn btn-mini btn-danger">'.$link->label.'</a>';
																}
															?>
														</div>
													</div>
												</div>
											</li>
										<?php
											}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="span6">
					<div class="thumbnail">
						<div class="header">
							<h3>Current DFW Metroplex Productions</h3>
						</div>
						<div class="productionList vertical-scroll">
							<div class="block-list list-view" id="yw1">
								<div class="items">
									<ul class="thumbnails">
										<?php
										$data = Yii::app()->db->createCommand("SELECT a.id as productionID, b.venueID,b.id as productionVenueID 
FROM tbl_production a INNER JOIN tbl_productionvenue b ON a.id=b.productionID inner join tbl_venue c on b.venueID = c.id INNER JOIN tbl_address d ON c.addressID = d.id WHERE d.city IN ('Dallas','Fort Worth','Arlington','Plano','Garland','Irving','Grand Prairie','McKinney','Mesquite','Frisco','Carrollton','Denton','Richardson','Lewisville','Addison','Allen','Azle','Balch Springs','Bedford','Benbrook','Burleson','Cedar Hill','Cleburne','Colleyville','Coppell','Corinth','Crowley','DeSoto','Duncanville','Ennis','Euless','Farmers Branch','Flower Mound','Forest Hill','Forney','Glenn Heights','Grapevine','Greenville','Haltom City','Highland Village','Hurst','Keller','Lancaster','Little Elm','Mansfield','Midlothian','Mineral Wells (partial)','Murphy','North Richland Hills','Prosper','Rockwall','Rowlett','Saginaw','Sachse','Seagoville','Southlake','Terrell','The Colony','University Park','Watauga','Waxahachie','Weatherford','White Settlement','Wylie','Aledo','Alma','Alvarado','Alvord','Anna','Annetta North','Annetta South','Annetta','Argyle','Aubrey','Aurora','Bardwell','Bartonville','Blue Mound','Blue Ridge','Boyd','Briar','Briaroaks','Bridgeport','Caddo Mills','Campbell','Celeste','Celina','Chico','Cockrell Hill','Combine','Commerce','Cool','Cooper','Copper Canyon','Corral City','Cottonwood','Crandall','Cresson (partial)','Cross Roads','Cross Timber','Dalworthington Gardens','Decatur','DISH','Double Oak','Eagle Mountain','Edgecliff Village','Everman','Fairview','Farmersville','Fate','Ferris','Garrett','Godley','Grandview','Grays Prairie','Gun Barrel City','Hackberry','Haslet','Hawk Cove','Heath','Hebron','Hickory Creek','Highland Park','Hudson Oaks','Hutchins','Italy','Josephine','Joshua','Justin','Kaufman','Keene','Kemp','Kennedale','Knollwood','Krugerville','Krum','Lake Bridgeport','Lake Dallas','Lake Worth','Lakeside','Lakewood Village','Lavon','Lincoln Park','Lone Oak','Lowry Crossing','Lucas','Mabank','Maypearl','McLendon-Chisholm','Melissa','Milford','Millsap','Mobile City','Nevada','New Fairview','New Hope','Newark','Neylandville','Northlake','Oak Grove','Oak Leaf','Oak Point','Oak Ridge','Ovilla','Palmer','Pantego','Paradise','Parker','Pecan Acres','Pecan Hill','Pelican Bay','Pilot Point','Ponder','Post Oak Bend City','Princeton','Providence Village','Quinlan','Red Oak','Rendon','Reno','Rhome','Richland Hills','Rio Vista','River Oaks','Roanoke','Rosser','Royse City','Runaway Bay','Saint Paul','Sanctuary','Sanger','Sansom Park','Scurry','Shady Shores','Springtown','Sunnyvale','Talty','Trophy Club','Union Valley','Van Alstyne','Venus','West Tawakoni','Westlake','Westminster','Weston','Westover Hills','Westworth Village','Willow Park','Wilmer','Wolfe City','Ables Springs','Avalon','Bolivar','Brock','Cash','Copeville','Dennis','Elizabethtown','Elmo','Floyd','Forreston','Garner','Greenwood','Heartland','Ike','Lantana','Lillian','Merit','Paloma Creek','Peaster','Poetry','Poolville','Rockett','Sand Branch','Savannah','Slidell','Telico','Whitt') and d.state='TX' AND b.startDate < NOW() AND (b.endDate is NULL or b.endDate > NOW());")->queryAll();
										foreach($data as $data_obj)
										{
											//print_r($data_obj["productionID"]);
											$production=Production::model()->findByPK($data_obj["productionID"]);
											$venue=Venue::model()->findByPK($data_obj["venueID"])->with('address.country');									
											$links = Link::model()->findAll('profileType=5 AND profileID='.$data_obj["productionVenueID"].' and linkType=1');
										?>
											<li >
												<div class="media">
													<a href="<?php echo $production->createUrl(); ?>" class="pull-left">
														<?php
														$profile_image=Profileimage::model()->with('image')->find('profileType=2 AND profileID='.$production->id);
														if(isset($profile_image->image->imageURL))
														{
															$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w28h44.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
														}else
														{
															$profile_image=Profileimage::model()->with('image')->find('profileType=1 AND profileID='.$production->showID);
															if(isset($profile_image->image->imageURL))
															{
																$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w28h44.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
															}
															else
															{					
																$image_url=yii::app()->request->baseUrl.'/images/default/default_28x44.gif';
															}
														}
														?>

														<img class="media-object" src="<?php echo $image_url; ?>" width="28px" height="44px" alt="">
													</a>
													
													<div class="media-body">
														<div class="media-heading text-overflow-hide">
															<?php
																$venueInfo='';
																$venueInfo = $venue->venueName.', '.$venue->address->city.', '.$venue->address->state.', '.$venue->address->country->countryName;
															?>
														
															<a href="<?php echo $production->createUrl(); ?>">
																<?php echo $production->show->showName.' - '.(!empty($production->productionName)?$production->productionName:$venueInfo);														//$this->widget('CStarRating',array('name'=>'rating'.$production->id,'id'=>'rating'.$production->id,'readOnly'=>true,'starCount'=>5,'ratingStepSize'=>0.5,'minRating' => 0.5,'maxRating' => 5,'value'=>$production->avgrating,));
																?>
															</a>
															<?php
																echo "<br />Rating: <span class='badge badge-important' rel='tooltip' title='Total ratings: ".$production->ratingcount."' data-placement='right' data-trigger='hover'><strong>".$production->avgrating."</strong></span>";
																foreach($links as $link)
																{
																	echo ' <a href="'.$link->href.'" target="_blank" class="btn btn-mini btn-danger">'.$link->label.'</a>';
																}
															?>
														</div>
													</div>
												</div>
											</li>
										<?php
											}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		-->
	</div>
</div>

<br />
<?php 
}
?>

<?php Yii::app()->clientScript->registerScript('viewScript',
<<<JS
$(window).load(function() {
	var max;
	$('.row-fluid, .row').each(function() {
		max = -1;
		$(this).find("[class$='thumbnail']").each(function() {
			var h = $(this).height(); 
			max = h > max ? h : max;
		});
		
		$(this).find("[class$='thumbnail']").each(function() {
			$(this).css({'min-height': max});
		});
	});
});
JS
, CClientScript::POS_READY);
?>