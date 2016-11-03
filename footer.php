 </div>
      </div>
    </div>
	<style>
	.form-horizontal .form-group {
    margin-right: 0px;
    margin-left: 0px;
}
	</style>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
    <script src="js/ChartNew.js"></script>
	<script>


	$(function () {
		var srednjatemplate = $("#restrictionaction .timeframe:first").clone();
		var srednjaCount = <?php echo $ukupno;?>;


		$(".action").on( "change", function(e)
		{
			if($(this).val()=='allday')
			{
				$(this).parent().next().next().next().find( ".timefrom" ).val("00:00") ;
				$(this).parent().next().next().next().next().find( ".timeto" ).val("23:59") ;
			}
		})

		$('body').on('change',".action", function(){
			if($(this).val()=='allday')
			{
				$(this).parent().next().next().next().find( ".timefrom" ).val("00:00") ;
				$(this).parent().next().next().next().next().find( ".timeto" ).val("23:59") ;
			}
		})

		$(".remove").on( "click", function(e)
		{
			e.preventDefault();
			$(this).closest("tr").remove();
		})

		$(".addtime").on( "click", function(event) {

			srednjaCount++;
			var order = srednjatemplate.clone().find("*").each(function(){
				var newId = this.id.substring(0, this.id.length-1) + srednjaCount;

				if(this.name!=undefined)
				{
					var ime="restrictionaction["+srednjaCount+this.name.substring(19,this.name.length);
					this.name = ime;
					this.value = '';
				}
				if($(this).attr("id"))
				{
					this.id = newId; // update id
				}
				if($(this).parent().prev().attr("for"))
				{
					$(this).parent().prev().attr("for", newId); // update label for
				}

			}).end()
			.attr("id", "ord" + srednjaCount)
			.appendTo("#restrictionaction");
			return false;
		});

		$('body').on('mouseover',".datetimepicker6", function(){
			$(this).datetimepicker({
					format:'YYYY-MM-DD'
				});
		})
		$('body').on('mouseover',".datetimepicker7", function(){
			$(this).datetimepicker({
					format:'YYYY-MM-DD'
				});
		})
		$('body').on('mouseover',".datetimepicker3", function(){
			$(this).datetimepicker({
					format:'HH:ss'
				});
		})
		$('body').on('mouseover',".datetimepicker4", function(){
			$(this).datetimepicker({
					format:'HH:ss'
				});
		})
		$('body').on('click',".remove", function(){

			$(this).closest("tr").remove();
			return false;

		})

				$('.datetimepicker6').datetimepicker(
				{
					format:'YYYY-MM-DD'
				});
				$('.datetimepicker7').datetimepicker({
					format:'YYYY-MM-DD',
					useCurrent: false //Important! See issue #1075
				});

				$('.datetimepicker3').datetimepicker(
				{
					format:'HH:ss'
				});
				$('.datetimepicker4').datetimepicker({
					format:'HH:ss',
					useCurrent: false //Important! See issue #1075
				});


            });
	</script>
  </body>
</html>
