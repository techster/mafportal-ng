<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<section class="SinleNewsPage">
    <div class="container">
        <!--[ TITLE ]-->
        @if($live->title)
            <div style="text-align: center;" class="NewsTitle">{{$live->title}}</div>
    @endif
    <!--[ CONTENT ]-->
        <div class="ContWr">
		
		

            <!--[ Live ]-->
            @if($live->live)
                <div class="MainCont" style="text-align: center;">{!! $live->live !!}</div>

            @elseif(!$live->live)
                
				
				@if($live->slug == "8th-annual-maf-world-cup")
				<div style="text-align:center;">
					
					<iframe width="560" height="315" src="https://www.youtube.com/embed/WMKMmDQ6Gxg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				@else
					<h3 style="text-align: center;">{{trans('tournaments.no_live')}}</h3>
				@endif
				
				
            @endif
			
			



        </div>

    </div>
</section>
