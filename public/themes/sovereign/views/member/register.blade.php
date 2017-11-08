@extends("layout")
@section("content")
@include("member2.include_register")
<!-- Modal -->
<div class="modal fade modal-agreement" id="modal_agreement" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">Accept Sovereign Privacy Policy</div>
            <div class="modal-body">
                <div class="contract">
                	<div class="header">Privacy Policy</div>
                	<div class="introduction">
	            		<div class="title">Introduction</div>
	                	<div class="para-container">
	                		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, magnam nam maxime, fugiat atque voluptatum pariatur molestias quibusdam provident vero.</p>
	                		<p>Accusamus autem architecto, consequuntur repellendus ducimus nostrum qui, impedit asperiores, error quibusdam possimus, tempore? Harum facere veritatis alias esse dolore?</p>
	                		<p>Cumque perspiciatis beatae eveniet, iusto a eum placeat sint nihil nisi fugiat praesentium sapiente dolores consequuntur, quos consectetur explicabo unde!</p>
                	</div>
					
					<div class="personal-info">
						<div class="title">Personal Information</div>
						<div class="para-container">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi quos pariatur eum fugit amet debitis nisi et iusto illum, mollitia aspernatur eius voluptates sapiente provident, aperiam nulla voluptatibus! Nesciunt, dolores rerum. Tempore saepe officia vero perspiciatis eligendi mollitia accusamus, aperiam, sequi esse, dolor qui enim repellendus rerum. Molestias distinctio sapiente pariatur tenetur maiores vitae perspiciatis voluptatum ab non modi, veritatis debitis quasi dolor neque excepturi corporis odio placeat consectetur impedit culpa dignissimos assumenda atque ducimus minima. Provident quasi laboriosam consequatur in aut cumque libero aliquam adipisci. Vero a rem assumenda, rerum porro nihil obcaecati, mollitia, eum atque, dolore deleniti nesciunt?</p>
							<ol>
								<li>Record-keeping;</li>
								<li>Send instructive and promotional email about new products or other information which we think you may find interesting. </li>
								<li>For market research purposes</li>
								<li>Or we may use the information to customize the website according to your requirements</li>
							</ol>
						</div>
					</div>

					<div class="share-protect">
						<div class="title">Sharing and Protecting your Information</div>
						<div class="para-container">
							<p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt ab neque magni aperiam atque alias, accusantium excepturi id, iste qui.</span><span>Fuga provident quidem enim fugiat doloremque iste laudantium reiciendis eius quas voluptatem quae rerum voluptate, perferendis delectus, rem labore! Deserunt?</span></p>
						</div>
					</div>
                	
					<div class="contact-us">
						<div class="title">Contact Us</div>
						<div class="para-container">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus nam iste optio deleniti laboriosam qui nobis totam voluptatibus reprehenderit necessitatibus sit, libero fugit corporis placeat eos et, neque atque cupiditate deserunt molestiae quam asperiores suscipit sapiente, voluptas! Possimus impedit quidem eum odit perferendis. Earum excepturi rem suscipit veritatis aspernatur dolorem.</p>
						</div>
					</div>

					<div class="disclaimer">
						<div class="title">Disclaimer</div>
						<div class="para-container">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo, id, optio ex vero eius pariatur neque, quas voluptate natus eaque perspiciatis mollitia consectetur voluptates reiciendis perferendis fugiat recusandae aperiam quasi!</p>
						</div>
					</div>

					<div class="dealers-policy">
						<div class="title">Dealers Policy:</div>
						<div class="para-container">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic ut officia minus. Impedit in, laudantium!</p>
							<ol>
								<li><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia porro minus nam libero fugiat ipsum adipisci. Doloremque delectus, error ipsum.</p></li>
								<li><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur nemo, quaerat at veniam quia a. Tempore voluptatum beatae recusandae incidunt!</p></li>
								<li><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur voluptatem, perferendis id. Laboriosam iure magni, vitae omnis quisquam cumque aspernatur!</p></li>
								<li>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore aperiam, enim laboriosam officiis doloremque doloribus ipsum. Ducimus repellendus, nemo commodi.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti minus aut ipsum qui molestias consectetur autem, excepturi officiis nisi officia.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab ex sequi possimus debitis sunt quam sit nihil, minus! Quas, mollitia culpa. Eos aut architecto nulla impedit nesciunt cumque accusamus modi praesentium non vero possimus repellendus ex porro, illo neque assumenda adipisci sit iusto nam. Quisquam doloremque sunt sequi praesentium libero?</p>
								</li>
							</ol>
						</div>
					</div>
                </div>
            </div>
            <div class="modal-footer">
            	<button type="submit" class="btn btn-pure pull-right" data-dismiss="modal">Accept</button>
                <button type="submit" class="btn btn-semi pull-right" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/member_register.js"></script>
<script type="text/javascript" src="/assets/member/js/google_script/google_script_auth.js"></script>

<script>startApp();</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_register.css">
@endsection