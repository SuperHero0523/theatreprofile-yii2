<li>
	<div class="media">
		<a href="<?php echo $data->show->createUrl(); ?>" class="pull-left">
			<?php
			$profile_image=Profileimage::model()->with('image')->find('profileType=1 AND profileID='.$data->show->id);
			if(isset($profile_image->image->imageURL))
			{
				$image_url=Yii::app()->params["mediaServeUrl"].'/images/serve/uploads/'.pathinfo($profile_image->image->imageURL,PATHINFO_FILENAME).'_w28h44.'.pathinfo($profile_image->image->imageURL,PATHINFO_EXTENSION);
			}else
			{
				$image_url=yii::app()->request->baseUrl.'/images/default/default_28x44.gif';
			}
			?>

			<img class="media-object" src="<?php echo $image_url; ?>" width="28px" height="44px" alt="">
		</a>
		
		<div class="media-body">
			<div class="media-heading">
				<a href="<?php echo $data->show->createUrl(); ?>"><?php echo $data->show->showName; ?></a>
				<?php
					echo " <a class='btn' rel='tooltip' data-placement='right' title='View profile statistics.' href='".yii::app()->createUrl('/show/analytics',array('id'=>$data->show->id))."'><i class='icon-info-sign icon-red'></i></a>";
					$book='';
					$music='';
					$lyrics='';
					foreach($data->show->showcreators as $creator)
					{
						$name = $creator->individual->firstName.' '.$creator->individual->middleName.' '.$creator->individual->lastName.' '.$creator->individual->suffix;
						switch($creator->role->roleName)
						{
							case "Book":$book = $book.'<span><a href="'.$creator->individual->createUrl().'">'.trim($name).'</a></span>, ';break;
							case "Lyrics":$lyrics = $lyrics.'<span><a href="'.$creator->individual->createUrl().'">'.trim($name).'</a></span>, ';break;
							case "Music":$music = $music.'<span><a href="'.$creator->individual->createUrl().'">'.trim($name).'</a></span>, ';break;
							default:break;
						}
					}
					$book = substr($book, 0, -2);
					$music = substr($music, 0, -2);
					$lyrics = substr($lyrics, 0, -2);
					$showInfo=empty($book)?'':'Book: '.$book;
					$showInfo=empty($showInfo)?empty($music)?'':'Music: '.$music:$showInfo.(empty($music)?'':', Music: '.$music);
					$showInfo=empty($showInfo)?empty($lyrics)?'':'Lyrics: '.$lyrics:$showInfo.(empty($lyrics)?'':', Lyrics: '.$music);
					echo '<br />'.$showInfo;
					?>
			</div>
		</div>
	</div>
</li>