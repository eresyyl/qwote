<div class="font-size-30 blue-grey-700 margin-bottom-20">
	Review from <?php echo $clientData->first_name; ?>&nbsp;<?php echo $clientData->last_name; ?>:
</div>																
<div class="chat chat-head">
	<div class="chat-avatar">
		<a class="avatar">
			<img src="<?php echo $clientData->avatar ;?>">
		</a>
	</div>
	<div class="chat-body">
		<div class="chat-content text-left">
			<div class="margin-bottom-5">
				<strong style="font-weight:normal;"><?php echo $clientData->first_name; ?>&nbsp;<?php echo $clientData->last_name; ?></strong> 
			</div>
			<div class="br-theme-fontawesome-stars">
				<div class="br-widget rating rating-lg" data-score="<?php echo $reviewData['rating']; ?>" data-plugin="rating">
					<?php for($i = 1; $i <=5; $i++): ?>
						<a 
							data-alt="<?php echo $i; ?>" 
							class="<?php if($i <= $reviewData['rating'] ): ?>br-selected<?php endif; ?>
						"></a>
					<?php endfor; ?>
					<input name="score" type="hidden" value="<?php echo $reviewData['rating']; ?>">
				</div>
			</div>
			<p><?php echo $reviewData['review']; ?></p>
		</div>
	</div>
</div>